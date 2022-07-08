<html>
<head>
    <title><?=$this->e($title)?></title>
</head>
<body>
    <h3>About</h3>
    <nav>
        <ul>
            <li><a href="/home">Homepage</a></li>
            <li><a href="/about">Abote</a></li>
        </ul>
    </nav>
    <?=$this->section('content')?>
</body>
</html>