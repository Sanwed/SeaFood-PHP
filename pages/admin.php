<?php

require_once '../functions/connect.php';
require_once "../functions/check_status.php";

$role = check_status();
if ($role === "user") {
    header("location: index.php");
}

session_start();

$dbc = get_dbc();

$query  = "SELECT * FROM orders WHERE status='waiting'";
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
  <title>Админ-панель</title>
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
                <a class="nav__link nav__link--disabled"
                   href="admin.php">Админ-панель</a>
              </li>
                <?php
            }
            ?>
        </ul>
      </nav>
        <?php
        if ( ! empty($_SESSION['auth'])) {
            echo '<a class="header__login" href="profile.php">'
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
  <section class="admin">
    <div class="admin__wrapper">
      <h1>Админ-панель</h1>
        <?php
        if (count($orders) === 0) {
            ?>
          <p>На данный момент нет заказов, ожидающих подтверждения</p>
            <?php
        } else {
            ?>
          <ul class="admin__list">
              <?php
              $counter = 1;
              foreach ($orders as $order) {
                  ?>
                <li class="admin__item order">
                  <div class="order__wrapper">
                    <h2>Заказ №<?= $order['id'] ?></h2>
                    <a class="order__link"
                       href="../functions/accept_order.php?id=<?= $order['id'] ?>">Принять</a>
                    <a class="order__link"
                       href="../functions/decline_order.php?id=<?= $order['id'] ?>">Отклонить</a>
                    <button class="order__button toggle-accordion" type="button"
                            data-accordion-button="<?= $counter ?>"></button>
                  </div>
                  <ul class="order__list" data-accordion-elem="<?= $counter ?>">
                      <?php
                      $order_items = explode(', ', $order['products']);
                      foreach ($order_items as $order_item) {
                          $query
                                  = "SELECT * FROM catalog WHERE product_id='$order_item'";
                          $result = mysqli_query($dbc, $query);
                          $row    = mysqli_fetch_assoc($result);
                          ?>
                        <li class="order__item">
                          <h3><?= $row['name'] ?></h3>
                          <b><?= $row['price'] ?> руб</b>
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