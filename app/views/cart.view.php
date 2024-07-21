<?php $this->view('includes/header'); ?>
<?php $jsonData = json_encode($data); ?>
<cart>
    <div class="app-content">
        <h1>Your Choice</h1>
        <div class="main-container">
            <?php if (!empty($data['bookDetails'])) : ?>
                <div class="container cart-items" style="height:fit-content">
                    <?php if ($data['type'] == 'BorrowNow') : ?>
                        <div class="cart-item" style="display: flex;">
                            <div class="book-image">
                                <img src="<?= $data['bookDetails'][0]->book_image ? ROOT . '/' . $data['bookDetails'][0]->book_image : ROOT . '/uploads/books/default.jpg'; ?>">
                            </div>
                            <div class="book-info" style="margin-left: 150px;">
                                <div class="row1">
                                    <h1><?= $data['bookDetails'][0]->title ?></h1>
                                    <span style="padding-left: 80px;">By <?= $data['bookDetails'][0]->author ?></span>
                                    <p style="margin-top: 40px;">Refundable deposit:<br>Rs. <?= $data['bookDetails'][0]->price ?></p>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php foreach ($data['bookDetails'] as $book) : ?>
                            <div class="cart-item">
                                <div class="book-image">
                                    <img src="<?= $book->book_image ? ROOT . '/' . $book->book_image : ROOT . '/uploads/books/default.jpg'; ?>">
                                </div>
                                <div class="book-info">
                                    <div class="row1">
                                        <h2><?= $book->title ?></h2>
                                        <span>By <?= $book->author ?></span>
                                        <p></p>
                                        <p>Refundable deposit:<br>Rs. <?= $book->price ?></p>
                                    </div>
                                    <div>
                                        <div class="remove rem" onclick="removeCartItem(<?= $book->book_id ?>)">Remove</div>
                                        <div class="remove" style="display:<?= $book->status == 'available' ? 'none' : '' ?>">Unavailable</div>
                                    </div>
                                </div>
                                <div class="selection">
                                    <input class="checkout-select" type="checkbox" data-cartId="<?= $book->cart_id ?>" data-bookId="<?= $book->book_id ?>" data-owner="<?= $book->owner ?>" data-deposit="<?= $book->price ?>" data-weight="<?= $book->weight ?>" <?= $book->status != 'available' ? 'disabled' : 'checked' ?>>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <h2>No Items to show. Please add some books.</h2>
            <?php endif; ?>
            <div class="container">
                <h2 class="checkout-heading">Checkout</h2>
                <label>Delivery Option</label>
                <select class="courier-list">
                    <?php foreach ($data['Courier'] as $courier) : ?>
                        <option value="<?= $courier->courier_id ?>"><?= $courier->company_name ?></option>
                    <?php endforeach; ?>
                </select>
                <p>Total Delivery Fee:</p>
                <h1 class="count">Rs. <span class="delivery-fee"></span></h1>
                <p>Total refundable deposit:</p>
                <h1 class="count">Rs. <span class="deposit"></span></h1>
                <p>Total:</p>
                <h1 class="count">Rs. <span class="total"></span></h1>
                <p>Available Balance:</p>
                <h1 class="count">Rs. <span userinfo="balance"><?= $data['userData']->balance ?></span></h1>
                <p>Delivery Address:</p>
                <p userinfo="address_text" id="address_text"></p>
                <p class="form-error no-address">Your delivery address is incomplete. Please update via <a href="<?= ROOT ?>/member/profile">profile</a></p>
                <br>
                <div class="checkout-btn">
                    <button type="button" class="cart-btn2" id="cart-btn2">Borrow Now</button>
                    <button type="button" class="cart-btn2" id="topup">Topup</button>
                </div>
            </div>
        </div>
    </div>
</cart>

