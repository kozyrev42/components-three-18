<?php
namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;
use Exception;
use App\exceptions\NotMoneyException;
use App\exceptions\AccountBlockedException;
use PDO;

class HomeController
{
    private $templates;
    private $auth;

    public function __construct()
    {
        // создаём Экземпляр видов, для дальнейшего использования его методов
        $this->templates = new Engine('../app/views','php'); // передаём путь до моих Видов в views

        // подключение к базе
        $db = new PDO("mysql:host=127.0.0.1;dbname=app3;charset=utf8", "root", "");
        
        // создание объекта, передача ему (подключение к базе), далее он подкючен к базе, им можно пользоваться
        $this->auth = new \Delight\Auth\Auth($db);
    }

    public function index($vars)
    {   
        //назначение роли Юзеру
        /* try {
            $this->auth->admin()->addRoleForUserById(3, \Delight\Auth\Role::ADMIN);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown user ID');
        }
        exit; */

        //выход из системы, удаление сессии
        //$this->auth->logOut();exit;
        

        // проверка роли Юзера
        d($this->auth->getRoles());exit;

        // проверка, вошел ли Юзер
        d($this->auth->isLoggedIn());exit;

        // получим емаил
        //$email = $auth->getEmail();
        d($this->auth->getEmail());exit;

        // объект подключения к базе
        $db = new QueryBuilder();
        $posts = $db->getAll('email_list');
        //d($posts);exit;
        // Render a template
        echo $this->templates->render('homepage', ['postsInView' => $posts]); // в вид передаём результат вызова из базы ['posts' => $posts]
    }

    // регистрация юзера в базе
    public function about($vars)
    {
        try {
            // $userId = $auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
            $userId = $this->auth->register('dd@dd.dd', 'dd', 'dd', function ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
            });
            
            // если ->register() - выполнится, выводим сообщение 
            echo 'Мы зарегистрировали нового пользователя с идентификатором ' . $userId;
        }
        // отлов ошибок Исключений
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

        // Render a template
        echo $this->templates->render('about', ['name' => 'Jonathan about']);
    }

    public function email_verification()
    {
        // код из документации компонента
        try {
            // метод получит 'selector' и 'token' из письма юзера, если совпадёт, то верифицирует Юзера в базе
            //$this->auth->confirmEmail($_GET['selector'], $_GET['token']);
            $this->auth->confirmEmail('DOH750z2iHpqwkuE', 'R7Eh3xVWp8tWnjbZ');

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    // метод входа
    public function login()
    {
        try {
            //$auth->login($_POST['email'], $_POST['password']);
            $this->auth->login('dd@dd.dd', 'dd');

            echo 'User is logged in';
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }










    //  функция создаёт Исключение при выполнении опредделённого условия
    public function throwException($hotim=null)
    {
        $total = 10;

        if($hotim>$total) {
            // ручной выброс Исключения
            
            throw new NotMoneyException("недостаточно средств сабака"); // передаём Экземпляру сообщение, чтобы вывести его в отлове, если этот Экземпляр исключения создасться
        }
    }
}
