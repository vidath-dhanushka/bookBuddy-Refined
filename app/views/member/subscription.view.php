<?php $this->view('member/includes/sidenav'); ?>


<?php if (message()): ?>

    <div class="<?= isset($_SESSION['message_class']) ? $_SESSION['message_class'] : 'alert'; ?>">
        <?= message('', true) ?>
    </div>
    <?php unset($_SESSION['message_class']); ?>
<?php endif; ?>

<memberProfile>
    <div class="pricing-header">
        <h1>Your Current Plan</h1>
        <p>Review the details of your current subscription plan below.</p>
        <a href="<?= ROOT ?>/librarian/subscriptionHome" class="subscription-nav-link">Change Plan</a>
    </div>

    <div class="subscription-component">
        <div class="subscription-container">
            <?php if (isset($data['subscriptions']) && is_array($data['subscriptions'])) : ?>
                <?php
                // Find the current subscription
                $currentSubscription = null;
                foreach ($data['subscriptions'] as $subscription) {
                    if ($subscription->subscription_id === $data['member_subscription']->subscription_id) {
                        $currentSubscription = $subscription;
                        break;
                    }
                }
                ?>

                <?php if ($currentSubscription) : ?>
                    <input type="radio" id="option<?= $currentSubscription->subscription_id ?>" name="subscription" checked="checked" disabled>
                    <label for="option<?= $currentSubscription->subscription_id ?>" class="subscription__button subscription__button--current">
                        <h3 class="subscription__title subscription__title--<?= strtolower($currentSubscription->name) ?>">
                            <?= htmlspecialchars($currentSubscription->name) ?>
                        </h3>
                        <span class="subscription__price">LKR <?= htmlspecialchars(number_format($currentSubscription->price, 2)) ?> <span class="subscription__price-month">/ mo</span></span>
                        <ul class="subscription__list">
                            <li class="subscription__item">
                                <i class="icon-subscription fas fa-check-circle"></i>
                                <span>
                                    Borrowing Period: <span class="subscription__item-text"><?= htmlspecialchars($currentSubscription->borrowing_period) ?> days</span>
                                </span>
                            </li>
                            <li class="subscription__item">
                                <i class="icon-subscription fas fa-check-circle"></i>
                                <span>
                                    Books Limit: <span class="subscription__item-text"><?= htmlspecialchars($currentSubscription->max_books) ?></span>
                                </span>
                            </li>

                            <!-- Only show start and end dates if the subscription_id is not 1 -->
                            <?php if ($currentSubscription->subscription_id != 1) : ?>
                                <li class="subscription__item">
                                    <i class="icon-subscription fas fa-calendar-day"></i>
                                    <span>
                                        Start Date: <span class="subscription__item-text"><?= htmlspecialchars(date('Y-m-d', strtotime($member_subscription->start_date))) ?></span>
                                    </span>
                                </li>
                                <li class="subscription__item">
                                    <i class="icon-subscription fas fa-calendar-day"></i>
                                    <span>
                                        End Date: <span class="subscription__item-text"><?= htmlspecialchars(date('Y-m-d', strtotime($member_subscription->end_date))) ?></span>
                                    </span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </label>
                <?php else : ?>


                    <p>No current subscription details available.</p>
                <?php endif; ?>
            <?php else : ?>
                <p>No subscriptions available.</p>
            <?php endif; ?>
        </div>
    </div>
</memberProfile>

<?php $this->view('member/includes/footer'); ?>