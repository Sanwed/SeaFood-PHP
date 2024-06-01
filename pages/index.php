<?php

session_start();
require_once '../functions/connect.php';
require_once "../functions/check_status.php";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../styles/style.css">
  <title>Главная</title>
</head>
<body>
<header class="header">
  <button class="nav-toggle">Нажмите на шторку для открытия/закрытия меню
  </button>
  <div class="header__wrapper">
    <div class="header__inner-wrapper">
      <a class="header__logo">SeaFood</a>
      <nav class="header__nav nav">
        <ul class="nav__list">
          <li class="nav__item">
            <a class="nav__link nav__link--disabled">О нас</a>
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
  <section class="about" id="about">
    <div class="about__wrapper">
      <div class="about__images">
        <div class="about__image">
          <img src="../assets/img/hero-1.png" alt="Морское блюда" width="150"
               height="400">
        </div>
        <div class="about__image">
          <img src="../assets/img/hero-2.png" alt="Морское блюда" width="150"
               height="400">
        </div>
        <div class="about__image">
          <img src="../assets/img/hero-3.png" alt="Морское блюда" width="150"
               height="400">
        </div>
      </div>
      <h1>SeaFood - Ресторан с самой свежей рыбой в Димитровграде</h1>
      <div class="about__columns">
        <div class="about__text-wrapper">
          <p class="about__text">Вы сделаете заказ, мы выловим рыбу из аквариума
            на нашей кухне и приготовим вам самое
            свежее блюдо в городе.</p>
          <p class="about__text">Вы также можете заказать блюда из рыбы и
            морепродуктов с доставкой на дом или в офис
            из нашего ресторана.</p>
        </div>
        <div class="about__text-image">
          <img src="../assets/img/about-fish.png" alt="" width="285"
               height="100" aria-hidden="true">
        </div>
      </div>
    </div>
  </section>
  <section class="menu" id="menu">
    <div class="menu__wrapper">
      <div class="menu__columns">
        <h2>Menu</h2>
        <div class="menu__links">
          <a class="menu__link" href="catalog.php?category=seafood">
            <div class="menu__image">
              <img src="../assets/img/menu-1.png" alt="Блюда из морепродуктов">
            </div>
            <h3>Блюда из морепродуктов</h3>
          </a>
          <a class="menu__link" href="catalog.php?category=dessert">
            <div class="menu__image">
              <img src="../assets/img/menu-2.png" alt="Десерты">
            </div>
            <h3>Десерты</h3>
          </a>
        </div>
      </div>
    </div>
  </section>
</main>
<script src="../js/nav-toggle.js"></script>
</body>
</html>
