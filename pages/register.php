<?php

session_start();
require_once '../functions/connect.php';
require_once "../functions/check_status.php";
$dbc = get_dbc();
$err = '';

if (empty($_SESSION['auth'])) {
    if ( ! empty($_POST['login']) && ! empty($_POST['password'])) {
        $login    = $_POST['login'];
        $password = $_POST['password'];
        
        $query     = "SELECT * FROM users WHERE login='$login'";
        $result    = mysqli_query($dbc, $query);
        $same_user = mysqli_fetch_assoc($result);
        
        if (empty($same_user)) {
            $query
                = "INSERT INTO users (login, password, role) VALUES ('$login', '$password', 'user')";
            mysqli_query($dbc, $query);
            
            $_SESSION['auth']  = true;
            $_SESSION['login'] = $login;
            header('Location: index.php');
        } else {
            $err = 'Пользователь с таким именем уже существует';
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
  <title>Регистрация</title>
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
  <form class="form" method="post">
    <h1>Регистрация</h1>
    <label class="form__label">
      <span>Логин</span>
      <input type="text" name="login" minlength="4" maxlength="10" required>
        <?php
        if ($err != '') {
            echo '<span class="form__error">'.$err.'</span>';
        }
        ?>
    </label>
    <label class="form__label">
      <span>Пароль</span>
      <input type="password" name="password" minlength="8" maxlength="16"
             required>
    </label>
    <button class="form__button" type="submit">Регистрация</button>
  </form>
  <p class="reg-link">Уже есть аккаунт? <a
      href="login.php">Войти</a></p>
</main>
<script src="../js/nav-toggle.js"></script>
</body>
</html>