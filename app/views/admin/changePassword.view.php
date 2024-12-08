<?php $this->view("admin/includes/sidenav") ?>
<?php if (error()) : ?>
    <div class="error" style="font-size: 1.5rem; background-color:#f2575f; color:white; border-radius:4px; text-align:center; "><?= error('', true) ?></div>
<?php endif; ?>
<changePassword>
    <h1 class="title">Change Password</h1>
    <form class="frm-add-book" method="post">
        <div class="form-field">
            <label>Current Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-field">
            <label>New Password</label>
            <input type="password" name="new_password" required pattern=".{8,}">
        </div>
        <div class="form-field">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>
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
<?php $this->view('includes/footer'); ?>