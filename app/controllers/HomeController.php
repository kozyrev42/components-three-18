<?php
namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;
use Exception;
use App\exceptions\NotMoneyException;
use App\exceptions\AccountBlockedException;

class HomeController
{
    private $templates;
    public function __construct()
    {
        // создаём Экземпляр видов, для дальнейшего использования его методов
        $this->templates = new Engine('../app/views','php'); // передаём путь до моих Видов в views
    }

    public function index($vars)
    {
        // объект подключения к базе
        $db = new QueryBuilder();

        $posts = $db->getAll('email_list');
        //d($posts);exit;
        // Render a template
        echo $this->templates->render('homepage', ['postsInView' => $posts]); // в вид передаём результат вызова из базы ['posts' => $posts]
    }

    public function about($vars)
    {
        //d($vars['cash']);
        // попробуем отловить Ошибку-Исключение
        
        try {
            // вызов функции, может выбросить Исключение
            $this->throwException($vars['cash']);
        } catch (NotMoneyException $exception) { // ловим исключение, в $exception - храниться информация по выброшеному Исключению
            // реагируем, если исключение выброшено 
            echo $exception->getMessage();
            // отлов уже другого исключения
        } catch (AccountBlockedException $exception) { // ловим исключение
            // реагируем, если исключение выброшено 
            echo $exception->getMessage();
        }

        // Render a template
        echo $this->templates->render('about', ['name' => 'Jonathan about']);
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
