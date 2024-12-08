<?php $this->view('librarian/includes/sidenav'); ?>


<?php if (message()): ?>

    <div class="<?= isset($_SESSION['message_class']) ? $_SESSION['message_class'] : 'alert'; ?>">
        <?= message('', true) ?>
    </div>
    <?php unset($_SESSION['message_class']); ?>
<?php endif; ?>

<memberProfile>
    <h1 class="title">Subscriptions</h1>
    <p>
        <a class="add-book-btn" href="<?= ROOT ?>/librarian/subscription/add">
            <span class="material-symbols-outlined">add</span>
            Add
        </a>
    </p>

    <div class="subscription-component">
        <div class="subscription-container">
            <?php if (isset($data['subscriptions']) && is_array($data['subscriptions'])) : ?>
                <?php foreach ($data['subscriptions'] as $index => $subscription) : ?>
                    <?php $isChecked = $index === 0 ? 'checked="checked"' : ''; ?>
                    <!-- Added unique id to each radio input -->
                    <input type="radio" id="option<?= $subscription->subscription_id ?>" name="subscription" <?= $isChecked ?>>
                    <!-- Ensure the for attribute matches the input's id -->
                    <label for="option<?= $subscription->subscription_id ?>" class="subscription__button">
                        <h3 class="subscription__title subscription__title--<?= strtolower($subscription->name) ?>">
                            <?= htmlspecialchars($subscription->name) ?>
                        </h3>
                        <span class="subscription__price">LKR <?= htmlspecialchars(number_format($subscription->price, 2)) ?> <span class="subscription__price-month">/ mon</span></span>
                        <ul class="subscription__list">
                            <li class="subscription__item">
                                <i class="icon-subscription fas fa-check-circle"></i>
                                <span>
                                    Borrowing Period: <span class="subscription__item-text"><?= htmlspecialchars($subscription->borrowing_period) ?> days</span>
                                </span>
                            </li>
                            <li class="subscription__item">
                                <i class="icon-subscription fas fa-check-circle"></i>
                                <span>
                                    Books Limit: <span class="subscription__item-text"><?= htmlspecialchars($subscription->max_books) ?></span>
                                </span>
                            </li>
                        </ul>
                        <?php if ($subscription->subscription_id != 1) : ?>
                            <a href="<?= ROOT ?>/librarian/deacivateSubscription/<?= $subscription->subscription_id ?>" class="subscription__delete button-delete">Deactive</a>
                        <?php endif; ?>
                    </label>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No subscriptions available.</p>
            <?php endif; ?>
        </div>
    </div>

</memberProfile>

<?php $this->view('member/includes/footer'); ?>