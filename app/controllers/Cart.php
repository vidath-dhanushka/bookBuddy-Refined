<?php

class Cart extends Controller
{

    public function borrowNow($bookId)
    {
        if (Auth::logged_in()) {
            $data = [];
            // show($_SESSION);
            // die;
            $book = new Book();
            $courier = new Courier();
            $data['bookDetails'] = $book->getBookDetails($bookId);
            $data['userData'] = $_SESSION['USER_DATA'];
            $data['Courier'] = $courier->getAllCourier();
            $data['type'] = "BorrowNow";
            // show($data);
            // die;

            $this->view('cart', $data);
        } else {
            $this->view('_404');
        }
    }

    public function viewCart()
    {
        if (Auth::logged_in()) {
            $data = [];
            $userId = Auth::getuser_Id();
            $cart = new Carts();
            $courier = new Courier();
            $data['bookDetails'] = $cart->getItems($userId);
            // show($data['bookDetails']);
            // die;
            $data['userData'] = $_SESSION['USER_DATA'];
            $data['Courier'] = $courier->getAllCourier();
            $data['type'] = "viewCart";
            $this->view('cart', $data);
        } else {
            $this->view('_404');
        }
    }

    public function checkout()
    {
        if (Auth::logged_in()) {
            $data = json_decode(file_get_contents('php://input'), true);

            $userId = (int)$data['user_id'];
            $balance = (float)$data['balance'];
            $books = $data['books'];
            $weight = $data['weight'];
            $courierPrice = $data['courierPrice'];
            $address = $data['address'];
            $total = $data['total'];
            $courierId = $data['courier'];
            $type = $data['type'];

            $order = new Order();
            $bookBorrow = new BookBorrow();
            $user = new User();
            $delivery = new Delivery();
            $db = new Database();
            $cart = new Carts();


            try {
                $db->beginTransaction();
                $orderDetails = [
                    'user' => (int)$userId,
                    'amount' => (float)$total,
                    'weight' => (float)$weight,
                    'charge' => (float)$courierPrice,
                    'courier' => (int)$courierId
                ];

                $orderId = $order->insert($orderDetails);

                foreach ($books as $book) {
                    $bookBorrowData = [
                        'book' => (int)$book['bookId'],
                        'user' => (int)$userId,
                        'orderNo' => (int)$orderId,
                        'status' => "PENDING"
                    ];
                    $bookBorrowId = $bookBorrow->insert($bookBorrowData);

                    $ownerDetails = $user->first(['user_id' => $book['owner']]);
                    $lenderDetails = $user->first(['user_id' => $userId]);

                    $deliveryData = [
                        'book_borrow' => (int)$bookBorrowId,
                        'sender_name' => $ownerDetails->first_name,
                        'sender_address_line1' => $ownerDetails->address_line1,
                        'sender_address_line2' => $ownerDetails->address_line2,
                        'sender_address_city' => $ownerDetails->address_city,
                        'sender_address_district' => $ownerDetails->address_district,
                        'sender_address_zip' => $ownerDetails->address_zip,
                        'sender_phone' => $ownerDetails->phone,
                        'receiver_name' => $lenderDetails->first_name,
                        'receiver_address_line1' => $lenderDetails->address_line1,
                        'receiver_address_line2' => $lenderDetails->address_line2,
                        'receiver_address_city' => $lenderDetails->address_city,
                        'receiver_address_district' => $lenderDetails->address_district,
                        'receiver_address_zip' => $lenderDetails->address_zip,
                        'receiver_phone' => $lenderDetails->phone
                    ];

                    $delivery->insert($deliveryData);
                    if ($type === 'viewCart') {
                        $cartId = (int)$book['cartId'];
                        $cart->removeItem($cartId);
                    }
                    $balance -= $total;
                    $user->update($userId, ['balance' => $balance]);
                    $_SESSION['USER_DATA'] = $user->first(['user_id' => $userId]);
                }

                $db->commit();

                $response = ['success' => true];
            } catch (Exception $e) {
                $db->rollback();
                $error =  $e->getMessage();
                $response = ['success' => false, 'error' => $error];
            }

            echo json_encode($response);
        } else {
            $this->view('_404');
        }
    }
}
