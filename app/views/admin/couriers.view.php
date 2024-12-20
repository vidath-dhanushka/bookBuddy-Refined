<?php $this->view('admin/includes/sidenav'); ?>
<adminCourier>
    <h1 class="title">Couriers</h1>
    <div class="search-container">
        <input id="search" placeholder="Search ...." type="search">
        <span class="material-symbols-outlined">search</span>
        <a class="new-courier" href="<?= ROOT ?>/admin/addCourier">
            <span class="material-symbols-outlined">add</span>
            New</a>
    </div>
    <table>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>contact No.</th>
            <th>status</th>
            <th>actions</th>
        </tr>
        <tr>
            <td>Vidath</td>
            <td>8/2, Wata mawatha, Horathuduwa, Polgasowita</td>
            <td>772205749</td>
            <td><span class="material-symbols-outlined status" style="position: relative; top:0; left:25px">toggle_on</span>
            </td>
            <td><span class="material-symbols-outlined" style="position: relative; top:0; left:0">
                    edit
                </span>
                <span class="material-symbols-outlined" style="position: relative; top:0; left:10px">
                    delete
                </span>
            </td>
        </tr>
        <tr>
            <td>Vidath</td>
            <td>8/2, Wata mawatha, Horathuduwa, Polgasowita</td>
            <td>772205749</td>
            <td><span class="material-symbols-outlined status" style="position: relative; top:0; left:25px">toggle_on</span>
            </td>
            <td><span class="material-symbols-outlined" style="position: relative; top:0; left:0">
                    edit
                </span>
                <span class="material-symbols-outlined" style="position: relative; top:0; left:10px">
                    delete
                </span>
            </td>
        </tr>
        <tr>
            <td>Vidath</td>
            <td>8/2, Wata mawatha, Horathuduwa, Polgasowita</td>
            <td>772205749</td>
            <td><span class="material-symbols-outlined status" style="position: relative; top:0; left:25px">toggle_on</span>
            </td>
            <td><span class="material-symbols-outlined" style="position: relative; top:0; left:0">
                    edit
                </span>
                <span class="material-symbols-outlined" style="position: relative; top:0; left:10px">
                    delete
                </span>
            </td>
        </tr>
        <tr>
            <td>Vidath</td>
            <td>8/2, Wata mawatha, Horathuduwa, Polgasowita</td>
            <td>772205749</td>
            <td><span class="material-symbols-outlined status" style="position: relative; top:0; left:25px">toggle_on</span>
            </td>
            <td><span class="material-symbols-outlined" style="position: relative; top:0; left:0">
                    edit
                </span>
                <span class="material-symbols-outlined" style="position: relative; top:0; left:10px">
                    delete
                </span>
            </td>
        </tr>
        <tr>
            <td>Vidath</td>
            <td>8/2, Wata mawatha, Horathuduwa, Polgasowita</td>
            <td>772205749</td>
            <td><span class="material-symbols-outlined status" style="position: relative; top:0; left:25px">toggle_on</span>
            </td>
            <td><span class="material-symbols-outlined" style="position: relative; top:0; left:0">
                    edit
                </span>
                <span class="material-symbols-outlined" style="position: relative; top:0; left:10px">
                    delete
                </span>
            </td>
        </tr>
        <tr>
            <td>Vidath</td>
            <td>8/2, Wata mawatha, Horathuduwa, Polgasowita</td>
            <td>772205749</td>
            <td><span class="material-symbols-outlined status" style="position: relative; top:0; left:25px">toggle_on</span>
            </td>
            <td><span class="material-symbols-outlined" style="position: relative; top:0; left:0">
                    edit
                </span>
                <span class="material-symbols-outlined" style="position: relative; top:0; left:10px">
                    delete
                </span>
            </td>
        </tr>
        <tr>
            <td>Vidath</td>
            <td>8/2, Wata mawatha, Horathuduwa, Polgasowita</td>
            <td>772205749</td>
            <td><span class="material-symbols-outlined status" style="position: relative; top:0; left:25px">toggle_on</span>
            </td>
            <td><span class="material-symbols-outlined" style="position: relative; top:0; left:0">
                    edit
                </span>
                <span class="material-symbols-outlined" style="position: relative; top:0; left:10px">
                    delete
                </span>
            </td>
        </tr>
    </table>
</adminCourier>
<?php $this->view('includes/footer'); ?>
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