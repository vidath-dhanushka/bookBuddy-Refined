<?php $this->view('courier/includes/sidenav'); ?>
<adminCourier>
    <h1 class="title">Completed Orders</h1>

    <table>
        <tr>
            <th>Order Id</th>
            <th>Borrower Name</th>
            <th>contact No.</th>
            <th>Address</th>
            <th>Amount</th>
            <th>Weight</th>
            <th>Details</th>
        </tr>
        <?php foreach ($data as $order) : ?>
            <tr>
                <td><?= $order->order_id ?></td>
                <td><?= $order->first_name ?> <?= $order->last_name ?></td>
                <td><?= $order->phone ?></td>
                <td><?= $order->address_line1 ?>, <?= $order->address_line2 ?>, <?= $order->address_city ?>, <?= $order->address_district ?> </td>
                <td>Rs. <?= $order->amount ?></td>
                <td><?= $order->weight ?>g</td>
                <td><button><a href="<?= ROOT ?>/courier/singleOrderCompleted/<?= $order->order_id ?>">View details</a></button></td>
            </tr>
        <?php endforeach; ?>

    </table>
</adminCourier>