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
<script src="<?= ROOT ?>/Elibrary/ebook_url/<?= $ebook->id ?>"></script>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/elibrary/ebook-reader.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js" integrity="sha512-ml/QKfG3+Yes6TwOzQb7aCNtJF4PUyha6R3w8pSTo/VJSywl7ZreYvvtUso7fKevpsI+pYVVwnu82YO0q3V6eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<main>

    <div class="book-reader">
        <div class="pdfNavigation">
            <div class="left"></div>
            <div class="middle">
                <a href="<?= ROOT ?>/Elibrary/return_book/<?= $ebook->ebook_id ?>">
                    <div class="return-btn">Return now</div>
                </a>
                <div class="return-time">Borrow ends on <?= $due_date ?></div>
            </div>
            <div class="right"></div>
        </div>
        <div id="pdf-container" class="pdf-area">
            <canvas id="the-canvas"></canvas>
        </div>
        <div class="pdfNavigation">
            <div class="left">
                <button onclick="prevPage()" title="Go to the previous page"> <i class="fas fa-chevron-left"></i> </button>
                <div id="page_num" style="display:none"></div>
                <input type="text" id="page-number" placeholder="Enter page number" onblur="resetInput()" onkeypress="if(event.keyCode === 13) goToPageNumber()">
                <div>of </div>
                <div id="page_count"></div>
                <button onclick="nextPage()" title="Go to the next page"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="middle">
                <button onclick="zoomOut()" title="Zoom Out"><i class="fas fa-minus"></i> </button>
                <button onclick="zoomIn()" title="Zoom In"><i class="fas fa-plus"></i></button>
            </div>
            <div class="right">
                <button onclick="displayOnePage()" title="One-page view">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 18 24" width="12" height="16">
                        <path d="M21,24H3V0H21V24Z" fill="#fff" />
                    </svg>
                </button>
                <button onclick="displayTwoPages()" title="Two-page view">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 18 24" width="12" height="16">
                        <path d="M21,24H3V0H21V24Z" fill="#fff" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 18 24" width="12" height="16">
                        <path d="M21,24H3V0H21V24Z" fill="#fff" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</main>
<script src="<?= ROOT ?>/assets/js/ebook-reader.js"></script>
<?php $this->view('includes/footer') ?>