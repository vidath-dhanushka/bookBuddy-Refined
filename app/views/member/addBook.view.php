<?php $this->view("member/includes/sidenav") ?>
<addBook>
    <h1 class="title add-book">Add New Book</h1>
    <form class="frm-add-book" jsubmit="addBook" id="uploadForm" method="POST" enctype="multipart/form-data">
        <!-- <label>Book Image</label> -->
        <div class="image-uploader">
            <input type="file" accept="image/*" id="filename" name="book_image" onchange="load_image(this.files[0])" style="display: none;">
            <div class="upload-mark" onclick="document.querySelector('#filename').click()">+</div>
            <img id="preview">
        </div>
        <div class="form-field">
            <label>Book Name</label>
            <input type="text" name="title" required1>
        </div>
        <div class="form-field">
            <label>Description</label>
            <textarea rows="6" name="description" required1></textarea>
        </div>
        <div class="form-field">
            <label>Author</label>
            <input type="text" name="author" required1>
        </div>
        <div class="form-field">
            <label>Language</label>
            <select type="text" name="language" required1>
                <option>Sinhala</option>
                <option>English</option>
                <option>Tamil</option>
                <option>Other</option>
            </select>
        </div>
        <div class="form-field">
            <label>ISBN</label>
            <input type="text" name="isbn" required1>
        </div>
        <div class="form-field">
            <label>Price (Rs)</label>
            <input type="number" min="0" max="5000" step="0.01" name="price" required1>
        </div>
        <div class="form-field">
            <label>Weight (g)</label>
            <input type="number" name="weight" required1>
        </div>
        <div class="form-field">
            <label>Categories</label>
        </div>
        <div class="cats">
            <p><input type="checkbox" name="categories[]" value="romantic">Romantic</p>
            <p><input type="checkbox" name="categories[]" value="thriller">Thriller</p>
            <p><input type="checkbox" name="categories[]" value="adventure">Adventure</p>
            <p><input type="checkbox" name="categories[]" value="horror">Horror</p>
            <p><input type="checkbox" name="categories[]" value="classic">Classic</p>
            <p><input type="checkbox" name="categories[]" value="fiction">Fiction</p>
            <p><input type="checkbox" name="categories[]" value="fantasy">Fantasy</p>
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
    function load_image(file) {
        var mylink = window.URL.createObjectURL(file);
        let imgPreview = document.querySelector('#preview');
        let uploadMark = document.querySelector('.upload-mark');
        imgPreview.src = mylink;
        imgPreview.style.display = 'block';
        uploadMark.innerHTML = "";


    }
    // function imageChanged(event) {
    //     var file = event.target.files[0];
    //     var preview = document.getElementById('preview');
    //     var filenameInput = document.getElementById('hiddenfile');
    //     var uploadMark = document.querySelector('.upload-mark');

    //     if (file) {
    //         var reader = new FileReader();

    //         reader.onload = function(e) {
    //             preview.src = e.target.result;
    //             preview.style.display = 'block';
    //             uploadMark.innerHTML = '';
    //         };

    //         reader.readAsDataURL(file);

    //         // Store the filename in the hidden input
    //         filenameInput.value = file.name;
    //     } else {
    //         preview.src = '';
    //         preview.style.display = 'none';
    //         uploadMark.style.display = 'block';
    //         filenameInput.value = '';
    //     }
    // }

    // document.addEventListener('DOMContentLoaded', function() {
    //     var uploadForm = document.getElementById('uploadForm');

    //     uploadForm.addEventListener('submit', function(event) {
    //         event.preventDefault();

    //         var formData = new FormData();
    //         var fileInput = document.getElementById('file');
    //         var file = fileInput.files[0];

    //         if (file) {
    //             formData.append('image', file);

    //             fetch('upload.php', {
    //                     method: 'POST',
    //                     body: formData
    //                 })
    //                 .then(response => response.text())
    //                 .then(data => {
    //                     console.log(data);
    //                 })
    //                 .catch(error => {
    //                     console.error('Error:', error);
    //                 });
    //         } else {
    //             alert('Please select an image file first.');
    //         }
    //     });
    // });
</script>

<?php $this->view("member/includes/footer") ?>