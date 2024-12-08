<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/elibrary/style.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/elibrary/rate-review.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/elibrary/favourite.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/elibrary/notification.css">
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

        <?php if (auth::getrole() == 'member') : ?>
            <span class="nav">
                <a href="<?= ROOT ?>/elibrary">Home</a>
                <a href="<?= ROOT ?>/elibrary/search">E - Books</a>
                <a href="<?= ROOT ?>/librarian/subscriptionHome">Subscription</a>
                <a href="<?= ROOT ?>/">Book Exchange</a>
                <!-- <a href="<?= ROOT ?>/aboutUs">About Us</a> -->
            </span>
        <?php endif; ?>
        <?php if (!(Auth::logged_in())) : ?>
            <a href="<?= ROOT ?>/signup" class="profile guestsection">Sign&nbsp;Up</span></a>
            &nbsp;
            &nbsp;
            &nbsp;
            <a href="<?= ROOT ?>/login" class="profile guestsection">Login</span></a>
        <?php else : ?>
            <a href="<?= ROOT ?>/member/profile" class="profile usersection"><span userinfo="first_name"><?= Auth::getUsername() ?></span></a>
            <?php if (auth::getrole() == 'member') : ?>

                <span>
                    <div class="nf-all">
                        <div class="nf-area">
                            <button class="btn-noti" id="nf-btn"><i class="fas fa-bell"></i></button>
                            <span id="nf-n">0</span>
                        </div>
                        <div class="nf-message" id="notifications">Nothing</div>
                    </div>
                </span>

                <div class="usersection">
                    <a href="<?= ROOT ?>/elibrary/favourite_list" class="favorite-btn">
                        <i class="far fa-heart"></i>
                        <span class="badge" userinfo="favorites" id="nf-t">0</span>
                    </a>
                </div>

            <?php endif; ?>
            <div class="adminsection">
                <a href="<?= ROOT ?>/logout" class="cart-btn">
                    <span class="material-symbols-outlined">logout</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            function fetchFavoriteCount() {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "<?= ROOT ?>/elibrary/get_favorite_count_endpoint", true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.favorite_count !== undefined) {

                            document.querySelector('.badge[userinfo="favorites"]').textContent = response.favorite_count;
                        }
                    } else {
                        console.error("Error fetching favorite count.");
                    }
                };
                xhr.send();
            }


            fetchFavoriteCount();
        });
    </script>
    <script src="<?= ROOT ?>/assets/js/notification.js"></script>