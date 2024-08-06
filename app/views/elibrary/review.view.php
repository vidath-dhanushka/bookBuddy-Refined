<div id="myModal-2" class="modal" >
  <div class="modal-content" style="max-height:90%; width:70%">
    <span class="close">×</span>
    <div class="review">
      <div class="review-header">
        <h1>User Review</h1>
      </div>
      
      <div class="box-details-container" style="grid-template-columns: 1fr 1fr;">
      <?php if(!empty($reviews['all'])) : ?>
        <?php foreach ($reviews['all'] as $review) : ?>
        <div class="box">
        <div class="box-top">
            <div class="profile">
                <div class="profile-img">
                    <img src="<?= ROOT ?>/<?= $review->user_image ?>" />
                </div>
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
    <?php else: ?>
      <p style="margin:50px;">No reviews found.</p>
      <?php endif; ?>
        
       


      </div>
      
     

    <!-- Add review box -->
</div>
            
</div>
<!-- <script src="<?=ROOT?>/assets/js/rating.js"></script> -->


