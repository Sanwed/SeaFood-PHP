<?php

require_once '../functions/connect.php';
require_once "../functions/check_status.php";

session_start();

$dbc = get_dbc();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../styles/style.css">
  <title>Корзина</title>
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
            <a class="nav__link nav__link--disabled" href="basket.php">Корзина
              <b>
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
  <section class="basket">
    <div class="basket__wrapper">
      <h1>Корзина</h1>
      <ul class="basket__list">
          <?php
          $total = 0;
          
          if ( ! empty($_SESSION['basket'])) {
              foreach ($_SESSION['basket'] as $value) {
                  $id      = $value['id'];
                  $amount  = $value['amount'];
                  $query   = "SELECT * FROM catalog WHERE product_id = '$id'";
                  $result  = mysqli_query($dbc, $query);
                  $product = mysqli_fetch_assoc($result);
                  
                  $total += $product['price'] * $amount;
                  ?>
                <li class="basket__item">
                  <a class="basket__delete"
                     href="../functions/remove_from_card.php?id=<?= $product['product_id'] ?>"></a>
                  <div class="basket__amount">
                    <a
                      class="basket__amount-button basket__amount-button--decrease <?php
                        if ($amount === 1) {
                          echo 'basket__amount-button--disabled';
                        }
                      ?>"
                      href="../functions/decrease_amount.php?id=<?= $product['product_id'] ?>"></a>
                    <span><?= $amount ?></span>
                    <a
                      class="basket__amount-button basket__amount-button--increase"
                      href="../functions/increase_amount.php?id=<?= $product['product_id'] ?>"></a>
                  </div>
                  <h3><?= $product['name'] ?></h3>
                  <b><?= $product['price'] ?>&nbsp;руб</b>
                </li>
                  <?php
              }
          } else {
              ?>
            <p>В корзине нет товаров. Добавьте их в <a
                href="catalog.php?category=seafood">каталоге</a></p>
              <?php
          }
          ?>
      </ul>

      <p>Общая стоимость: <?= $total ?> руб</p>
    </div>
    <a class="basket__button <?php
    if (empty($_SESSION['basket'])) {
        echo 'basket__button--disabled';
    }
    ?>" href="../functions/add_to_admin_check.php">Оформить заказ</a>
  </section>
</main>
<script src="../js/nav-toggle.js"></script>
</body>
</html>