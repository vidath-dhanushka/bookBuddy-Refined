<?php $this->view("librarian/includes/sidenav") ?>
<addBook>
    <h1 class="title add-book">Add New E - Book</h1>
    <form id="uploadForm" class="frm-add-book" method="post" enctype="multipart/form-data">
        <!-- Container for two-column layout -->
        <div class="form-grid-3">
            <div class="form-column">
                <!-- Book Cover Image Upload -->
                <div class="form-field">
                    <label>Book Cover *</label>
                    <div class="image-uploader">
                        <input type="file" accept="image/*" id="filename" name="book_cover" onchange="load_image(this.files[0])" style="display: none;">
                        <div class="upload-mark" onclick="document.querySelector('#filename').click()">+</div>
                        <img id="preview" src="<?= isset($_SESSION['temp_cover_path']) ? ROOT . '/' . $_SESSION['temp_cover_path'] : ROOT . '/assets/images/books/book_image.jpg';  ?>" style="display: block;height:247px">

                    </div>
                    <?php if (!empty($errors['book_cover'])) : ?>
                        <small class="form-error"><?= $errors['book_cover'] ?></small>
                    <?php endif; ?>
                </div>

                <!-- Book Title -->
                <div class="form-field">
                    <label>Book Name *</label>
                    <input type="text" name="title" value="<?= set_value('title') ?>">
                    <?php if (!empty($errors['title'])) : ?>
                        <small class="form-error"><?= $errors['title'] ?></small>
                    <?php endif; ?>
                </div>
                <!-- Description -->
                <div class="form-field">
                    <label>Description *</label>
                    <textarea rows="6" name="description"><?= set_value('description') ?></textarea>
                    <?php if (!empty($errors['description'])) : ?>
                        <small class="form-error"><?= $errors['description'] ?></small>
                    <?php endif; ?>
                </div>

            </div>
            <!-- Right Column -->
            <div class="form-column">
                <!-- ISBN -->
                <div class="form-field">
                    <label>ISBN</label>
                    <input type="text" name="isbn" value="<?= set_value('isbn') ?>">
                    <?php if (!empty($errors['isbn'])) : ?>
                        <small class="form-error"><?= $errors['isbn'] ?></small>
                    <?php endif; ?>

                </div>

                <!-- Publisher -->
                <div class="form-field">
                    <label>Publisher *</label>
                    <input type="text" name="publisher" value="<?= set_value('publisher') ?>">
                    <?php if (!empty($errors['publisher'])) : ?>
                        <small class="form-error"><?= $errors['publisher'] ?></small>
                    <?php endif; ?>
                </div>

                <!-- Publish Date -->
                <div class="form-field">
                    <label>Publish Date *</label>
                    <input type="date" name="publish_date" value="<?= set_value('publish_date') ?>">
                    <?php if (!empty($errors['publish_date'])) : ?>
                        <small class="form-error"><?= $errors['publish_date'] ?></small>
                    <?php endif; ?>
                </div>

                <!-- Pages -->
                <div class="form-field">
                    <label>Pages *</label>
                    <input type="number" name="pages" value="<?= isset($_POST['pages']) ? htmlspecialchars($_POST['pages']) : '' ?>">
                    <?php if (!empty($errors['pages'])) : ?>
                        <small class="form-error"><?= $errors['pages'] ?></small>
                    <?php endif; ?>
                </div>


                <div class="form-field">
                    <label for="file-input">E-book File *</label>
                    <div class="drop_box">
                        <input class="file-input" type="file" name="file" id="file-input" hidden accept=".pdf" onchange="updateFileName()">
                        <header>
                            <h4 id="selected-file-name"><?= isset($_SESSION['temp_file_path']) ? basename($_SESSION['temp_file_path']) : 'Browse File to Upload'; ?></h4>
                        </header>
                        <p>Files Supported: PDF</p>
                        <button type="button" class="btn" id="choose-file-button" onclick="document.querySelector('#file-input').click()">Choose File</button>
                    </div>
                    <?php if (!empty($errors['file'])) : ?>
                        <small class="form-error"><?= $errors['file'] ?></small>
                    <?php endif; ?>
                </div>






                <!-- Categories -->

            </div>
            <div class="form-column">
                <!-- License Type -->
                <div class="form-field">
                    <label>License *</label>
                    <select name="license_type">
                        <option value="" disabled <?= empty(set_value('license_type')) ? 'selected' : '' ?>>Select License</option>
                        <option value="Public Domain" <?= set_value('license_type') === 'Public Domain' ? 'selected' : '' ?>>Public Domain</option>
                        <option value="Licensed" <?= set_value('license_type') === 'Licensed' ? 'selected' : '' ?>>Creative Commons Attribution (CC BY)</option>
                    </select>
                    <?php if (!empty($errors['license_type'])) : ?>
                        <small class="form-error"><?= $errors['license_type'] ?></small>
                    <?php endif; ?>
                </div>

                <!-- edition -->
                <div class="form-field">
                    <label>Edition </label>
                    <input type="number" name="edition" value="<?= set_value('edition') ?>">
                    <?php if (!empty($errors['edition'])) : ?>
                        <small class="form-error"><?= $errors['edition'] ?></small>
                    <?php endif; ?>
                </div>
                <!-- Author -->
                <div class="form-field">
                    <label>Author *</label>
                    <input type="text" name="author_name" value="<?= set_value('author_name') ?>">
                    <?php if (!empty($errors['author_name'])) : ?>
                        <small class="form-error"><?= $errors['author_name'] ?></small>
                    <?php endif; ?>
                </div>

                <!-- Language -->
                <div class="form-field">
                    <label for="language">Language *</label>
                    <input type="text" id="language" name="language" value="<?= set_value('language') ?>">
                    <?php if (!empty($errors['language'])) : ?>
                        <small class="form-error"><?= $errors['language'] ?></small>
                    <?php endif; ?>
                </div>




            </div>




        </div>



        <!-- Submit Button (full-width row) -->


        <div class="form-field">
            <label>Categories *</label>
            <div class="cats">
                <?php
                $selectedCategories = isset($_POST['category']) ? $_POST['category'] : [];
                foreach ($categories as $category) : ?>
                    <p>
                        <input type="checkbox" name="category[]" value="<?= $category->category_id; ?>" <?= (in_array($category->category_id, $selectedCategories)) ? 'checked' : ''; ?>>
                        <?= $category->name; ?>
                    </p>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($errors['category'])) : ?>
                <small class="form-error"><?= $errors['category'] ?></small>
            <?php endif; ?>

        </div>
        <div class="form-field">
            <button type="submit" class="add-btn">
                <span class="material-symbols-outlined">save</span>
                <span class="add-book">Add Book</span>
            </button>
        </div>

    </form>


</addBook>
<script>
    function load_image(file) {
        var mylink = window.URL.createObjectURL(file);
        let imgPreview = document.querySelector('#preview');
        let uploadMark = document.querySelector('.upload-mark');
        imgPreview.src = mylink;
        imgPreview.style.display = 'block';
        uploadMark.innerHTML = "";


    }

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