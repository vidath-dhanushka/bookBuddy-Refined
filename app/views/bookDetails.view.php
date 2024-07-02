<?php $this->view('includes/header'); ?>
<bookDetails>
    <div class="app-content">
        <div class="main-container">
            <div class="container-left">
                <img id="thumb">
            </div>
            <div class="container-right">
                <p class="book-title" book-data="title"></p>
                <p>By <i book-data="author"></i></p>
                <br>
                <div class="tags" book-data="tags">
                </div>
                <p class="description" book-data="description"></p>
                <p class="price">Deposit: Rs. <span book-data="price"></span></p>
                <p>(Owner from <span book-data="location"></span>)</p>
                <br>
                <div>
                    <div class="borrow-btn borrow" onclick="borrow()">Borrow Now</div>
                    <div class="borrow-btn na">Currently Unavailable</div>
                    <div class="borrow-btn" onclick="borrow(true, event)">Add to Cart</div>
                </div>
            </div>
        </div>
        <div class="main-container review new-review">
            <div class="review-content">
                <h2>Your Review</h2>
                Rating:
                <div id="my-stars" class="stars"></div>
                <br>
                Review:
                <textarea rows="8" id="review"></textarea>
                <br>
                <p class="form-error"></p>
                <div class="review-btn" onclick="postReview()">Post Review</div>
            </div>
        </div>
        <div class="main-container review">
            <div class="review-content">
                <h2>Reviews</h2>
                <div id="reviews"></div>
            </div>
        </div>
    </div>
</bookDetails>
<?php $this->view('includes/footer');
