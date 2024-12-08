<?php $this->view('elibrary/includes/header'); ?>
<?php if (isset($_SESSION['review_errors'])): ?>
    <div class="error-messages">
        <ul>
            <?php foreach ($_SESSION['review_errors'] as $error): ?>
                <div class="alert"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['review_errors']);
    ?>
<?php endif; ?>

<?php if (message()): ?>
    <div class="<?= isset($_SESSION['message_class']) ? $_SESSION['message_class'] : 'alert'; ?>">
        <?= message('', true) ?>
    </div>
    <?php unset($_SESSION['message_class']); ?>
<?php endif; ?>

<bookDetails>

    <div class="app-content">
        <div class="main-container">
            <div class="container-left">
                <img id="thumb" src="<?= $data['ebook']->book_cover ? ROOT . '/' . $data['ebook']->book_cover : ROOT . '/uploads/books/default.jpg'; ?>">
            </div>
            <div class="container-right">
                <div class="sub-tags">
                    <!-- <span><?= $subscription->name ?></span> -->
                    <span>FREE</span>
                    <?php if (isset($favourite) && $favourite) : ?>
                        <a href="<?= ROOT ?>/elibrary/favourite/<?= $ebook->ebook_id ?>/remove" class="favorite-btn favourite-filled">
                            <i class="fas fa-heart"></i>
                        </a>
                    <?php else : ?>
                        <a href="<?= ROOT ?>/elibrary/favourite/<?= $ebook->ebook_id ?>/add" class="favorite-btn favourite-outlined">
                            <i class="far fa-heart"></i>
                        </a>
                    <?php endif; ?>

                </div>
                <p class="book-title"><?= $data['ebook']->title ?></p>
                <p>By <span><?= $data['ebook']->author_name ?></span></p>
                <br>
                <div class="tags" book-data="tags">
                    <?php foreach (explode(',', $data['ebook']->categories) as $category) : ?>
                        <span><?= $category ?></span>
                    <?php endforeach; ?>
                </div>
                <br>
                <p>ISBN : <span><?= $data['ebook']->isbn ?></span></p>
                <p>Language : <span><?= $data['ebook']->language ?></span></p>
                <p>Edition : <span><?= $data['ebook']->edition ?></span></p>
                <p>Publisher : <span><?= $data['ebook']->publisher ?></span></p>
                <p>Publish Date : <span><?= $data['ebook']->publish_date ?></span></p>
                <p>Pages : <span><?= $data['ebook']->pages ?></span></p>
                <p class="description"><?= $data['ebook']->description ?></p>
                <div>
                    <?php if ($user_subscription->price >= $book_subscription->price) : ?>
                        <?php if ($isborrowed) : ?>
                            <!-- <button onclick="location.href='<?= ROOT ?>/Elibrary/borrow_ebook/<?= $ebook->id ?>'">Read</button> -->
                            <div class="review-box"><a style="text-decoration:none;color:inherit" href="<?= ROOT ?>/Elibrary/borrow_ebook/<?= $ebook->ebook_id ?>"> Read</a></div>
                        <?php elseif (isset($_SESSION['USER_DATA']->user_id)) : ?>

                            <!-- <button onclick="location.href='<?= ROOT ?>/Elibrary/borrow_ebook/<?= $ebook->id ?>'">Borrow Now</button> -->
                            <div class="review-box"><a style="text-decoration:none;color:inherit" href="<?= ROOT ?>/Elibrary/borrow_ebook/<?= $ebook->ebook_id ?>"> Borrow Now</a></div>
                        <?php else : ?>
                            <button id="borrow-btn" class="review-box">Borrow Now</button>
                        <?php endif; ?>
                    <?php else : ?>
                        <button id="borrow-btn" class="review-box">Borrow Now</button>
                    <?php endif; ?>

                    <!-- <?php if ($data['status']) : ?>
                        <div class="borrow-btn borrow"><a style="text-decoration:none;color:inherit" href="<?= ROOT ?>/cart/borrowNow/<?= $data['ebook']->book_id ?>"> Borrow Now</a></div>

                    <?php else : ?>
                        <div class="borrow-btn na">Currently Unavailable</div>
                    <?php endif; ?> -->

                </div>
            </div>
        </div>

        <div class="main-container review">
            <div class="review-content">
                <h2>Reviews</h2>
                <div class="summary-rating">
                    <div class="rating_average">
                        <h1><?= $reviews['average_rating'] ?></h1>
                        <div class="star-outer">
                            <div class="star-inner">
                                <?php
                                $rating = $reviews['average_rating'];
                                $intRating = floor($rating);
                                $decimal = $rating - $intRating;

                                // Print full stars
                                for ($i = 0; $i < $intRating; $i++) {
                                    echo '<i class="bx bxs-star gold-star"></i>';
                                }

                                // Print half star if decimal part is >= 0.5
                                if ($decimal >= 0.5) {
                                    echo '<i class="bx bxs-star-half gold-star"></i>';
                                    $intRating++;
                                }

                                // Print empty stars
                                for ($i = $intRating; $i < 5; $i++) {
                                    echo '<i class="bx bx-star gold-star"></i>';
                                }
                                ?>
                            </div>
                        </div>




                        <p><?= $reviews['count'] ?></p>
                    </div>
                    <div class="rating-progress">
                        <?php
                        $rating_counts = $reviews['rating_count'];


                        for ($i = 5; $i >= 1; $i--) {
                            $count = 0;
                            foreach ($rating_counts as $rating_count) {
                                if ($rating_count->rating == $i) {
                                    $count = $rating_count->count;
                                    break;
                                }
                            }
                        ?>
                            <div class="rating_progress-value">
                                <p><?php echo $i; ?> <span class="star">★</span></p>
                                <div class="progress">
                                    <div class="bar" style="width: <?php echo $count; ?>%;"></div>
                                </div>
                                <p><?php echo $count; ?></p>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="add-review">

                        <?php

                        if (!empty($reviews['user_review'])) : ?>
                            <?php $user_review = $reviews['user_review'];  ?>
                            <div class="box">
                                <div class="box-header">

                                    <div>
                                        <a href="<?= ROOT ?>/elibrary/review/<?= $ebook->ebook_id ?>/delete" style="margin-left:5px">
                                            <i class="fa-solid fa-trash" style="color:red;"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-top">
                                    <div class="profile">
                                        <div class="name-user">
                                            <strong>@<?= $username ?></strong>
                                            <span><?= $user_review->date ?></span>
                                        </div>
                                    </div>
                                    <div class="reviews">
                                        <?php for ($i = 0; $i < $user_review->rating; $i++) : ?>
                                            <i class="fas fa-star"></i>
                                        <?php endfor; ?>
                                        <?php for ($i = $user_review->rating; $i < 5; $i++) : ?>
                                            <i class="far fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="client-comment">
                                    <p>
                                        <?= $user_review->description ?>
                                    </p>
                                </div>
                            </div>
                        <?php else : ?>
                            <p>Write Review Here:</p>

                            <?php if ($isEverborrowed) : ?>
                                <div id="myBtn" class="review-box">Review</div>
                            <?php else : ?>
                                <a href="<?= ROOT ?>/elibrary/my_message/<?= $ebook->ebook_id ?>" class="review-box">Review</a>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>


                </div>
                <div class="box-details-container">
                    <?php if (!empty($reviews['all'])) : ?>
                        <?php foreach ($reviews['all'] as $review) : ?>
                            <div class="box">
                                <div class="box-top">
                                    <div class="profile">
                                        <div class="name-user">
                                            <strong>@<?= $review->username ?></strong>
                                            <span><?= $review->date ?></span>
                                        </div>
                                    </div>
                                    <div class="reviews">
                                        <?php for ($i = 0; $i < $review->rating; $i++) : ?>
                                            <i class="fas fa-star"></i>
                                        <?php endfor; ?>
                                        <?php for ($i = $review->rating; $i < 5; $i++) : ?>
                                            <i class="far fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="client-comment">
                                    <p>
                                        <?= $review->description ?>
                                    </p>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    <?php else : ?>
                        <p style="margin:50px;">No reviews found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</bookDetails>
<?php $this->view('elibrary/add_review', $data) ?>
<?php $this->view('elibrary/review', $data) ?>
<?php $this->view('member/upgrade_plan_alert', $data) ?>
<script>
    // Get the modal
    var modal = document.getElementById("myModal");
    var modal2 = document.getElementById("myModal-2");
    var modal3 = document.getElementById("myModal-3");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    var moreBtn = document.getElementById("more-btn");
    var borrowBtn = document.getElementById("borrow-btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    var span2 = document.getElementsByClassName("close")[1];
    var span3 = document.getElementsByClassName("close")[2];
    // When the user clicks the button, open the modal 
    if (btn) {
        btn.onclick = function() {
            modal.style.visibility = "visible";
        }
    }

    if (moreBtn) {
        moreBtn.onclick = function() {
            modal2.style.visibility = "visible";
        }
    }
    if (borrowBtn) {
        borrowBtn.onclick = function() {
            console.log("yes")
            modal3.style.visibility = "visible";
        }
    }
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.visibility = "hidden";
        modal.classList.remove('animate');
    }
    span2.onclick = function() {
        modal2.style.visibility = "hidden";
        modal2.classList.remove('animate');
    }
    span3.onclick = function() {
        modal3.style.visibility = "hidden";
        modal3.classList.remove('animate');
    }
    if (document.getElementById('myBtn')) {
        document.getElementById('myBtn').addEventListener('click', function() {
            document.getElementById('myModal').classList.add('animate');
        });
    }

    if (document.getElementById('more-btn')) {
        document.getElementById('more-btn').addEventListener('click', function() {
            document.getElementById('myModal-2').classList.add('animate');
        });
    }
    if (document.getElementById('borrow-btn')) {
        document.getElementById('borrow-btn').addEventListener('click', function() {
            console.log("borrow");
            document.getElementById('myModal-3').classList.add('animate');
        });
    }
</script>
<?php $this->view('includes/footer');
