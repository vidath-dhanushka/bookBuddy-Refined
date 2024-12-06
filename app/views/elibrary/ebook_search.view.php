<?php $this->view('elibrary/includes/header') ?>
<books>
    <div class="app-content">
        <section class="top-rated-books">
            <div class="search-container">
                <input id="search" placeholder="Search books..." type="search">
                <span class="material-symbols-outlined">search</span>
            </div>
            <div class="cats">
                <a href="<?= ROOT ?>/elibrary/search">All</a>
                <?php if (!empty($data['categories'])) : ?>
                    <?php foreach ($data['categories'] as $category) : ?>
                        <a href="<?= ROOT ?>/elibrary/search/category/<?= $category->category_id ?>"><?= $category->name ?></a>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No categories available.</p>
                <?php endif; ?>
            </div>
            <div class="top-rated-book-box book-list">
                <?php if (!empty($data['ebookList'])) : ?>
                    <?php foreach ($data['ebookList'] as $ebook) : ?>
                        <div class="top-rated-book-card" data-title="<?= $ebook->title ?>" data-author="<?= $ebook->author ?>">
                            <div class="top-rated-book-img">
                                <img src="<?= $ebook->book_cover ? ROOT . '/' . $ebook->book_cover : ROOT . '/uploads/books/default.jpg'; ?>">
                            </div>
                            <div class="top-rated-book-tag">
                                <h2><?= $ebook->title ?></h2>
                                <p class="writer"><?= $ebook->author_name ?></p>
                                <br>
                                <a href="<?= ROOT ?>/elibrary/ebook/<?= $ebook->ebook_id ?>" class="f-btn">Learn More</a>
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