<?php

session_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/funcs.php';

if (isset($_POST['register'])) {
    registration();
    header('Location: index.php');
    die;
}

if (isset($_POST['auth'])) {
    login();
    header('Location: index.php');
    die;
}

if (isset($_POST['add'])) {
    save_message();
    header('Location: index.php');
    die;
}

if (isset($_GET['do']) && $_GET['do'] == 'exit') {
    if (!empty($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    header('Location: index.php');
    die;
}

$messages = get_messages();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Guest Book</title>
</head>
<body>

    <div class="container">

        <div class="row my-3">
            <div class="col">
                <?php if (!empty($_SESSION['errors'])):?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['errors'];
                        unset($_SESSION['errors']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif;?>
                
                <?php if (!empty($_SESSION['success'])):?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif;?>
            </div>
        </div>
        
        <?php if (empty($_SESSION['user']['name'])):?>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h3>Регистрация</h3>
                </div>
            </div>

            <form action="index.php" method="POST" class="row g-3">
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="login" class="form-control" id="floatingInput" placeholder="Имя">
                        <label for="floatingInput">Имя</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating">
                        <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Пароль">
                        <label for="floatingPassword">Пароль</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" name="register" class="btn btn-primary">Зарегистрироваться</button>
                </div>
            </form>

            <div class="row mt-3">
                <div class="col-md-6 offset-md-3">
                    <h3>Авторизация</h3>
                </div>
            </div>
            
            <form action="index.php" method="POST" class="row g-3">
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="login" class="form-control" id="floatingInput" placeholder="Имя">
                        <label for="floatingInput">Имя</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating">
                        <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Пароль">
                        <label for="floatingPassword">Пароль</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" name="auth" class="btn btn-primary">Войти</button>
                </div>
            </form>

        <?php else:?>

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['user']['name'])?>! <a href="?do=exit">Выйти</a></p>
                </div>
            </div>

            <form action="index.php" method="POST" class="row g-3 mb-5">
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating">
                        <textarea class="form-control" name="message" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px;"></textarea>
                        <label for="floatingTextarea">Сообщение</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" name="add" class="btn btn-primary">Отправить</button>
                </div>
            </form>

        <?php endif;?>

        <?php if (!empty($messages)):?>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <hr>
                    <?php foreach ($messages as $message):?>
                        <div class="card my-3">
                            <div class="card-body">
                                <h5 class="card-title">Автор: <?= htmlspecialchars($message['name'])?></h5>
                                <p class="card-text"><?= htmlspecialchars($message['message'])?></p>
                                <p>Дата: <?= $message['created_at']?></p>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endif;?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>