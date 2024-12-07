<?php $this->view('courier/includes/sidenav'); ?>
<courierSingleOrder>
    <h1 class="title">Ongoing Orders</h1>

    <table>
        <tr>
            <th>Book</th>
            <th>Owner Name</th>
            <th>contact No.</th>
            <th>Address</th>
            <th>Amount</th>
            <th>Weight</th>
            <th>status</th>
        </tr>

        <?php foreach ($data as $order) : ?>
            <tr>
                <td><?= $order->title ?></td>
                <td><?= $order->first_name ?> <?= $order->last_name ?></td>
                <td><?= $order->phone ?></td>
                <td><?= $order->address_line1 ?>, <?= $order->address_line2 ?>, <?= $order->address_city ?>, <?= $order->address_district ?> </td>
                <td>Rs. <?= $order->price ?></td>
                <td><?= $order->weight ?>g</td>
                <td><select name="status" id="status">
                        <option value="pending">Pending</option>
                        <option value="collected">Collected from Owner</option>
                        <option value="recieved">Sent to borrower</option>
                        <option value="returned">Retruned by lender</option>
                        <option value="received_owner">Received by Owner</option>
                    </select></td>
            </tr>
        <?php endforeach; ?>

    </table>
</courierSingleOrder>