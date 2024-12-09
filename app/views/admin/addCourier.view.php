<?php $this->view("admin/includes/sidenav") ?>
<addBook>
    <h1 class="title add-book">Add Courier Company</h1>
    <form class="frm-add-courier" jsubmit="addCourier" id="uploadForm" method="POST" enctype="multipart/form-data">
    
        <!-- <label>Book Image</label> -->
        <div class="form-field">
            <label>Company Name</label>
            <input type="text" name="company_name" value="<?= set_value('first_name') ?>" required1>
        </div>
        <div class="form-field">
            <label>Reg No</label>
            <input type="text" name="reg_no" value="<?= set_value('username') ?>" required1>
        </div>
        <div class="form-field">
            <label>Email</label>
            <input type="email" name="email" value="<?= set_value('email') ?>" required1>
        </div>
        <div class="form-field">
            <label>Phone</label>
            <input type="text" name="phone" pattern=".{9,12}" value="<?= set_value('phone') ?>" required1>
        </div>
        <div class="form-field">
            <label>Address</label>
            <input type="text" name="address_line1" required>
        </div>
        <div class="form-field">
            <label>City</label>
            <input type="text" name="address_city" required>
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
            <label>Rate First kg</label>
            <input type="number" name="rate_first_kg" required>
        </div>
        <div class="form-field">
            <label>Rate Extra kg</label>
            <input type="number" name="rate_extra_kg" required>
        </div>
        <div class="form-field">
            <label>Password</label>
            <input type="password" id="password" name="password" pattern=".{8,}" value="<?= set_value('password') ?>" required1>
        </div>
        <div class="form-field">
            <label>Confirm Password</label>
            <input type="password" id="confirm-pwd" name="confirm_password" pattern=".{8,}" value="<?= set_value('confirm_password') ?>" required1>
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

<script>
    
</script>