<?php $this->view('admin/includes/sidenav'); ?>
<adminCourier>
    <h1 class="title">Couriers</h1>
    <?php if (message()) : ?>
                    <div class="message"><?= message('', true) ?></div>
                <?php endif; ?>
    <div class="search-container">
        <input id="search" placeholder="Search ...." type="search">
        <span class="material-symbols-outlined">search</span>
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
            <a class="book-btn delete" href="<?= ROOT ?>/admin/deleteCourier/<?= $courier->courier_id ?>">
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

<script>
    let status = document.querySelectorAll('.status');
    status.forEach((stus) => {
        stus.addEventListener('click', () => {
            if (stus.innerHTML === 'toggle_on') {
                stus.innerHTML = 'toggle_off';
                stus.style.color = 'red';
            } else {
                stus.innerHTML = 'toggle_on';
                stus.style.color = 'green';
            }
        })
    })
</script>