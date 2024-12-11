<?php $this->view('admin/includes/sidenav'); ?>
<adminCourier>
    <h1 class="title">Librarians</h1>
    <div class="search-container">
        
        <a class="new-courier" href="<?= ROOT ?>/admin/addLibrarian">
            <span class="material-symbols-outlined">add</span>
            New</a>
    </div>
    <table>
    <thead>
        <tr>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Contact No.</th>
            <th>Actions</th>
         
        </tr>
        </thead>
       
        <tbody>
            <?php if (!empty($data['librarian'][0]->user_id)): ?>
                <?php foreach ($data['librarian'] as $librarian): ?>
                    <tr>
                        <td><?php echo $librarian->first_name ?></td>
                        <td><?php echo $librarian->last_name ?></td>
                        <td><?php echo $librarian->email ?></td>
                        <td><?php echo $librarian->phone ?></td>
                        <td><?php echo $librarian->address_district ?></td>

                        <td>
                            <a href="#" class="button" onclick="openPopup('<?php echo $librarian->user_id; ?>')">
                                <span class="material-symbols-outlined"
                                    style="position: relative; top:0; left:10px">delete</span>
                            </a>

                            <!-- Overlay -->
                            <div id="overlay_<?php echo $librarian->user_id; ?>"
                                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;"
                                onclick="closePopup('<?php echo $librarian->user_id; ?>')">
                            </div>

                            <!-- Modal Box -->
                            <div id="modal_<?php echo $librarian->user_id; ?>"
                                style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 300px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); z-index: 1001; text-align: center;">
                                <i class="fa-solid fa-trash-can"></i>
                                <h2 style="margin-bottom: 10px;">Confirm Deletion</h2>
                                <p style="margin-bottom: 20px;">Are you sure you want to delete?</p>
                                <div class="btn">
                                    <button class="close-btn" onclick="confirmDelete('<?php echo $librarian->user_id; ?>')"
                                        style="background-color: #f44336; color: white; border: none; padding: 10px 15px; margin: 5px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
                                        Delete
                                    </button>
                                    <button class="close-btn" onclick="closePopup('<?php echo $librarian->user_id; ?>')"
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
    function openPopup(user_id) {
        let modal = document.getElementById(`modal_${user_id}`);
        let overlay = document.getElementById(`overlay_${user_id}`);
        if (modal && overlay) {
            modal.style.display = "block";
            overlay.style.display = "block";
        }
    }

    function closePopup(user_id) {
        let modal = document.getElementById(`modal_${user_id}`);
        let overlay = document.getElementById(`overlay_${user_id}`);
        if (modal && overlay) {
            modal.style.display = "none";
            overlay.style.display = "none";
        }
    }

    overlay.addEventListener("click", () => {
        modalBox.classList.remove("active");
        overlay.classList.remove("active");
    });



    function confirmDelete(user_id) {
        $.ajax({
            url: `<?= ROOT ?>/admin/deleteLibrarian/${user_id}`,
            type: "POST",
            success: function (response) {
                const result = JSON.parse(response); // Parse JSON response
                if (result.success) {
                    console.log("Librarian deleted successfully.");
                    window.location.reload();
                    document.querySelector(`tr[data-user-id="${user_id}"]`).remove();
                } else {
                    console.error(result.message); // Log error message
                    alert(result.message); // Display error to user
                }
            },
            error: function (error) {
                console.error("AJAX request failed:", error);
                alert("An unexpected error occurred. Please try again later.");
            },
        });
    }
</script>