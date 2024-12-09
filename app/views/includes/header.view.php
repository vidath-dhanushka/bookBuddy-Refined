<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/librarian/subscription.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"   />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="app-header userheader">
        <a class="root" href="<?= ROOT ?>/">
            <img class="logo" src="<?= ROOT ?>/assets/images/logo.svg" alt="logo">
        </a>
        <div class="adminsection">
            <h2 class="role-title"></h2>
        </div>
        <?php if (auth::getrole() == 'member') : ?>
            <span class="nav">
                <a href="<?= ROOT ?>/">Home</a>
                <a href="<?= ROOT ?>/Books">Books</a>
                <a href="<?= ROOT ?>/elibrary">E-library</a>
                <a href="<?= ROOT ?>/aboutUs">About Us</a>
            </span>
        <?php endif; ?>
        <?php if (!(Auth::logged_in())) : ?>
            <div class="signup_login">
                <a href="<?= ROOT ?>/signup" class="profile guestsection">Sign&nbsp;Up</span></a>
                &nbsp;
                &nbsp;
                &nbsp;
                <a href="<?= ROOT ?>/login" class="profile guestsection">Login</span></a>
            </div>
        <?php else : ?>
            <?php switch (auth::getrole()):
                case 'member': ?>
                    <a href="<?= ROOT ?>/member/profile" class="profile usersection"><span userinfo="first_name"><?= Auth::getUsername() ?></span></a>
                    <span class="wallet usersection">Rs <span userinfo="balance"><?= Auth::getBalance() ?></span></span>
                    <div class="usersection">
                        <a href="<?= ROOT ?>/cart/viewCart" class="cart-btn">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            <span class="badge" userinfo="cart"></span>
                        </a>

                        <a href="<?= ROOT ?>/logout" class="cart-btn">
                            <span class="material-symbols-outlined">logout</span>
                        </a>

                    </div>
                    <?php break ?>
                <?php
                case "admin": ?>
                    <a href="<?= ROOT ?>/admin/profile" class="profile couriersection"><span userinfo="first_name"><?= Auth::getUsername() ?></span></a>

                    <a href="<?= ROOT ?>/logout" class="cart-btn-admin">
                        <span class="material-symbols-outlined">logout</span>
                    </a>

                    <?php break ?>
                <?php
                case 'courier': ?>
                    <a href="<?= ROOT ?>/courier/profile" class="profile couriersection"><span userinfo="first_name"><?= Auth::getUsername() ?></span></a>

                    <a href="<?= ROOT ?>/logout" class="cart-btn-admin">
                        <span class="material-symbols-outlined">logout</span>
                    </a>

                    <?php break ?>
                <?php
                case 'librarian': ?>
                    <a href="<?= ROOT ?>/librarian/profile" class="profile couriersection"><span userinfo="first_name"><?= Auth::getUsername() ?></span></a>
                    <a href="<?= ROOT ?>/logout" class="cart-btn-admin">
                        <span class="material-symbols-outlined">logout</span>
                    </a>

                    <?php break ?>
            <?php endswitch; ?>
        <?php endif; ?>
    </div>