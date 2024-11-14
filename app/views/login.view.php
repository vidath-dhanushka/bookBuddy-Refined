<?php $this->view('includes/header') ?>
<login>
    <div class="app-content login-component-container">
        <div class="main-container">
            <div class="subcontainer-left">

                <div class="logo">
                    <img src="<?= ROOT ?>/assets/images/logo.svg" alt="logo">
                </div>
                <div class="title">
                    <p>Welcome Back</p>
                    <p>Join the <a href="<?= ROOT ?>/">BOOK BUDDY</a> family</p>
                </div>
                <div class="login-img">
                    <img src="<?= ROOT ?>/assets/images/login-bg.svg">
                </div>
                <div class="title-bottom">
                    <p>New to Book buddy? <a href="<?= ROOT ?>/signup">Create a free account</a> </p>
                </div>
            </div>
            <div class="subcontainer-right">
                <?php if (message()) : ?>
                    <div class="message"><?= message('', true) ?></div>
                <?php endif; ?>
                <h2>Login</h2>
                <div class="form-data">
                    <form jsubmit="loginForm" method="POST">
                        <p class="form-error"></p>
                        <div class="details">
                            <label>email</label>
                            <input type="text" name="email" required1>
                        </div>
                        <div class="details">
                            <label>Password</label>
                            <input type="password" name="password">
                            <?php if (!empty($errors['password'])) : ?>
                                <div class="error"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="login-btn">
                            <button>Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</login>
<?php $this->view('includes/footer') ?>