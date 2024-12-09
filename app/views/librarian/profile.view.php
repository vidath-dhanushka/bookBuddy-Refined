<?php $this->view('librarian/includes/sidenav'); ?>

<?php if (message()): ?>

    <div class="<?= isset($_SESSION['message_class']) ? $_SESSION['message_class'] : 'alert'; ?>">
        <?= message('', true) ?>
    </div>
    <?php unset($_SESSION['message_class']); ?>

<?php endif; ?>
<memberProfile>
    <h1 class="title">My Profile</h1>
    <form class="frm-add-book" method="POST">
        <div class="form-field">
            <label>Username</label>
            <input disabled type="text" name="username" value="<?= $data['user_data']->username ?>" required1>
        </div>
        <div class="form-field">
            <label>First Name</label>
            <input name="first_name" value="<?= $data['user_data']->first_name ?>" required1>
            <?php if (!empty($errors['first_name'])) : ?>
                <div class="error"><?= $errors['first_name'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?= $data['user_data']->last_name ?>" required1>
            <?php if (!empty($errors['last_name'])) : ?>
                <div class="error"><?= $errors['last_name'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Email</label>
            <input disabled type="text" name="email" value="<?= $data['user_data']->email ?>">
        </div>
        <div class="form-field">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= $data['user_data']->phone ?>" required1>
            <?php if (!empty($errors['phone'])) : ?>
                <div class="error"><?= $errors['phone'] ?></div>
            <?php endif; ?>
        </div>
        <p class="form-error"></p>
        <p>
            <button type="submit" class="add-btn">
                <!-- <span class="material-symbols-outlined">person</span> -->
                Update Profile
            </button>
        </p>


    </form>
</memberProfile>

<?php $this->view('member/includes/footer'); ?>