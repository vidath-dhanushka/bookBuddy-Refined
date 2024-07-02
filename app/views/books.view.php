<?php $this->view('includes/header') ?>
<books>
    <div class="app-content">
        <section class="top-rated-books">
            <div class="search-container">
                <input id="search" placeholder="Search books..." type="search" onkeyup="searchChanged(this)" onchange="searchChanged(this)">
                <span class="material-symbols-outlined">search</span>
            </div>
            <div class="cats">
            </div>
            <div class="top-rated-book-box book-list">
                <div class="top-rated-book-card">
                    <div class="top-rated-book-img">
                        <img src="/api/uploads/${u.image || 'default.jpg'}">
                    </div>
                    <div class="top-rated-book-tag">
                        <h2>${u.title}</h2>
                        <p class="writer">${u.author || ""}</p>
                        <div class="categories">${u.categories || ""}</div>
                        <p class="book-price">Rs ${u.price}</p>
                        <br>
                        <a href="<?= ROOT ?>/books/details/14" class="f-btn">Learn More</a>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="top-rated-book-card">
                    <div class="top-rated-book-img">
                        <img src="/api/uploads/${u.image || 'default.jpg'}">
                    </div>
                    <div class="top-rated-book-tag">
                        <h2>${u.title}</h2>
                        <p class="writer">${u.author || ""}</p>
                        <div class="categories">${u.categories || ""}</div>
                        <p class="book-price">Rs ${u.price}</p>
                        <br>
                        <a href="/book/${u.book_id}" class="f-btn">Learn More</a>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </section>
    </div>
</books>