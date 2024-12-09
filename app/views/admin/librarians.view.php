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
            <?php foreach ($data['librarian'] as $librarian):?>
        <tr>
            <td><?php echo $librarian->username ?></td>
            <td><?php echo $librarian->first_name ?></td>
            <td><?php echo $librarian->last_name ?></td>
            <td><?php echo $librarian->email ?></td>
            <td><?php echo $librarian->phone ?></td>
           
            
            
            <td>
            
            <a class="book-btn delete" href="<?= ROOT ?>/admin/deleteLibrarian/<?= $librarian->user_id ?>">
            <span class="material-symbols-outlined" style="position: relative; top:0; left:10px">
                    delete
                </span>
                            </a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody> 
       
    </table>
</adminCourier>