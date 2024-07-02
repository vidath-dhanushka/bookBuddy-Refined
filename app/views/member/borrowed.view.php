<?php $this->view('member/includes/sidenav') ?>
<borrowedBooks>
    <h1 class="title">My Borrowings</h1>
    <div class="book-list">
        <div class="book">
            <div class="book-img">
                <img src="/api/uploads/${u.image || 'default.jpg'}">
            </div>
            <div class="top-rated-book-tag">
                <h2>${u.title}</h2>
                <p class="writer">By ${u.author || ""}</p>
                <div class="categories">${u.categories || ""}</div>
                <p class="book-price">Deposit:<br>Rs ${u.price}</p>
                <p class="book-price">Borrowed on:<br><i>${u.reg_time}</i></p>
                <a href="<?= ROOT ?>/books/${u.book_id}?review=1" class="status">Rate / Review</a>
            </div>
        </div>
        <div class="book">
            <div class="book-img">
                <img src="/api/uploads/${u.image || 'default.jpg'}">
            </div>
            <div class="top-rated-book-tag">
                <h2>${u.title}</h2>
                <p class="writer">By ${u.author || ""}</p>
                <div class="categories">${u.categories || ""}</div>
                <p class="book-price">Deposit:<br>Rs ${u.price}</p>
                <p class="book-price">Borrowed on:<br><i>${u.reg_time}</i></p>
                <a href="<?= ROOT ?>/books/details/${u.book_id}?review=1" class="status">Rate / Review</a>
            </div>
        </div>
    </div>
    <SCript>
        let a = <? json_encode($data["ff"]) ?>;
    </SCript>
</borrowedBooks>

<?php $this->view('member/includes/footer'); ?>