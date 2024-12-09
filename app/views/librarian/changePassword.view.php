<?php $this->view('librarian/includes/sidenav') ?>
<?php if (message()): ?>

    <div class="<?= isset($_SESSION['message_class']) ? $_SESSION['message_class'] : 'alert'; ?>">
        <?= message('', true) ?>
    </div>
    <?php unset($_SESSION['message_class']); ?>

<?php endif; ?>
<changePassword>
    <h1 class="title">Change Password</h1>
    <form class="frm-add-book" method="post">
        <div class="form-field">
            <label>Current Password</label>
            <input type="password" name="password" value="<?= $data['user']->password ?? '' ?>">
            <?php if (!empty($errors['password'])) : ?>
                <div class="error"><?= $errors['password'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>New Password</label>
            <input type="password" name="new_password" value="<?= $data['user']->new_password ?? '' ?>">
            <?php if (!empty($errors['new_password'])) : ?>
                <div class="error"><?= $errors['new_password'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" value="<?= $data['user']->confirm_password ?? '' ?>">
            <?php if (!empty($errors['confirm_password'])) : ?>
                <div class="error"><?= $errors['confirm_password'] ?></div>
            <?php endif; ?>
        </div>

        <p class="form-error"></p>
        <p>
            <button type="submit" class="add-btn">
                <span class="material-symbols-outlined">passkey</span>
                Update Password
            </button>
        </p>


    </form>
</changePassword>


<?php $this->view('member/includes/footer'); ?>