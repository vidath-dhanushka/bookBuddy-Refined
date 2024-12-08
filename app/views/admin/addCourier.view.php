<?php $this->view("admin/includes/sidenav") ?>
<addBook>
    <h1 class="title add-book">Add Courier Company</h1>
    <form class="frm-add-courier" id="uploadForm" method="POST">
        <!-- <label>Book Image</label> -->
        <div class="form-field">
            <label>Company Name</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-field">
            <label>Registration Number</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-field">
            <label>Phone</label>
            <input type="text" pattern=".{9,12}" name="title" required>
        </div>
        <div class="form-field">
            <label>Address Line 1</label>
            <input type="text" name="author" required>
        </div>
        <div class="form-field">
            <label>Address Line 2</label>
            <input type="text" name="author" required1>
        </div>
        <div class="form-field">
            <label>City</label>
            <input type="text" name="author" required>
        </div>
        <div class="form-field">
            <label>District</label>
            <select name="address_district" class="district-list" required1>
                <option value=""></option>
                <option value="Ampara">Ampara</option>
                <option value="Anuradhapura">Anuradhapura</option>
                <option value="Badulla">Badulla</option>
                <option value="Batticaloa">Batticaloa</option>
                <option value="Colombo">Colombo</option>
                <option value="Galle">Galle</option>
                <option value="Gampaha">Gampaha</option>
                <option value="Hambantota">Hambantota</option>
                <option value="Jaffna">Jaffna</option>
                <option value="Kalutara">Kalutara</option>
                <option value="Kandy">Kandy</option>
                <option value="Kegalle">Kegalle</option>
                <option value="Killinochchi">Killinochchi</option>
                <option value="Kurunegala">Kurunegala</option>
                <option value="Mannar">Mannar</option>
                <option value="Matale">Matale</option>
                <option value="Matara">Matara</option>
                <option value="Moneragala">Moneragala</option>
                <option value="Mullaitivu">Mullaitivu</option>
                <option value="Nuwara Eliya">Nuwara Eliya</option>
                <option value="Polonnaruwa">Polonnaruwa</option>
                <option value="Puttalam">Puttalam</option>
                <option value="Ratnapura">Ratnapura</option>
                <option value="Trincomalee">Trincomalee</option>
                <option value="Vavuniya">Vavuniya</option>
            </select>
        </div>
        <div class="form-field">
            <label>Zip Code</label>
            <input type="number" name="price" required>
        </div>
        <div class="form-field">
            <label>Email</label>
            <input type="email" name="weight" required>
        </div>
        <div class="form-field">
            <label>Rate First kg (Rs.) </label>
            <input type="number" min="0" max="5000" step="0.01" name="price" required>
        </div>
        <div class="form-field">
            <label>Rate Extra kg (Rs.)</label>
            <input type="number" min="0" max="5000" step="0.01" name="price" required>
        </div>
        <div class="form-field">
            <label>Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-field">
            <label>Confirm Password</label>
            <input type="password" id="confirm-pwd" name="confirmPassword" required>
        </div>
        <br>
        <p class="form-error"></p>
        <p>
            <button type="submit" class="add-btn">
                <span class="material-symbols-outlined">save</span>
                <span class="add-book">Add Courier</span>
                <!-- <span class="edit-book">Update Info</span> -->
            </button>
        </p>


    </form>
</addBook>
<?php $this->view('includes/footer'); ?>

<script>
    let error = document.querySelector('.form-error');
    let form = document.querySelector('.frm-add-courier');
    form.addEventListener('submit', (event) => {
        // alert("submit clicked");
        event.preventDefault();
        let pwd = document.querySelector('#password').value;
        let cnfmPwd = document.querySelector('#confirm-pwd').value;
        if (pwd !== cnfmPwd) {
            error.innerText = "Passwords do not match!";
        }
    })
</script>