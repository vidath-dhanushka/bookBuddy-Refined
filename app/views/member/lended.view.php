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
    <?php if (!empty($data['lended_books'])) : ?>
        <div class="book-list">
            <?php foreach ($data['lended_books'] as $book) : ?>
                <div class="book-container">
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
                    <div class="lendedUsers">
                        <p>lended Users</p>
                        <span class="material-symbols-outlined">
                            expand_circle_down
                        </span>
                    </div>
                    <div class="lended-list">
                        <?php if (!empty($book->user_ratings)) : ?>
                            <?php foreach ($book->user_ratings as $rating) : ?>
                                <div class="lend-user" data-rating-id="<?= $rating->user_rating_id ?>">
                                    <span class="lend-name"><?= $rating->borrower_username ?></span>
                                    <span><?= $rating->reg_time ?></span>
                                    <div class="rating-stars" data-current-rating="<?= $rating->rating ?>">
                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                            <span class="material-symbols-outlined <?= ($i < $rating->rating) ? 'filled' : '' ?>" data-value="<?= $i + 1 ?>">grade</span>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="lend-rating">rate User</span>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No lenders available</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>No books available for lending. Add new book</p>
    <?php endif; ?>
</lendedBooks>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.lendedUsers').forEach(lended => {
            let lendList = lended.nextElementSibling;
            lendList.style.display = 'none';

            lended.addEventListener('click', function() {
                if (lendList.style.display === 'none') {
                    lendList.style.display = 'block';
                } else {
                    lendList.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('.lend-user').forEach(lendUser => {
            const ratingStars = lendUser.querySelector('.rating-stars');
            const currentRating = parseInt(ratingStars.dataset.currentRating);
            const ratingId = lendUser.dataset.ratingId;

            updateStars(ratingStars, currentRating);

            ratingStars.querySelectorAll('.material-symbols-outlined').forEach(star => {
                star.addEventListener('click', function() {
                    const newRating = parseInt(this.dataset.value);
                    updateStars(ratingStars, newRating);
                    ratingStars.dataset.newRating = newRating;
                });
            });

            const rateUserSpan = lendUser.querySelector('.lend-rating');
            rateUserSpan.addEventListener('click', function() {
                const newRating = ratingStars.dataset.newRating ? parseInt(ratingStars.dataset.newRating) : currentRating;

                submitRating(ratingId, newRating);
            });

            function updateStars(starContainer, rating) {
                starContainer.querySelectorAll('.material-symbols-outlined').forEach((star, index) => {
                    if (index < rating) {
                        star.classList.add('filled');
                    } else {
                        star.classList.remove('filled');
                    }
                });
            }

            function submitRating(ratingId, newRating) {

                fetch(`<?= ROOT ?>/member/updateRating/${ratingId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            rating: newRating
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Rating updated successfully');
                        } else {
                            alert('Failed to update rating');
                            updateStars(ratingStars, currentRating);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        updateStars(ratingStars, currentRating);
                    });
            }
        });
    });
</script>



<?php $this->view('member/includes/footer'); ?>