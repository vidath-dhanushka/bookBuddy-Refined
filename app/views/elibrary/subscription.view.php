<?php $this->view('elibrary/includes/header'); ?>

<?php if (message()) : ?>
    <div class="message"><?= message('', true) ?></div>
<?php endif; ?>

<memberProfile>



    <div class="pricing-header">
        <h1>Choose Your Perfect Plan</h1>
        <p>Get the best reading experience with our flexible pricing options tailored for you.</p>

    </div>

    <div class="subscription-component">
        <div class="subscription-container">
            <?php if (isset($data['subscriptions']) && is_array($data['subscriptions'])) : ?>
                <?php foreach ($data['subscriptions'] as $subscription) : ?>
                    <?php
                    // Check if the subscription is the current member's subscription
                    $isCurrent = $subscription->subscription_id === $data['member_subscription']->subscription_id;
                    $buttonText = $isCurrent ? "Your Current Plan" : "Select Plan";
                    $buttonClass = $isCurrent ? "subscription__button--current" : "subscription__button--select";
                    ?>
                    <input type="radio" id="option<?= $subscription->subscription_id ?>" name="subscription" <?= $isCurrent ? 'checked="checked"' : '' ?>>
                    <label for="option<?= $subscription->subscription_id ?>" class="subscription__button <?= $buttonClass ?>">
                        <h3 class="subscription__title subscription__title--<?= strtolower($subscription->name) ?>">
                            <?= htmlspecialchars($subscription->name) ?>
                        </h3>
                        <span class="subscription__price">LKR <?= htmlspecialchars(number_format($subscription->price, 2)) ?> <span class="subscription__price-month">/ mo</span></span>
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
                        <a href="" onclick="payment_gateway()" class="subscription__edit button-edit"><?= $buttonText ?></a>
                    </label>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No subscriptions available.</p>
            <?php endif; ?>
        </div>
    </div>

</memberProfile>
<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
<?php $this->view('member/includes/footer'); ?>