<script>
    let data = <?= $jsonData ?>;
    let noAddress = document.querySelector('.no-address');
    let borrowBtn = document.querySelector('#cart-btn2');
    let selectBooks = document.querySelectorAll('.checkout-select');
    let weight = 0;
    let bookPrice = 0.00;
    let courierPrice = 0.00;

    let deliveryFee = document.querySelector('.delivery-fee');
    let deposit = document.querySelector('.deposit');
    let total = document.querySelector('.total');
    let addressText = document.querySelector('#address_text');
    let courierList = document.querySelector('.courier-list');

    function setCourierPrice() {
        if (weight === 0) {
            courierPrice = 0;
        } else {
            courierPrice = parseFloat(data.Courier[parseInt(courierList.value - 1)].rate_first_kg) + parseFloat((Math.ceil(weight / 1000) - 1) * data.Courier[parseInt(courierList.value - 1)].rate_extra_kg)
        }
        deposit.innerHTML = bookPrice;
        deliveryFee.innerHTML = courierPrice;
        total.innerHTML = parseFloat(bookPrice) + parseFloat(courierPrice);
    }

    if (data.userData.address_line1 === '' && data.userData.city === '' && data.userData.address_zip === '') {
        addressText.innerHTML = '';
        borrowBtn.style.display = 'none';
    } else {
        addressText.innerHTML = `${data.userData.address_line1} , ${data.userData.address_line2}  ${data.userData.address_city}`;
        noAddress.style.display = 'none';
    }
    if (data.type === "BorrowNow") {
        bookPrice = data.bookDetails[0]['price'];
        weight = data.bookDetails[0]['weight'];
        setCourierPrice();
    } else {
        data.bookDetails.forEach(book => {
            weight += parseFloat(book.weight);
            bookPrice += parseFloat(book.price);
        })
        setCourierPrice();
    }

    courierList.addEventListener('change', function() {
        if (weight < 1000) {
            courierPrice = data.Courier[parseInt(courierList.value - 1)].rate_first_kg;
        } else {
            courierPrice = data.Courier[parseInt(courierList.value - 1)].rate_first_kg + (Math.ceil(weight / 1000) - 1) * data.Courier[parseInt(courierList.value - 1)].rate_extra_kg
        }
        deliveryFee.innerHTML = courierPrice;
        total.innerHTML = parseFloat(bookPrice) + parseFloat(courierPrice);


    })

    borrowBtn.addEventListener('click', () => {
        if (parseFloat(data.userData.balance) < total.innerHTML) {
            alert("Not enough balance. please topup your account to buy")
        } else {
            let selectedBooks = [];
            if (data.type === 'viewCart') {
                selectBooks.forEach(selectBook => {
                    if (selectBook.checked) {
                        selectedBooks.push({
                            bookId: selectBook.dataset.bookid,
                            cartId: selectBook.dataset.cartid,
                            owner: selectBook.dataset.owner,
                            deposit: selectBook.dataset.deposit,
                            weight: selectBook.dataset.weight
                        });
                    }
                });
            } else {
                selectedBooks.push({
                    bookId: data.bookDetails[0]['book_id'],
                    deposit: data.bookDetails[0]['price'],
                    weight: data.bookDetails[0]['weight'],
                    owner: data.bookDetails[0]['owner']
                })
            }

            let borrowData = {
                user_id: data.userData.user_id,
                balance: data.userData.balance,
                books: selectedBooks,
                weight: weight,
                courierPrice: courierPrice,
                address: {
                    line1: data.userData.address_line1,
                    line2: data.userData.address_line2,
                    city: data.userData.address_city,
                    zip: data.userData.address_zip
                },
                total: total.innerHTML,
                courier: data.Courier[parseInt(courierList.value - 1)].courier_id,
                type: data.type
            };

            fetch(`<?= ROOT ?>/cart/checkout`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(borrowData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Books borrowed successfully');
                        window.location.reload();
                    } else {
                        alert('Failed to borrow books');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });

    selectBooks.forEach(selectBook => {
        selectBook.addEventListener('change', (e) => {
            if (e.target.checked === false) {
                bookPrice -= parseFloat(e.target.dataset.deposit)
                weight -= parseFloat(e.target.dataset.weight);
            } else {
                bookPrice += parseFloat(e.target.dataset.deposit)
                weight += parseFloat(e.target.dataset.weight);
            }
            setCourierPrice();
        })
    })
</script>
<?php $this->view('includes/footer'); ?>