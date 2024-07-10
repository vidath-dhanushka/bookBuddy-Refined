<?php $this->view('member/includes/sidenav'); ?>
<lendedBooks>
    <?php if (message()) : ?>
        <div class="message"><?= message('', true) ?></div>
    <?php endif; ?>
    <h1 class="title">My Books</h1>
    <p>
        <a class="add-book-btn" href="<?= ROOT ?>/member/addBook">
            <span class="material-symbols-outlined">add</span>
            Add New Book
        </a>
    </p>
    <div class="book-list">
        <?php foreach ($data['lended_books'] as $book) : ?>
            <div class="book">
                <div class="book-img">
                    <img src="<?= $book->book_image ? ROOT . '/' . $book->book_image : ROOT . '/uploads/books/default.jpg'; ?>" alt="<?= htmlspecialchars($book->title); ?>">
                </div>
                <div class="top-rated-book-tag">
                    <h2><?= htmlspecialchars($book->title) ?></h2>
                    <p class="writer"><?= htmlspecialchars($book->author) ?></p>
                    <div class="categories">
                        <?php if (!empty($book->categories)) : ?>
                            <?php foreach (explode(',', $book->categories) as $category) : ?>
                                <span class="category"><?= htmlspecialchars(trim($category)) ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <p class="book-price">Rs <?= htmlspecialchars($book->price) ?></p>
                    <br>
                    <span class="status <?= htmlspecialchars($book->status) ?>"><?= strtoupper(htmlspecialchars($book->status)) ?></span>
                    <br>
                    <br>
                </div>
                <div class="book-actions" style="display: <?= htmlspecialchars($book->status) == 'deleted' ? 'none' : 'flex'; ?>">
                    <a class="book-btn edit" href="<?= ROOT ?>/member/editBook/<?= $book->book_id ?>">
                        <span class="material-symbols-outlined">edit</span>
                        Edit
                    </a>
                    <a class="book-btn delete" href="<?= ROOT ?>/member/deleteBook/<?= $book->book_id ?>">
                        <span class="material-symbols-outlined">delete</span>
                        Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</lendedBooks>
<?php $this->view('member/includes/footer'); ?>