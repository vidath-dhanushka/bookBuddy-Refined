<?php $this->view("librarian/includes/sidenav") ?>
<addBook>
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
        Add Copyright
    </h1>

    <form class="frm-edit-copyright" method="POST" enctype="multipart/form-data">
        <div class="form-grid-3">

            <div class="form-column">
                <div class="form-field">
                    <label>License Type</label>
                    <select name="license_type">
                        <option hidden value="default" <?= (isset($copyright->license_type) && $copyright->license_type == 'default') ? 'selected' : '' ?>>License Type *</option>
                        <option value="cc0" <?= (isset($copyright->license_type) && $copyright->license_type == 'cc0') ? 'selected' : '' ?>>No Rights Reserved (CC0)</option>
                        <option value="cc_by" <?= (isset($copyright->license_type) && $copyright->license_type == 'cc_by') ? 'selected' : '' ?>>Creative Commons Attribution (CC BY)</option>
                        <option value="cc_by_sa" <?= (isset($copyright->license_type) && $copyright->license_type == 'cc_by_sa') ? 'selected' : '' ?>>Creative Commons Attribution-ShareAlike (CC BY-SA)</option>
                        <option value="cc_by_nc_sa" <?= (isset($copyright->license_type) && $copyright->license_type == 'cc_by_nc_sa') ? 'selected' : '' ?>>Creative Commons Attribution-NonCommercial-ShareAlike (CC BY-NC-SA)</option>
                        <option value="cc_by_nc" <?= (isset($copyright->license_type) && $copyright->license_type == 'cc_by_nc') ? 'selected' : '' ?>>Creative Commons Attribution-NonCommercial (CC BY-NC)</option>
                        <option value="cc_by_nc_nd" <?= (isset($copyright->license_type) && $copyright->license_type == 'cc_by_nc_nd') ? 'selected' : '' ?>>Creative Commons Attribution-NonCommercial-NoDerivatives (CC BY-NC-ND)</option>
                        <option value="cc_by_nd" <?= (isset($copyright->license_type) && $copyright->license_type == 'cc_by_nd') ? 'selected' : '' ?>>Creative Commons Attribution-NoDerivatives (CC BY-ND)</option>
                    </select>
                    <?php if (!empty($errors['license_type'])) : ?>
                        <div class="error"><?= $errors['license_type'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label>License Start Date</label>
                    <input type="date" name="license_start_date" value="<?= set_value_edit('license_start_date', $copyright->license_start_date) ?>">
                    <?php if (!empty($errors['license_start_date'])) : ?>
                        <div class="error"><?= $errors['license_start_date'] ?></div>
                    <?php endif; ?>
                    <div class="form-field">
                        <label>Subscription Levels *</label>
                        <div class="cats">
                            <?php
                            // Extract selected subscription_ids into an array
                            $selectedSubscriptions = array_map(function ($sub) {
                                return $sub->subscription_id;
                            }, $data['subscription']); // Assuming $data['subscriptions'] holds the selected subscriptions

                            // Iterate over the available subscriptions and create checkboxes
                            foreach ($data['subscriptions'] as $subscription) : ?>
                                <p>
                                    <!-- Create a checkbox for each subscription with the appropriate checked state -->
                                    <input type="checkbox"
                                        name="subscription[]"
                                        value="<?= $subscription->subscription_id; ?>"
                                        <?= (in_array($subscription->subscription_id, $selectedSubscriptions)) ? 'checked' : ''; ?>>
                                    <?= htmlspecialchars($subscription->name); ?>
                                </p>
                            <?php endforeach; ?>
                        </div>

                        <!-- Display any validation errors for subscriptions -->
                        <?php if (!empty($errors['subscription'])) : ?>
                            <small class="form-error"><?= htmlspecialchars($errors['subscription']); ?></small>
                        <?php endif; ?>
                    </div>



                </div>
            </div>
            <div class="form-column">
                <div class="form-field">
                    <label>Licensed Copies</label>
                    <input type="number" name="licensed_copies" value="<?= set_value_edit('licensed_copies', $copyright->licensed_copies) ?>">
                    <?php if (!empty($errors['licensed_copies'])) : ?>
                        <div class="error"><?= $errors['licensed_copies'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-field">
                    <label>License End Date</label>
                    <input type="date" name="license_end_date" value="<?= set_value_edit('license_end_date', $copyright->license_end_date) ?>">
                    <?php if (!empty($errors['license_end_date'])) : ?>
                        <div class="error"><?= $errors['license_end_date'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-column">
                <div class="form-field">
                    <label>Copyright Fee (Rs)</label>
                    <input type="number" name="copyright_fee" value="<?= set_value_edit('copyright_fee', $copyright->copyright_fee) ?>">
                    <?php if (!empty($errors['copyright_fee'])) : ?>
                        <div class="error"><?= $errors['copyright_fee'] ?></div>
                    <?php endif; ?>

                </div>

                <div class="form-field">
                    <label for="file-input">Agreement *</label>
                    <div class="drop_box">
                        <input class="file-input" type="file" name="agreement" id="file-input" hidden accept=".pdf" onchange="updateFileName()">
                        <header>
                            <h4 id="selected-file-name"><?= substr(basename(set_value_edit('agreement', $copyright->agreement)), 10) ?></h4>
                        </header>
                        <p>Files Supported: PDF</p>
                        <button type="button" class="btn" id="choose-file-button" onclick="document.querySelector('#file-input').click()">Choose File</button>
                    </div>
                    <?php if (!empty($errors['agreement'])) : ?>
                        <small class="form-error"><?= $errors['agreement'] ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>




        <!-- Submit Button -->
        <p class="form-error"></p>
        <p>
            <button type="submit" class="add-btn">
                Save
            </button>
        </p>
    </form>
</addBook>

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

    function updateFileName() {
        const fileInput = document.querySelector('#file-input');
        const fileNameDisplay = document.querySelector('#selected-file-name');
        const chooseFileButton = document.querySelector('#choose-file-button');

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            fileNameDisplay.textContent = file.name;
            chooseFileButton.textContent = 'Change File';
        } else {
            fileNameDisplay.textContent = 'Browse File to Upload';
            chooseFileButton.textContent = 'Choose File';
        }
    }
</script>

<?php $this->view("member/includes/footer") ?>