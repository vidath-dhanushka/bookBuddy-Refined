<?php $this->view('librarian/includes/sidenav'); ?>

<?php if (message()): ?>

    <div class="<?= isset($_SESSION['message_class']) ? $_SESSION['message_class'] : 'alert'; ?>">
        <?= message('', true) ?>

    </div>
    <?php unset($_SESSION['message_class']); ?>
<?php endif; ?>
<memberProfile>
    <h1 class="title">E - Books</h1>
    <p>
        <a class="add-book-btn" href="<?= ROOT ?>/librarian/addEbook">
            <span class="material-symbols-outlined">add</span>
            Add
        </a>
    </p>

    <table class="librarian-content-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date Added</th>
                <th>Action</th>
                <th>Copyright</th>
            </tr>
        </thead>
        <tbody>

            <?php if (!empty($data['ebooks'])) : ?>
                <?php foreach ($data['ebooks'] as $ebooks) : ?>
                    <tr>
                        <td><?= $ebooks->title ?></td>
                        <td><?= camelCaseToWords($ebooks->author_name) ?></td>
                        <td><?= camelCaseToWords($ebooks->publisher) ?></td>
                        <td><?= $ebooks->license_type ?></td>
                        <?php if ($ebooks->copyright_status or $ebooks->license_type == "Public Domain") : ?>
                            <td>
                                <p class="status uploaded">Uploaded</p>
                            </td>
                        <?php else : ?>
                            <td>
                                <p class="status pending">Pending</p>
                            </td>
                        <?php endif; ?>
                        <td><?= date('Y-m-d', strtotime($ebooks->date_added)) ?></td>
                        <td>

                            <a href="<?= ROOT . '/librarian/updateEbook/' . $ebooks->ebook_id; ?>" class="action-icon"><i class="fa-regular fa-pen-to-square" style="color:blue"></i></a>
                            <a href="<?= ROOT . '/librarian/ebooks/delete/' . $ebooks->ebook_id; ?>" class="action-icon"><i class="fa-solid fa-trash" style="color:red; margin-left:5px"></i></a>
                        </td>
                        <td>
                            <?php if ($ebooks->copyright_status and !($ebooks->license_type == "Public Domain")) : ?>
                                <a href="<?= ROOT . '/librarian/copyright/edit/' . $ebooks->ebook_id; ?>" class="action-btn">Edit</a>
                            <?php elseif ($ebooks->license_type == "Public Domain") : ?>
                                <a href="<?= ROOT . '/librarian/my_message'; ?>" class="action-btn">Add</a>
                            <?php else : ?>
                                <a href="<?= ROOT . '/librarian/copyright/add/' . $ebooks->ebook_id; ?>" class="action-btn">Add</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8">No records found!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</memberProfile>

<?php $this->view('member/includes/footer'); ?>