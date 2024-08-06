<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <div class="add_review">
            <section class="review-form">
                <form action=<?php echo ROOT . "/elibrary/review/" . $ebook->ebook_id . '/add' ?> method="post">
                    <h3>Post your review </h3>
                    <p>Rate this book</p>
                    <div name="rating" class="rating" required>
                        <input type="number" name="rating" hidden>
                        <i class='bx bx-star star' style="--i: 0;"></i>
                        <i class='bx bx-star star' style="--i: 1;"></i>
                        <i class='bx bx-star star' style="--i: 2;"></i>
                        <i class='bx bx-star star' style="--i: 3;"></i>
                        <i class='bx bx-star star' style="--i: 4;"></i>
                    </div>
                    <p>Write a review</p>
                    <textarea class="review" name="description" id="review-box" placeholder="enter review description (optional)" cols="30" rows="8" maxlength="1000"></textarea>

                    <div class="btn-group">
                        <button type="submit" class="btn submit">Submit</button>
                        <button type="reset" class="btn cancel">Cancel</button>
                    </div>
                </form>

            </section>
        </div>
    </div>
</div>
<script src="<?= ROOT ?>/assets/js/elibrary/rating.js"></script>