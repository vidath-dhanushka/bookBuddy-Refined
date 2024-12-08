<?php $this->view('courier/includes/sidenav'); ?>
<courierSingleOrder>
    <h1 class="title">Order Details</h1>

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
                <td><select name="status" class="status" data-id=<?= $order->book_borrow_id ?>>
                        <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="collected" <?= $order->status == 'collected' ? 'selected' : '' ?>>Collected from Owner</option>
                        <option value="recieved" <?= $order->status == 'recieved' ? 'selected' : '' ?>>Sent to Borrower</option>
                        <option value="returned" <?= $order->status == 'returned' ? 'selected' : '' ?>>Returned by Lender</option>
                        <option value="completed" <?= $order->status == 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
</courierSingleOrder>

<script>
    const data = <?php echo json_encode($data); ?>;

    let status = document.querySelectorAll(".status").forEach(select => {
        select.addEventListener('change', (event) => {
            let bookBorrowId = event.target.dataset.id;
            let selectedStatus = event.target.value;

            const bookBorrow = data.find((item) => item.book_borrow_id == bookBorrowId);
            if (bookBorrow) {
                bookBorrow.status = selectedStatus;
            }

            const allCompleted = data.every((item) => item.status === "completed");

            if (allCompleted) {
                updateOrderStatus()
            }

            updateStatus(bookBorrowId, selectedStatus);
        })
    })

    function updateStatus(bookBorrowId, status) {
        fetch("<?= ROOT ?>/courier/updateBookBorrowStatus", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    id: bookBorrowId,
                    status: status,
                }),
            })
            .then((response) => {
                if (response.ok) {
                    alert("Status updated successfully!");
                } else {
                    alert("Failed to update status. Please try again.");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            });
    }

    function updateOrderStatus() {
        let orderId = data[0].orderNo;
        fetch("<?= ROOT ?>/courier/updateOrderStatus", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    orderNo: orderId,
                    status: "completed"
                }),
            })
            .then((response) => response.json())
            .then((result) => {
                if (result.success) {
                    alert("Order status updated to 'completed'.");
                } else {
                    alert("Failed to update order status: " + result.error);
                }
            })
            .catch((error) => {
                console.error("Error updating order status:", error);
                alert("An error occurred while updating the order status.");
            });
    }
</script>