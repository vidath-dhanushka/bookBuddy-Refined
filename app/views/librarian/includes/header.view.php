<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/librarian/table.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/elibrary/rate-review.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/librarian/subscription.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"   />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="app-header userheader">
        <a class="root" href="<?= ROOT ?>/">
            <img class="logo" src="<?= ROOT ?>/assets/images/logo.svg" alt="logo">
        </a>
        <div class="adminsection">
            <h2 class="role-title"></h2>
        </div>

        <?php if (auth::getrole() == 'librarian') : ?>
            <span class="nav">
                <a href="<?= ROOT ?>/">Home</a>
                <a href="<?= ROOT ?>/Books">Books</a>
                <a href="<?= ROOT ?>/elibrary">E-library</a>
                <a href="<?= ROOT ?>/aboutUs">About Us</a>
            </span>
        <?php endif; ?>
        <?php if (!(Auth::logged_in())) : ?>
            <a href="<?= ROOT ?>/signup" class="profile guestsection">Sign&nbsp;Up</span></a>
            &nbsp;
            &nbsp;
            &nbsp;
            <a href="<?= ROOT ?>/login" class="profile guestsection">Login</span></a>
        <?php else : ?>
            <a href="<?= ROOT ?>/librarian/profile" class="profile usersection"><span userinfo="first_name"><?= Auth::getUsername() ?></span></a>
            <div class="adminsection">
                <a href="<?= ROOT ?>/logout" class="cart-btn">
                    <span class="material-symbols-outlined">logout</span>
                </a>
            </div>
        <?php endif; ?>
    </div>