<?php $this->view("librarian/includes/sidenav") ?>
<memberProfile>
    <h1 class="title edit-copyright">
        <a href="<?= ROOT ?>/librarian/copyright" class="custom-button back-button">
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
        Edit Copyright
    </h1>
    <form class="frm-edit-copyright" action="<?= ROOT ?>/librarian/Copyright/edit/<?= $copyright->copyright_id ?>" method="POST" enctype="multipart/form-data">

        <!-- License Type -->
        <div class="form-field">
            <label>License Type</label>
            <select name="license_type" required>
                <option value="cc0" <?= $copyright->license_type == 'cc0' ? 'selected' : '' ?>>No Rights Reserved (CC0)</option>
                <option value="cc_by" <?= $copyright->license_type == 'cc_by' ? 'selected' : '' ?>>Creative Commons Attribution (CC BY)</option>
                <option value="cc_by_sa" <?= $copyright->license_type == 'cc_by_sa' ? 'selected' : '' ?>>Creative Commons Attribution-ShareAlike (CC BY-SA)</option>
                <option value="cc_by_nc_sa" <?= $copyright->license_type == 'cc_by_nc_sa' ? 'selected' : '' ?>>Creative Commons Attribution-NonCommercial-ShareAlike (CC BY-NC-SA)</option>
                <option value="cc_by_nc" <?= $copyright->license_type == 'cc_by_nc' ? 'selected' : '' ?>>Creative Commons Attribution-NonCommercial (CC BY-NC)</option>
                <option value="cc_by_nc_nd" <?= $copyright->license_type == 'cc_by_nc_nd' ? 'selected' : '' ?>>Creative Commons Attribution-NonCommercial-NoDerivatives (CC BY-NC-ND)</option>
                <option value="cc_by_nd" <?= $copyright->license_type == 'cc_by_nd' ? 'selected' : '' ?>>Creative Commons Attribution-NoDerivatives (CC BY-ND)</option>
            </select>
            <?php if (!empty($errors['license_type'])) : ?>
                <div class="error"><?= $errors['license_type'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Licensed Copies -->
        <div class="form-field">
            <label>Licensed Copies</label>
            <input type="number" name="licensed_copies" value="<?= htmlspecialchars($copyright->licensed_copies) ?>" required>
            <?php if (!empty($errors['licensed_copies'])) : ?>
                <div class="error"><?= $errors['licensed_copies'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Copyright Fee -->
        <div class="form-field">
            <label>Copyright Fee (Rs)</label>
            <input type="number" min="0" step="0.01" name="copyright_fee" value="<?= htmlspecialchars($copyright->copyright_fee) ?>" required>
            <?php if (!empty($errors['copyright_fee'])) : ?>
                <div class="error"><?= $errors['copyright_fee'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Subscription Level -->
        <div class="form-field">
            <label>Subscription Level</label>
            <select name="subscription" required>
                <?php foreach ($subscriptions as $subscription): ?>
                    <option value="<?= $subscription->name ?>" <?= $copyright->subscription_id == $subscription->subscription_id ? 'selected' : '' ?>>
                        <?= ucfirst($subscription->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['subscription'])) : ?>
                <div class="error"><?= $errors['subscription'] ?></div>
            <?php endif; ?>
        </div>


        <!-- License Start Date -->
        <div class="form-field">
            <label>License Start Date</label>
            <input type="date" name="license_start_date" value="<?= htmlspecialchars($copyright->license_start_date) ?>" required>
            <?php if (!empty($errors['license_start_date'])) : ?>
                <div class="error"><?= $errors['license_start_date'] ?></div>
            <?php endif; ?>
        </div>

        <!-- License End Date -->
        <div class="form-field">
            <label>License End Date</label>
            <input type="date" name="license_end_date" value="<?= htmlspecialchars($copyright->license_end_date) ?>" required>
            <?php if (!empty($errors['license_end_date'])) : ?>
                <div class="error"><?= $errors['license_end_date'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Agreement PDF -->
        <div class="form-field">
            <label>Agreement PDF
                <a href="#" onclick="openPdfModal('<?= ROOT . '/' . $copyright->agreement ?>'); return false;">( View Agreement )</a>
            </label>
            <input type="file" name="agreement" accept="application/pdf">
            <p class="note">Current agreement is already uploaded. Choose a file to replace it.</p>
            <?php if (!empty($errors['agreement'])) : ?>
                <div class="error"><?= $errors['agreement'] ?></div>
            <?php endif; ?>
        </div>


        <!-- Submit Button -->
        <p class="form-error"></p>
        <p>
            <button type="submit" class="add-btn">
                Save Changes
            </button>
        </p>
    </form>
</memberProfile>

<!-- PDF Modal -->
<div id="pdf-modal" class="modal">
    <div class="pdf-modal-content">
        <span class="close btn-close" onclick="closePdfModal()">&times;</span>
        <iframe id="pdf-iframe" src="" style="width:100%; height:80vh;" frameborder="0"></iframe>
    </div>
</div>

<script>
    function openPdfModal(url) {
        document.getElementById('pdf-iframe').src = url;
        document.getElementById('pdf-modal').style.display = 'block';
    }

    function closePdfModal() {
        document.getElementById('pdf-modal').style.display = 'none';
        document.getElementById('pdf-iframe').src = '';
    }

    // Initially hide the modal
    document.getElementById('pdf-modal').style.display = 'none';
</script>

<?php $this->view("member/includes/footer") ?>