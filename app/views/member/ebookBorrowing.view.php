<?php $this->view('member/includes/sidenav'); ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/librarian/table.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/elibrary/ebook-reader.css">

<?php if (message()): ?>

    <div class="<?= isset($_SESSION['message_class']) ? $_SESSION['message_class'] : 'alert'; ?>">
        <?= message('', true) ?>
    </div>
    <?php unset($_SESSION['message_class']); ?>
<?php endif; ?>
<memberProfile>
    <h1 class="title">E - Books Borrowing</h1>

    <table class="librarian-content-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Borrowed Date</th>
                <th>Return Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <?php if (!empty($data['borrowed_ebooks'])) : ?>
                <?php foreach ($data['borrowed_ebooks'] as $borrowed_ebook) : ?>
                    <tr>
                        <td><?= htmlspecialchars($borrowed_ebook->title) ?></td>
                        <td><?= htmlspecialchars(camelCaseToWords($borrowed_ebook->author_name)) ?></td>
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($borrowed_ebook->borrow_date))) ?></td>
                        <td>
                            <?php if ($borrowed_ebook->active) : ?>
                                <p class="status borrowed">Borrowed</p>
                            <?php else : ?>
                                <p class="status returned">Returned</p>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($borrowed_ebook->active) : ?>
                                <a href="<?= ROOT ?>/Elibrary/return_book/<?= $borrowed_ebook->ebook_id ?>" class="return-btn">Return</a>
                            <?php else : ?>
                                <a href="#" class="action-btn disabled" title="Already returned">Returned</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No borrowing history found!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</memberProfile>

<?php $this->view('member/includes/footer'); ?>