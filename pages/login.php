<?php

session_start();
require_once '../functions/connect.php';
require_once "../functions/check_status.php";
$dbc = get_dbc();
$err = '';

if (empty($_SESSION['auth'])) {
    if ( ! empty($_POST['login'])) {
        $login = $_POST['login'];
        
        $query  = "SELECT * FROM users WHERE login = '$login'";
        $result = mysqli_query($dbc, $query);
        $user   = mysqli_fetch_assoc($result);
        
        if (empty($user)) {
            $err = 'Неверный логин или пароль';
        } else {
            $password = $_POST['password'];
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['auth']  = true;
                $_SESSION['login'] = $login;
                header('Location: index.php');
            } else {
                $err = 'Неверный логин или пароль';
            }
        }
    }
} else {
    header('Location: index.php');
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../styles/style.css">
  <title>Вход</title>
</head>
<body>
<header class="header">
  <button class="nav-toggle">Нажмите на шторку для открытия/закрытия меню
  </button>
  <div class="header__wrapper">
    <div class="header__inner-wrapper">
      <a href="index.php" class="header__logo">SeaFood</a>
      <nav class="header__nav nav">
        <ul class="nav__list">
          <li class="nav__item">
            <a class="nav__link" href="index.php">О нас</a>
          </li>
          <li class="nav__item">
            <a class="nav__link" href="catalog.php?category=seafood">Меню</a>
          </li>
          <li class="nav__item">
            <a class="nav__link" href="basket.php">Корзина <b>
                    <?php
                    if ( ! empty($_SESSION['basket'])) {
                        if (count($_SESSION['basket']) > 0) {
                            echo count($_SESSION['basket']);
                        }
                    }
                    ?>
              </b>
            </a>
          </li>
            <?php
            $role = check_status();
            if ($role === 'admin') {
                ?>
              <li class="nav__item">
                <a class="nav__link"
                   href="admin.php">Админ-панель</a>
              </li>
                <?php
            }
            ?>
        </ul>
      </nav>
    </div>
    <div class="header__contacts">
      <span>ул. Пушкина, д. 52</span>
      <a href="tel:+70000000000">+7 (000) 000-00-00</a>
    </div>
  </div>
</header>
<main class="center">
  <form class="form" action="" method="POST">
    <h1>Вход</h1>
    <label class="form__label">
      <span>Логин</span>
      <input type="text" name="login" required>
    </label>
    <label class="form__label">
      <span>Пароль</span>
      <input type="password" name="password" required>
    </label>
      <?php
      if ($err != '') {
          echo '<span class="form__error">'.$err.'</span>';
      }
      ?>
    <button class="form__button" type="submit">Войти</button>
  </form>
  <p class="reg-link">Нет аккаунта? <a
      href="register.php">Зарегистрироваться</a></p>
</main>
<script src="../js/nav-toggle.js"></script>
</body>
</html>