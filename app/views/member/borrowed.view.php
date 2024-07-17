<?php $this->view('member/includes/sidenav') ?>
<borrowedBooks>

    <h1 class="title">My Borrowings</h1>
    <div class="book-list">
        <?php foreach ($data['borrowedBooks'] as $book) : ?>
            <div class="book">
                <div class="book-img">
                    <img src="<?= $book->book_image ? ROOT . '/' . $book->book_image : ROOT . '/uploads/books/default.jpg'; ?>" alt="<?= htmlspecialchars($book->title); ?>">
                </div>
                <div class="top-rated-book-tag">
                    <h2><?= $book->title ?></h2>
                    <p class="writer">By <?= $book->author ?></p>
                    <!-- <div class="categories">${u.categories || ""}</div> -->
                    <p class="book-price">Deposit:<br>Rs <?= $book->price ?></p>
                    <p class="book-price">Borrowed on:<br><i><?= $book->reg_time ?></i></p>
                    <a href="<?= ROOT ?>/books/details/<?= $book->book_id ?>" class="status">Rate / Review</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <SCript>
        let a = <? json_encode($data["ff"]) ?>;
    </SCript>
</borrowedBooks>

<?php $this->view('member/includes/footer'); ?>