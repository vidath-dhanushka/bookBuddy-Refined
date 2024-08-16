<?php $this->view('elibrary/includes/header'); ?>
<div class="app-content">
    <div class="elibrary-favorite-books">
        <h1>My Favorite Books</h1>
        <div class="elibrary-book-list">
            <?php if (!empty($favourite_list)) : ?>
                <?php foreach ($favourite_list as $ebook) : ?>
                    <div class="elibrary-book-card">
                        <a href="<?= ROOT ?>/elibrary/ebook/<?= $ebook->ebook_id ?>">
                            <img src="<?= $ebook->book_cover ? ROOT . '/' . $ebook->book_cover : ROOT . '/uploads/books/default.jpg' ?>" alt="Book Cover" class="elibrary-book-cover">
                            <div class="elibrary-book-details">
                                <h2 class="elibrary-book-title"><?= htmlspecialchars($ebook->title) ?></h2>
                                <p class="elibrary-book-author"><?= htmlspecialchars($ebook->author) ?></p>
                            </div>
                        </a>
                        <a href="<?= ROOT ?>/elibrary/remove_favourite/<?= $ebook->ebook_id ?>" class="elibrary-favorite-btn elibrary-favourite-filled">
                            <i class="fas fa-heart"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No favorite books found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $this->view('includes/footer'); ?>