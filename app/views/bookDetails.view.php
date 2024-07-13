<?php $this->view('includes/header'); ?>
<bookDetails>

    <div class="app-content">
        <div class="main-container">
            <div class="container-left">
                <img id="thumb" src="<?= $data['bookDetails'][0]->book_image ? ROOT . '/' . $data['bookDetails'][0]->book_image : ROOT . '/uploads/books/default.jpg'; ?>">
            </div>
            <div class="container-right">
                <p class="book-title"><?= $data['bookDetails'][0]->title ?></p>
                <p>By <span><?= $data['bookDetails'][0]->author ?></span></p>
                <br>
                <div class="tags" book-data="tags">
                    <?php foreach (explode(',', $data['bookDetails'][0]->categories) as $category) : ?>
                        <span><?= $category ?></span>
                    <?php endforeach; ?>
                </div>
                <p class="description"><?= $data['bookDetails'][0]->description ?></p>
                <p class="price">Deposit: Rs. <span><?= $data['bookDetails'][0]->price ?></span></p>
                <p>(Owner from <span book-data="location"></span>)</p>
                <br>
                <div>
                    <?php if ($data['bookDetails'][0]->status == 'available') : ?>
                        <div class="borrow-btn borrow" onclick="borrow()">Borrow Now</div>
                        <div class="borrow-btn" onclick="borrow(true, event)">Add to Cart</div>
                    <?php else : ?>
                        <div class="borrow-btn na">Currently Unavailable</div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php if (!empty($data['borrowedBook'])) : ?>
            <div class="main-container review new-review">
                <div class="review-content">
                    <h2>Your Review</h2>
                    Rating:
                    <div id="my-stars" class="stars">
                        <span class="material-symbols-outlined" data-value="1">star</span>
                        <span class="material-symbols-outlined" data-value="2">star</span>
                        <span class="material-symbols-outlined" data-value="3">star</span>
                        <span class="material-symbols-outlined" data-value="4">star</span>
                        <span class="material-symbols-outlined" data-value="5">star</span>
                    </div>
                    <br>
                    Review:
                    <textarea rows="8" id="review"></textarea>
                    <br>
                    <p class="form-error"></p>
                    <div class="review-btn" onclick="postReview()">Post Review</div>
                </div>
            </div>
        <?php endif; ?>
        <div class="main-container review">
            <div class="review-content">
                <h2>Reviews</h2>
                <div id="reviews">
                    <?php if (!empty($data['reviews'])) : ?>
                        <?php foreach ($data['reviews'] as $review) : ?>
                            <div class="r-stars">
                                <?php for ($i = 0; $i < 5; $i++) : ?>
                                    <span class="material-symbols-outlined <?= ($i < $review->rating) ? 'filled' : '' ?>">grade</span>
                                <?php endfor; ?>
                                <p class="review-text">
                                    <?= $review->review; ?>
                                </p>
                                <p>By <i><?= $review->username ?></i></p>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <p>No reviews yet</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</bookDetails>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.stars .material-symbols-outlined');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                let rating = this.getAttribute('data-value');
                setRating(rating);
            });

            star.addEventListener('mouseover', function() {
                let rating = this.getAttribute('data-value');
                highlightStars(rating);
            });

            star.addEventListener('mouseout', function() {
                resetStars();
            });
        });

        function setRating(rating) {
            document.querySelector('.stars').setAttribute('data-rating', rating);
            highlightStars(rating);
        }

        function highlightStars(rating) {
            stars.forEach(star => {
                if (star.getAttribute('data-value') <= rating) {
                    star.classList.add('filled');
                } else {
                    star.classList.remove('filled');
                }
            });
        }

        function resetStars() {
            let rating = document.querySelector('.stars').getAttribute('data-rating');
            highlightStars(rating);
        }

        window.postReview = function() {
            let rating = document.querySelector('.stars').getAttribute('data-rating');
            let review = document.getElementById('review').value;

            if (!rating || !review) {
                document.querySelector('.form-error').textContent = 'Please provide a rating and a review.';
                return;
            }

            let formData = new FormData();
            formData.append('rating', rating);
            formData.append('review', review);

            fetch('<?= ROOT ?>/books/addReview/<?= $data['bookDetails'][0]->book_id ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Review submitted successfully');
                        const reviewsSection = document.getElementById('reviews');
                        const newReview = document.createElement('div');
                        newReview.classList.add('review-item');

                        const stars = document.createElement('div');
                        stars.classList.add('stars');
                        for (let i = 0; i < 5; i++) {
                            const star = document.createElement('span');
                            star.classList.add('material-symbols-outlined');
                            star.textContent = 'grade';
                            if (i < data.rating) {
                                star.classList.add('filled');
                            }
                            stars.appendChild(star);
                        }

                        const reviewText = document.createElement('p');
                        reviewText.textContent = data.review;

                        newReview.appendChild(stars);
                        newReview.appendChild(reviewText);
                        reviewsSection.appendChild(newReview);
                    } else {
                        alert('Failed to submit review');
                    }
                })
                .catch();
        }
    });
</script>
<?php $this->view('includes/footer');
