<?php $this->view('includes/header'); ?>
<memberSidenav>
    <div class="app-content">
        <div class="container">
            <a href="<?= ROOT ?>/courier">
                <!-- <span class="material-symbols-outlined">book_5</span> -->
                Dashboard
            </a>
            <a href="<?= ROOT ?>/courier/profile">
                <!-- <span class="material-symbols-outlined">person</span> -->
                Profile
            </a>
            <a href="<?= ROOT ?>/courier/changePassword">
                <!-- <span class="material-symbols-outlined">passkey</span> -->
                Change Password
            </a>
            <a href="<?= ROOT ?>/courier/completedOrders">
                <!-- <span class="material-symbols-outlined">sync_alt</span> -->
                Completed Orders
            </a>
            <a href="<?= ROOT ?>/courier/ongoingOrders">
                <!-- <span class="material-symbols-outlined">logout</span> -->
                Ongoing Orders
            </a>
        </div>
</memberSidenav>
<div class="container">