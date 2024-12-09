<?php $this->view("librarian/includes/sidenav") ?>
<memberProfile>

    <?php if (message()): ?>

        <div class="<?= isset($_SESSION['message_class']) ? $_SESSION['message_class'] : 'alert'; ?>">
            <?= message('', true) ?>
        </div>
        <?php unset($_SESSION['message_class']); ?>
    <?php endif; ?>
    <h1 class="title add-subscription">
        <a href="<?= ROOT ?>/librarian/subscription" class="custom-button back-button">
            <svg
                width="25px"
                height="25px"
                viewBox="0 0 1024 1024"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    fill="#5179ef"
                    d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                <path
                    fill="#5179ef"
                    d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"></path>
            </svg>
        </a>
        Add New Subscription
    </h1>
    <form class="frm-add-subscription" action="<?= ROOT ?>/librarian/subscription/add" method="POST">

        <!-- Subscription Name -->
        <div class="form-field">
            <label>Subscription Name</label>
            <input type="text" name="name" value="<?= isset($subscription->name) ? htmlspecialchars($subscription->name) : '' ?>">
            <?php if (!empty($errors['name'])) : ?>
                <div class="error"><?= $errors['name'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Price -->
        <div class="form-field">
            <label>Price (Rs)</label>
            <input type="number" step="0.01" name="price" value="<?= isset($subscription->price) ? htmlspecialchars($subscription->price) : '' ?>">
            <?php if (!empty($errors['price'])) : ?>
                <div class="error"><?= $errors['price'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Maximum Books -->
        <div class="form-field">
            <label>Max Books</label>
            <input type="number" name="max_books" value="<?= isset($subscription->max_books) ? htmlspecialchars($subscription->max_books) : '' ?>">
            <?php if (!empty($errors['max_books'])) : ?>
                <div class="error"><?= $errors['max_books'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Borrowing Period -->
        <div class="form-field">
            <label>Borrowing Period (in days)</label>
            <input type="number" name="borrowing_period" value="<?= isset($subscription->borrowing_period) ? htmlspecialchars($subscription->borrowing_period) : '' ?>">
            <?php if (!empty($errors['borrowing_period'])) : ?>
                <div class="error"><?= $errors['borrowing_period'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <p class="form-error"></p>
        <p>
            <button type="submit" class="add-btn">
                <span class="material-symbols-outlined">save</span>
                <span class="add-subscription">Add Subscription</span>
            </button>
        </p>
    </form>
</memberProfile>

<?php $this->view("member/includes/footer") ?>