<?php $this->view('courier/includes/sidenav'); ?>

<?php if (message()) : ?>
    <div class="message"><?= message('', true) ?></div>
<?php endif; ?>
<memberProfile>
    <h1 class="title">My Profile</h1>
    <form class="frm-add-book" method="POST">
        <div class="form-field">
            <label>Username</label>
            <input disabled type="text" name="username" value="<?= $data['user_data']->username ?>" required1>
        </div>
        <div class="form-field">
            <label>First Name</label>
            <input name="first_name" value="<?= $data['user_data']->first_name ?>" required1>
            <?php if (!empty($errors['first_name'])) : ?>
                <div class="error"><?= $errors['first_name'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?= $data['user_data']->last_name ?>" required1>
            <?php if (!empty($errors['last_name'])) : ?>
                <div class="error"><?= $errors['last_name'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Email</label>
            <input disabled type="text" name="email" value="<?= $data['user_data']->email ?>">
        </div>
        <div class="form-field">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= $data['user_data']->phone ?>" required1>
            <?php if (!empty($errors['phone'])) : ?>
                <div class="error"><?= $errors['phone'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Address Line 1</label>
            <input type="text" name="address_line1" value="<?= $data['user_data']->address_line1 ?>">
            <?php if (!empty($errors['address_line1'])) : ?>
                <div class="error"><?= $errors['address_line1'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Address Line 2</label>
            <input type="text" name="address_line2" value="<?= $data['user_data']->address_line2 ?>">
            <?php if (!empty($errors['address_line2'])) : ?>
                <div class="error"><?= $errors['address_line2'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Address City</label>
            <input type="text" name="address_city" value="<?= $data['user_data']->address_city ?>">
            <?php if (!empty($errors['address_city'])) : ?>
                <div class="error"><?= $errors['address_city'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Address District</label>
            <select name="address_district" class="district-list" id="district_list" required1>
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
            <?php if (!empty($errors['address_district'])) : ?>
                <div class="error"><?= $errors['address_district'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-field">
            <label>Zip code</label>
            <input type="number" name="address_zip" value="<?= $data['user_data']->address_zip; ?>">
            <?php if (!empty($errors['address_zip'])) : ?>
                <div class="error"><?= $errors['address_zip'] ?></div>
            <?php endif; ?>
        </div>
        <p class="form-error"></p>
        <p>
            <button type="submit" class="add-btn">
                <!-- <span class="material-symbols-outlined">person</span> -->
                Update Profile
            </button>
        </p>


    </form>
</memberProfile>
<script>
    let userData = <?php echo json_encode($data['user_data']); ?>;
    let district = document.querySelector('#district_list');
    district.value = userData['address_district'];
</script>