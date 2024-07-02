<?php $this->view('includes/header'); ?>
<signUp>
    <div class="app-content login-component-container">
        <div class="main-container">
            <div class="subcontainer-left">
                <div class="logo">
                    <img src="<?= ROOT ?>/assets/images/logo.svg" alt="logo">
                </div>
                <div class="title">
                    <p>Sign up and discover a world of books</p>
                    <p>Join the <a href="<? ROOT ?>/">BOOK BUDDY</a> family</p>
                </div>
                <div class="login-img">
                    <img src="<?= ROOT ?>/assets/images/sign-up.svg">
                </div>
                <div class="title-bottom">
                    <p>Already have an account? <a href="<?= ROOT ?>/login">Sign in</a></p>
                </div>
            </div>
            <div class="signup-subcontainer-right">
                <h2>Sign up</h2>
                <div class="signup-form-data">
                    <form jsubmit="signupForm" method="POST">
                        <p class="form-error"></p>
                        <div class="details">
                            <label>First Name</label>
                            <input type="text" name="first_name" value="<?= set_value('first_name') ?>" required1>
                            <?php if (!empty($errors['first_name'])) : ?>
                                <div class="error"><?= $errors['first_name'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="details">
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="<?= set_value('last_name') ?>" required1>
                            <?php if (!empty($errors['last_name'])) : ?>
                                <div class="error"><?= $errors['last_name'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="details">
                            <label>Username</label>
                            <input type="text" name="username" value="<?= set_value('username') ?>" required1>
                            <?php if (!empty($errors['username'])) : ?>
                                <div class="error"><?= $errors['username'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="details">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= set_value('email') ?>" required1>
                            <?php if (!empty($errors['email'])) : ?>
                                <div class="error"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="details">
                            <label>Phone</label>
                            <input type="text" name="phone" pattern=".{9,12}" value="<?= set_value('phone') ?>" required1>
                            <?php if (!empty($errors['phone'])) : ?>
                                <div class="error"><?= $errors['phone'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="details">
                            <label>District</label>
                            <select name="address_district" class="district-list" required1>
                                <option value=""></option>
                                <option value="Ampara">Ampara</option>
                                <option value="Anuradhapura">Anuradhapura</option>
                                <option value="Badulla">Badulla</option>
                                <option value="Batticaloa">Batticaloa</option>
                                <option value="Colombo">Colombo</option>
                                <option value="Galle">Galle</option>
                                <option value="Gampaha">Gampaha</option>
                                <option value="Hambantota">Hambantota</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Kalutara">Kalutara</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Kegalle">Kegalle</option>
                                <option value="Killinochchi">Killinochchi</option>
                                <option value="Kurunegala">Kurunegala</option>
                                <option value="Mannar">Mannar</option>
                                <option value="Matale">Matale</option>
                                <option value="Matara">Matara</option>
                                <option value="Moneragala">Moneragala</option>
                                <option value="Mullaitivu">Mullaitivu</option>
                                <option value="Nuwara Eliya">Nuwara Eliya</option>
                                <option value="Polonnaruwa">Polonnaruwa</option>
                                <option value="Puttalam">Puttalam</option>
                                <option value="Ratnapura">Ratnapura</option>
                                <option value="Trincomalee">Trincomalee</option>
                                <option value="Vavuniya">Vavuniya</option>
                            </select>
                            <?php if (!empty($errors['address_district'])) : ?>
                                <div class="error"><?= $errors['address_district'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="details">
                            <label>Password</label>
                            <input type="password" name="password" pattern=".{8,}" value="<?= set_value('password') ?>" required1>
                            <?php if (!empty($errors['password'])) : ?>
                                <div class="error"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="details">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" pattern=".{8,}" value="<?= set_value('confirm_password') ?>" required1>
                            <?php if (!empty($errors['confirm_password'])) : ?>
                                <div class="error"><?= $errors['confirm_password'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="login-btn">
                            <button>Sign up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</signUp>
<script src="<?= ROOT ?>/assets/js/signup.js"></script>
<?php $this->view('includes/footer'); ?>