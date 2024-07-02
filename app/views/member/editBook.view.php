<?php $this->view("member/includes/sidenav") ?>
<addBook>
    <!--  -->
    <h1 class="title add-book">Edit Book</h1>
    <form class="frm-add-book" jsubmit="addBook" id="uploadForm" method="POST" enctype="multipart/form-data">
        <!-- <label>Book Image</label> -->
        <div class="image-uploader">
            <input type="file" accept="image/*" id="filename" name="book_image" onchange="load_image(this.files[0])" style="display: none;">
            <div class="upload-mark" onclick="document.querySelector('#filename').click()">+</div>
            <img id="preview" style="display: <?= $data[0]->book_image ? 'block' : 'none' ?>;" src="<?= $data[0]->book_image ? ROOT . '/' . $data[0]->book_image : '' ?>">
        </div>
        <div class="form-field">
            <label>Book Name</label>
            <input type="text" name="title" value="<?= $data[0]->title ?>" required1>
        </div>
        <div class="form-field">
            <label>Description</label>
            <textarea rows="6" name="description" id="description" required1></textarea>
        </div>
        <div class="form-field">
            <label>Author</label>
            <input type="text" name="author" value="<?= $data[0]->author ?>" required1>
        </div>
        <div class="form-field">
            <label>Language</label>
            <select type="text" name="language" id="language" required1>
                <option>Sinhala</option>
                <option>English</option>
                <option>Tamil</option>
                <option>Other</option>
            </select>
        </div>
        <div class="form-field">
            <label>ISBN</label>
            <input type="text" name="isbn" value="<?= $data[0]->isbn ?>" required1>
        </div>
        <div class="form-field">
            <label>Price (Rs)</label>
            <input type="number" min="0" max="5000" step="0.01" name="price" value="<?= $data[0]->price ?>" required1>
        </div>
        <div class="form-field">
            <label>Weight (g)</label>
            <input type="number" name="weight" value="<?= $data[0]->weight ?>" required1>
        </div>
        <div class="form-field">
            <label>Categories</label>
        </div>
        <div class="cats">
            <?php
            $categoryNames = ['romantic', 'thriller', 'adventure', 'horror', 'classic', 'fiction', 'fantasy'];
            foreach ($categoryNames as $categoryName) : ?>
                <p>
                    <input type="checkbox" name="categories[]" value="<?= $categoryName ?>" <?= in_array($categoryName, explode(',', $data[0]->categories)) ? 'checked' : '' ?>>
                    <?= ucfirst($categoryName) ?>
                </p>
            <?php endforeach; ?>
        </div>
        <br>
        <p class="form-error"></p>
        <p>
            <button type="submit" class="add-btn">
                <span class="material-symbols-outlined">save</span>
                <span class="add-book">Add Book</span>
                <!-- <span class="edit-book">Update Info</span> -->
            </button>
        </p>


    </form>
</addBook>
<script>
    let bookData = <?php echo json_encode($data[0]); ?>;
    let language = document.querySelector('#language');
    language.value = bookData['language'];
    let description = document.querySelector('#description');
    description.value = bookData['description'];

    function load_image(file) {
        var mylink = window.URL.createObjectURL(file);
        let imgPreview = document.querySelector('#preview');
        let uploadMark = document.querySelector('.upload-mark');
        imgPreview.src = mylink;
        imgPreview.style.display = 'block';
        uploadMark.innerHTML = "";
    }
</script>

<?php $this->view("member/includes/footer") ?>