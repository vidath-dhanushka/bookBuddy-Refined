<?php $this->view('librarian/includes/sidenav'); ?>

<?php if (message()) : ?>
    <div class="message"><?= message('', true) ?></div>
<?php endif; ?>

<memberProfile>
    <h1 class="title">Copyright Details</h1>

    <table class="librarian-content-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>License Type</th>
                <th>Licensed Copies</th>
                <th>Copyright Fee</th>
                <th>License Start Date</th>
                <th>License End Date</th>
                <th>Agreement</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['copyrights'])) : ?>
                <?php foreach ($data['copyrights'] as $copyright) : ?>

                    <tr>
                        <td><?= htmlspecialchars($copyright->ebook_title) ?></td>
                        <td>
                            <?php if ($copyright) : ?>
                                <?= htmlspecialchars($copyright->license_type) ?>
                            <?php else : ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($copyright) : ?>
                                <?= htmlspecialchars($copyright->licensed_copies) ?>
                            <?php else : ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($copyright) : ?>
                                <?= htmlspecialchars($copyright->copyright_fee) ?>
                            <?php else : ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($copyright) : ?>
                                <?= htmlspecialchars(date('Y-m-d', strtotime($copyright->license_start_date))) ?>
                            <?php else : ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($copyright) : ?>
                                <?= htmlspecialchars(date('Y-m-d', strtotime($copyright->license_end_date))) ?>
                            <?php else : ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($copyright && $copyright->agreement) : ?>
                                <button class="open-modal" data-pdf="<?= htmlspecialchars($copyright->agreement) ?>">View Agreement</button>
                            <?php else : ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($copyright) : ?>
                                <a href="<?= ROOT . '/librarian/copyright/edit/' . htmlspecialchars($copyright->copyright_id); ?>" class="copyright-edit">Edit</a>
                                <a href="<?= ROOT . '/librarian/copyright/delete/' . htmlspecialchars($copyright->copyright_id); ?>" class="copyright-delete">Delete</a>
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

<!-- Modal Structure -->
<div id="pdf-modal" class="modal pdf-modal">
    <div class="modal-content pdf-modal-content">
        <span class="close btn-close"><span class="icon-cross"></span>
            <span class="visually-hidden">&times;</span></span>
        <iframe id="pdf-iframe" class="pdf-iframe" src="" style="width:100%; height:80vh;" frameborder="0"></iframe>
    </div>
</div>


<!-- Modal Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('pdf-modal');
        var iframe = document.getElementById('pdf-iframe');
        var closeBtn = document.querySelector('.modal .close');

        document.querySelectorAll('.open-modal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var pdfUrl = this.getAttribute('data-pdf');
                iframe.src = pdfUrl;
                modal.style.display = 'block';
            });
        });

        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            iframe.src = '';
        });

        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
                iframe.src = '';
            }
        });
    });
</script>
<?php $this->view('member/includes/footer'); ?>