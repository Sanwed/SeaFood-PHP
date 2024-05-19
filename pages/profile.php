<?php

require_once '../functions/connect.php';
require_once "../functions/check_status.php";
session_start();

if (empty($_SESSION['auth'])) {
    header('Location: ../pages/login.php');
}

$dbc = get_dbc();

$login  = $_SESSION['login'];
$query  = "SELECT * FROM `users` WHERE login = '$login'";
$result = mysqli_query($dbc, $query);
$user   = mysqli_fetch_assoc($result);
$id     = $user['user_id'];

$query  = "SELECT * FROM orders WHERE user_id='$id'";
$result = mysqli_query($dbc, $query);
$orders = $result -> fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../styles/style.css">
  <title>Личный профиль</title>
</head>
<body>
<header class="header">
  <button class="nav-toggle">Нажмите на шторку для открытия/закрытия меню
  </button>
  <div class="header__wrapper">
    <div class="header__inner-wrapper">
      <a class="header__logo" href="index.php">SeaFood</a>
      <nav class="header__nav nav">
        <ul class="nav__list">
          <li class="nav__item">
            <a class="nav__link" href="index.php">О нас</a>
          </li>
          <li class="nav__item">
            <a class="nav__link"
               href="catalog.php?category=seafood">Меню</a>
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
        <?php
        if ( ! empty($_SESSION['auth'])) {
            echo '<a class="header__login header__login--disabled" href="profile.php">'
                .$_SESSION['login'].'</a>';
        } else {
            echo '<a class="header__login" href="login.php">Войти</a>';
        }
        ?>
    </div>
    <div class="header__contacts">
      <span>ул. Пушкина, д. 52</span>
      <a href="tel:+70000000000">+7 (000) 000-00-00</a>
    </div>
  </div>
</header>
<main>
  <section class="profile">
    <div class="profile__wrapper">
      <div class="profile__header">
        <h1>Личный профиль</h1>
        <a href="../functions/logout.php">Выйти из аккаунта</a>
      </div>
        <?php
        if (count($orders) === 0) {
            ?>
          <p>У вас еще нет ни одного заказа. Чтобы собрать свой первый заказ
            перейдите в <a href="catalog.php?category=seafood">каталог</a></p>
            <?php
        } else {
            ?>
          <ul class="profile__list">
              <?php
              $counter = 1;
              foreach ($orders as $order) {
                  ?>
                <li class="profile__item order">
                  <div class="order__wrapper">
                    <h2>Заказ №<?= $order['id'] ?></h2>
                      <?php
                      if ($order['status'] === 'waiting') {
                          echo '<p class="order__status order__status--waiting">Ожидает подтверждения</p>';
                      } elseif ($order['status'] === 'accepted') {
                          echo '<p class="order__status order__status--accepted">Подтвержден</p>';
                      } elseif ($order['status'] === 'declined') {
                          echo '<p class="order__status order__status--declined">Отклонен</p>';
                      }
                      ?>
                    <button class="order__button toggle-accordion" type="button"
                            data-accordion-button="<?= $counter ?>"></button>
                  </div>
                  <ul class="order__list" data-accordion-elem="<?= $counter ?>">
                      <?php
                      $order_items = explode(', ', $order['products']);
                      foreach ($order_items as $order_item) {
                          $order_array = explode('-', $order_item);
                          $id          = $order_array[0];
                          $amount      = $order_array[1];
                          $query
                                       = "SELECT * FROM catalog WHERE product_id='$id'";
                          $result      = mysqli_query($dbc, $query);
                          $row         = mysqli_fetch_assoc($result);
                          ?>
                        <li class="order__item">
                          <span><?= $amount ?></span>
                          <h3><?= $row['name'] ?></h3>
                          <b><?= $row['price'] * $amount ?>&nbsp;руб</b>
                        </li>
                          <?php
                      }
                      ?>
                  </ul>
                </li>
                  <?php
                  $counter++;
              }
              
              ?>
          </ul>
            <?php
        }
        ?>

    </div>
  </section>
</main>
<script src="../js/nav-toggle.js"></script>
<script src="../js/order_accordion.js"></script>
</body>
</html>