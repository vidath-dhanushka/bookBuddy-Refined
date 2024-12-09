<?php $this->view('elibrary/includes/header'); ?>
<div class="app-content">
    <home>
        <section class="banner">
            <div class="banner-content">
                <div>
                    Unlock the power <br> of knowledge with <br> <span>Bookbuddy</span>
                </div>
            </div>
            <div class="img-container">
                <img src="<?= ROOT ?>/assets/images/elibrary_banner.png" alt="home-img">
            </div>
        </section>
        <?php if (!empty($data['recent_ebooks'])) : ?>
            <section class="top-rated-books">
                <h1>Newly Added E-Books</h1>
                <div class="top-rated-book-box book-list">
                    <?php foreach ($data['recent_ebooks'] as $ebook) : ?>
                        <div class="top-rated-book-card">
                            <div class="top-rated-book-img">
                                <img src="<?= $ebook->book_cover ? ROOT . '/' . $ebook->book_cover : ROOT . '/uploads/books/default.jpg'; ?>">
                            </div>

                            <div class="top-rated-book-tag">
                                <h2><?= htmlspecialchars($ebook->title) ?></h2>
                                <p class="writer"><?= htmlspecialchars($ebook->author_name) ?></p>
                                <?php foreach (explode(',', $ebook->categories) as $category) : ?>
                                    <div class="categories"><?= htmlspecialchars($category) ?></div>
                                <?php endforeach; ?>

                                <br>
                                <a href="<?= ROOT ?>/elibrary/ebook/<?= $ebook->ebook_id ?>" class="f-btn">Learn More</a>
                                <br>
                                <br>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>


    </home>
    <br>
</div>
<?php $this->view('includes/footer');
