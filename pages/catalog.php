<?php

session_start();

require_once '../functions/connect.php';
require_once "../functions/check_status.php";

$dbc = get_dbc();

$category = $_GET['category'];
$query    = "SELECT * FROM catalog WHERE category = '$category'";
$result   = mysqli_query($dbc, $query);
$cards    = $result -> fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../styles/style.css">
  <title>Меню</title>
</head>
<body>
<header class="header">
  <button class="nav-toggle">Нажмите на шторку для открытия/закрытия меню</button>
  <div class="header__wrapper">
    <div class="header__inner-wrapper">
      <a class="header__logo" href="index.php">SeaFood</a>
      <nav class="header__nav nav">
        <ul class="nav__list">
          <li class="nav__item">
            <a class="nav__link" href="index.php">О нас</a>
          </li>
          <li class="nav__item">
            <a class="nav__link nav__link--disabled"
               href="index.php#menu">Меню</a>
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
  <section class="catalog">
    <div class="catalog__wrapper">
      <h2 class="visually-hidden">Каталог</h2>
      <div class="catalog__links-line">
        <a class="catalog__link" href="index.php">Главная</a>
        <a class="catalog__link catalog__link--disabled">Меню</a>
      </div>
      <div class="catalog__tabs tabs">
        <div class="tabs__buttons-wrapper">
          <a href="?category=seafood" class="tabs__button <?php
          if ($category == 'seafood') {
              echo 'tabs__button--active';
          }
          ?>">Блюда из морепродуктов</a>
          <a href="?category=dessert" class="tabs__button <?php
          if ($category == 'dessert') {
              echo 'tabs__button--active';
          }
          ?>">Десерты</a>
        </div>
        <div class="tabs__content">
          <ul class="cards">
              <?php
              foreach ($cards as $card) {
                  ?>
                <li class="card">
                  <div class="card__image">
                    <img src="../assets/img/<?= $card['img_name'] ?>" alt=""
                         width="285"
                         height="285">
                  </div>
                  <h3><?= $card['name'] ?></h3>
                  <b><?= $card['price'] ?> руб</b>
                  <a class="card__button"
                     href="../functions/add_to_card.php?id=<?= $card['product_id'] ?>&category=<?= $category ?>">
                    В корзину
                  </a>
                </li>
                  <?php
              }
              ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
</main>
<script src="../js/nav-toggle.js"></script>
</body>
</html>
