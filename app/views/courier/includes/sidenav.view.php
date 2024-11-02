<?php $this->view('includes/header'); ?>
<memberSidenav>
    <div class="app-content">
        <div class="container">
            <a href="<?= ROOT ?>/admin">
                <!-- <span class="material-symbols-outlined">book_5</span> -->
                Dashboard
            </a>
            <a href="<?= ROOT ?>/admin/profile">
                <!-- <span class="material-symbols-outlined">person</span> -->
                Profile
            </a>
            <a href="<?= ROOT ?>/admin/changePassword">
                <!-- <span class="material-symbols-outlined">passkey</span> -->
                Change Password
            </a>
            <a href="<?= ROOT ?>/admin/courier">
                <!-- <span class="material-symbols-outlined">sync_alt</span> -->
                Couriers
            </a>
            <a href="<?= ROOT ?>/admin/librarian">
                <!-- <span class="material-symbols-outlined">logout</span> -->
                Librarians
            </a>
        </div>
</memberSidenav>
<div class="container">