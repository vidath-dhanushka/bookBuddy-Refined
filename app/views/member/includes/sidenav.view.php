<?php $this->view('includes/header'); ?>
<memberSidenav>
    <div class="app-content">
        <div class="container">
            <a href="<?= ROOT ?>/member/profile">
                <!-- <span class="material-symbols-outlined">person</span> -->
                Profile
            </a>
            <a href="<?= ROOT ?>/member/changePassword">
                <!-- <span class="material-symbols-outlined">passkey</span> -->
                Change Password
            </a>
            <a href="<?= ROOT ?>/member/lended">
                <!-- <span class="material-symbols-outlined">book_5</span> -->
                My Books
            </a>
            <a href="<?= ROOT ?>/member/borrowed">
                <!-- <span class="material-symbols-outlined">sync_alt</span> -->
                My Borrowings
            </a>
            <a href="<?= ROOT ?>/elibrary/borrowing">
                <!-- <span class="material-symbols-outlined">sync_alt</span> -->
                E - Book Borrowings
            </a>
            <a href="<?= ROOT ?>/elibrary/subscription">
                <!-- <span class="material-symbols-outlined">sync_alt</span> -->
                Subscription
            </a>
            <a href="<?= ROOT ?>/logout">
                <!-- <span class="material-symbols-outlined">logout</span> -->
                Logout
            </a>
        </div>
        <div class="container">