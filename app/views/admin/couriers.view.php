<?php $this->view('admin/includes/sidenav'); ?>
<adminCourier>
    <h1 class="title">Couriers</h1>
    <!-- <?php if (message()) : ?>
                    <div class="message"><?= message('', true) ?></div>
                <?php endif; ?> -->
    <div class="search-container">
        
        <a class="new-courier" href="<?= ROOT ?>/admin/addCourier">
            <span class="material-symbols-outlined">add</span>
            New</a>
    </div>
    <table>
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Reg No</th>
            <th>Email</th>
            <th>Contact No.</th>
            <th>Rate First kg</th>
            <th>Rate Extra kg</th>
            <th>Actions</th>
        </tr>
        </thead>
       
        <tbody> 
        <?php if (!empty($data['courier'][0]->courier_id)): ?>
            <?php foreach ($data['courier'] as $courier):?>
        <tr>
            <td><?php echo $courier->company_name ?></td>
            <td><?php echo $courier->reg_no ?></td>
            <td><?php echo $courier->email ?></td>
            <td><?php echo $courier->phone ?></td>
            <td><?php echo $courier->rate_first_kg ?></td>
            <td><?php echo $courier->rate_extra_kg ?></td>
            
            <td>
                            <a href="#" class="button" onclick="openPopup('<?php echo $courier->courier_id; ?>')">
                                <span class="material-symbols-outlined"
                                    style="position: relative; top:0; left:10px">delete</span>
                            </a>

                            <!-- Overlay -->
                            <div id="overlay_<?php echo $courier->courier_id; ?>"
                                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;"
                                onclick="closePopup('<?php echo $courier->courier_id; ?>')">
                            </div>

                            <!-- Modal Box -->
                            <div id="modal_<?php echo $courier->courier_id; ?>"
                                style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 300px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); z-index: 1001; text-align: center;">
                                <i class="fa-solid fa-trash-can"></i>
                                <h2 style="margin-bottom: 10px;">Confirm Deletion</h2>
                                <p style="margin-bottom: 20px;">Are you sure you want to delete?</p>
                                <div class="btn">
                                    <button class="close-btn" onclick="confirmDelete('<?php echo $courier->courier_id; ?>')"
                                        style="background-color: #f44336; color: white; border: none; padding: 10px 15px; margin: 5px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
                                        Delete
                                    </button>
                                    <button class="close-btn" onclick="closePopup('<?php echo $courier->courier_id; ?>')"
                                        style="background-color: #f44336; color: white; border: none; padding: 10px 15px; margin: 5px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>

    </table>
</adminCourier>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    function openPopup(courier_id) {
        let modal = document.getElementById(`modal_${courier_id}`);
        let overlay = document.getElementById(`overlay_${courier_id}`);
        if (modal && overlay) {
            modal.style.display = "block";
            overlay.style.display = "block";
        }
    }

    function closePopup(courier_id) {
        let modal = document.getElementById(`modal_${courier_id}`);
        let overlay = document.getElementById(`overlay_${courier_id}`);
        if (modal && overlay) {
            modal.style.display = "none";
            overlay.style.display = "none";
        }
    }

    overlay.addEventListener("click", () => {
        modalBox.classList.remove("active");
        overlay.classList.remove("active");
    });



    function confirmDelete(courier_id) {
        $.ajax({
            url: `<?= ROOT ?>/admin/deleteCourier/${courier_id}`,
            type: "POST",
            success: function (response) {
                const result = JSON.parse(response); // Parse JSON response
                if (result.success) {
                    console.log("Librarian deleted successfully.");
                    window.location.reload();
                    document.querySelector(`tr[data-courier-id="${courier_id}"]`).remove();
                } else {
                    console.error(result.message); // Log error message
                    alert(result.message); // Display error to courier
                }
            },
            error: function (error) {
                console.error("AJAX request failed:", error);
                alert("An unexpected error occurred. Please try again later.");
            },
        });
    }
</script>