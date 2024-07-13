<?php $this->view('includes/header') ?>
<books>

    <div class="app-content">
        <section class="top-rated-books">
            <div class="search-container">
                <input id="search" placeholder="Search books..." type="search" onkeyup="searchChanged(this)" onchange="searchChanged(this)">
                <span class="material-symbols-outlined">search</span>
            </div>
            <div class="cats">
                <a href="<?= ROOT ?>/books">All</a>
                <?php foreach ($data['categories'] as $category) : ?>
                    <a href="<?= ROOT ?>/books/category/<?= $category->category_id ?>"><?= $category->name ?></a>
                <?php endforeach; ?>
            </div>
            <div class="top-rated-book-box book-list">
                <?php if (!empty($data['bookList'])) : ?>
                    <?php foreach ($data['bookList'] as $book) : ?>
                        <div class="top-rated-book-card">
                            <div class="top-rated-book-img">
                                <img src="<?= $book->book_image ? ROOT . '/' . $book->book_image : ROOT . '/uploads/books/default.jpg'; ?>">
                            </div>
                            <div class="top-rated-book-tag">
                                <h2><?= $book->title ?></h2>
                                <p class="writer"><?= $book->author ?></p>
                                <?php foreach (explode(',', $book->categories) as $category) : ?>
                                    <div class="categories"><?= $category ?></div>
                                <?php endforeach; ?>
                                <p class="book-price"><?= $book->price ?></p>
                                <br>
                                <a href="<?= ROOT ?>/books/details/<?= $book->book_id ?>" class="f-btn">Learn More</a>
                                <br>
                                <br>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <h4>No books available for this category</h4>
                <?php endif; ?>
            </div>
        </section>
    </div>
</books>
<?php $this->view('includes/footer'); ?>