<?php $this->view('includes/header') ?>
<books>

    <div class="app-content">
        <section class="top-rated-books">
            <div class="search-container">
                <input id="search" placeholder="Search books..." type="search">
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
                        <div class="top-rated-book-card" data-title="<?= $book->title ?>" data-author="<?= $book->author ?>">
                            <div class="top-rated-book-img">
                                <img src="<?= $book->book_image ? ROOT . '/' . $book->book_image : ROOT . '/uploads/books/default.jpg'; ?>">
                            </div>
                            <div class="top-rated-book-tag">
                                <h2><?= $book->title ?></h2>
                                <p class="writer"><?= $book->author ?></p>

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
<script>
    const search = document.querySelector("#search");
    const items = document.querySelectorAll(".top-rated-book-card")
    search.addEventListener("input", (e) => {

        let inputValue = e.target.value.toLowerCase();
        items.forEach(item => {
            if (item.dataset.author.toLowerCase().includes(inputValue) || item.dataset.title.toLowerCase().includes(inputValue)) {
                item.classList.remove("no-display");
            } else {

                item.classList.add("no-display");
            }
        })
    })
</script>
<?php $this->view('includes/footer'); ?>