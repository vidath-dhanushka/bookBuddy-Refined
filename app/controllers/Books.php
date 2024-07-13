<?php

class Books extends Controller
{

    public function index()
    {
        $data = [];
        $books = new Book();
        $data['bookList'] = $books->getAllBooks();
        $data['categories'] = $books->getCategories();
        $this->view('books', $data);
    }

    public function details($id)
    {
        $data = [];
        $userId = Auth::getuser_Id();
        $book = new Book();
        $review = new BookRating();
        $bookBorrow = new BookBorrow();
        $data['bookDetails'] = $book->getBookDetails($id);
        $data['borrowedBook'] = $bookBorrow->getBorrowedBook($id, $userId);
        $data['reviews'] = $review->getReviews($id);

        $this->view('bookDetails', $data);
    }

    public function addReview($id)
    {
        $data = [];
        $data['book'] = $id;
        $data['user'] = Auth::getuser_Id();
        $review = new BookRating();
        $previousReview = $review->isReviewed($data['user'], $data['book']);
        // show($previousReview);
        // die;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['rating'] = $_POST['rating'];
            $data['review'] = $_POST['review'];

            if (!empty($previousReview)) {
                try {
                    $review->update($previousReview[0]->book_rating_id, $data);
                    echo json_encode(['success' => true]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false]);
                }
            }
        } else {
            if ($review->insert($data)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }


    public function category($id)
    {
        $data = [];
        $books = new Book();
        $data['bookList'] = $books->getCategoryBooks($id);
        $data['categories'] = $books->getCategories();
        $this->view('books', $data);
    }
}
