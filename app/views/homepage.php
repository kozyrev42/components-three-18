<html>
<head>
    <title><?=$this->e($title)?></title>
</head>
<body>
    <h3>Homepage</h3>
    <nav>
        <ul>
            <li><a href="/home">Homepage</a></li>
            <li><a href="/about">Abote</a></li>
        </ul>
    </nav>
    <?=$this->section('content')?>

    <?php //d($postsInView); exit;
    foreach($postsInView as $post):?>
        <?php echo $post['email']?> <br>
    <?php endforeach;?>
</body>
</html>