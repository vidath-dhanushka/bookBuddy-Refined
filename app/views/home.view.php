<?php $this->view('includes/header') ?>
<div class="app-content">
    <home>
        <section class="banner">
            <div class="banner-content">
                <div>
                    Unlock the power <br> of knowledge with <br> <span>Bookbuddy</span>
                </div>
            </div>
            <div class="img-container">
                <img src="<?= ROOT ?>/assets/images/bannar-img.png" alt="home-img">
            </div>
        </section>
        <section class="top-rated-books">
            <h1>Newly Added Books</h1>
            <div class="top-rated-book-box book-list">
                <?php foreach ($data['recent_books'] as $book) : ?>
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
                            <a href="/book/${u.book_id}" class="f-btn">Learn More</a>
                            <br>
                            <br>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- <div class="top-rated-book-card">
                    <div class="top-rated-book-img">
                        <img src="/api/uploads/${u.image || 'default.jpg'}">
                    </div>
                    <div class="top-rated-book-tag">
                        <h2>Fuck</h2>
                        <p class="writer">Fucker</p>
                        <div class="categories">${u.categories || ""}</div>
                        <p class="book-price">Rs ${u.price}</p>
                        <br>
                        <a href="/book/${u.book_id}" class="f-btn">Learn More</a>
                        <br>
                        <br>
                    </div>
                </div> -->
            </div>
        </section>
        <section class="aboutUs">
            <h1>WHO WE ARE</h1>
            <p>Welcome to Book Buddy, a platform created by UCSC students to connect book lovers across Sri Lanka.
                Our mission is to promote literacy and community engagement through the joy of reading.
                We partner with schools and libraries to distribute books to underserved communities, fostering a culture of lifelong learning.
                Join us in making reading accessible to everyone and spreading the joy of sharing books!</p>
        </section>
    </home>
    <br>
</div>
<!-- <?php $this->view('includes/footer') ?> -->