<?php

class Member extends Controller
{

    public function index()
    {
        $user = new User();
        $data = [];
        $id = Auth::getuser_Id();
        // echo ($id);

        $data['user_data'] = $user->first(['user_id' => $id]);
        // show($data);
        // // show($_SESSION['USER_DATA']);
        // die;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // show($data);

            // show($_POST);
            // die;
            if ($user->edit_validate($_POST, $id)) {
                $user->update($id, $_POST);
                $data['user_data'] = $user->first(['user_id' => $id]);
                // show($row);
            }
            // die;
        }
        $data['errors'] = $user->errors;
        // show($data);
        // die;
        $this->view('member/profile', $data);
    }

    public function lended()
    {
        $data = [];
        $id = Auth::getuser_Id();
        $book = new Book();
        // $category = new Category();
        $lendedBooks = $book->lendedBooks($id);
        $user_ratings = $book->getUserRatings($id);

        $ratingsByBook = [];
        foreach ($user_ratings as $rating) {
            $ratingsByBook[$rating->book][] = $rating;
        }

        foreach ($lendedBooks as $book) {
            $book->user_ratings = $ratingsByBook[$book->book_id] ?? [];
        }

        // show($lendedBooks);
        // die;
        // $allCategories = $category->getAll();
        // $selectedCategories =
        // $category = new Category();
        // show($lendedBooks);
        // die;
        // $this->getCategoryMap();
        $data['lended_books'] = $lendedBooks;

        $this->view('member/lended', $data);
    }

    public function borrowed()
    {
        $data = [];
        $borrowed = new BookBorrow();
        $userId = Auth::getuser_id();
        $data['borrowedBooks'] = $borrowed->getAllBorrowedBooks($userId);
        // show($borrowedBooks);
        // die;
        $this->view('member/borrowed', $data);
    }

    public function lendedUsers()
    {

        $this->view('member/lendedUsers');
    }

    public function changePassword()
    {
        $this->view('member/changePassword');
    }

    public function addBook()
    {
        $id = Auth::getuser_Id();
        $book = new Book();
        $category = new Category();
        $categoryMap = $this->getCategoryMap();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $folder = "uploads/books/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
                file_put_contents($folder . "index.php", "<?php //silence");
                file_put_contents("uploads/index.php", "<?php //silence");
            }

            if ($book->validate($_POST)) {

                $_POST['owner'] = $id;
                $_POST['status'] = 'available';
                $_POST['duration'] = 14;
                $allowedTypes = ['image/jpeg', 'image/png'];

                if ($_FILES['book_image']['name']) {
                    if ($_FILES['book_image']['error'] == 0) {
                        if (in_array($_FILES['book_image']['type'], $allowedTypes)) {
                            $destination = $folder . time() . $_FILES['book_image']['name'];
                            move_uploaded_file($_FILES['book_image']['tmp_name'], $destination);
                            $_POST['book_image'] = $destination;
                        } else {
                            $book->errors['book_image'] = "Invalid file type";
                        }
                    } else {
                        $book->errors['book_image'] = "Could not upload the images";
                    }
                }
                $bookId = $book->insert($_POST);
                // $bookId = $book->getLastInsertedId();
                $categories = $_POST['categories'];

                foreach ($categories as $categoryName) {
                    if (isset($categoryMap[$categoryName])) {
                        $categoryId = $categoryMap[$categoryName];
                        $categoryData = [
                            'book' => $bookId,
                            'category' => $categoryId,
                        ];
                        $category->insertBookCategory($categoryData);
                    }
                }
                // show($bookId);
                // show($_POST);
                // die;
            }
            // show($_POST);

            // die;
            redirect('member/lended');
        }
        $this->view("member/addBook");
    }

    public function editBook($id)
    {
        $book = new Book;
        $data = $book->getBookDetails($id);
        // show($data);
        // die;
        $bookId = $id;
        $id = Auth::getuser_Id();
        $category = new Category();
        $categoryMap = $this->getCategoryMap();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $folder = "uploads/books/";

            if ($book->validate($_POST)) {

                $book->deleteBookCategories($bookId);
                $allowedTypes = ['image/jpeg', 'image/png'];

                if ($_FILES['book_image']['name']) {
                    if ($_FILES['book_image']['error'] == 0) {
                        if (in_array($_FILES['book_image']['type'], $allowedTypes)) {
                            $destination = $folder . time() . $_FILES['book_image']['name'];
                            move_uploaded_file($_FILES['book_image']['tmp_name'], $destination);
                            $_POST['book_image'] = $destination;
                        } else {
                            $book->errors['book_image'] = "Invalid file type";
                        }
                    } else {
                        $book->errors['book_image'] = "Could not upload the images";
                    }
                }
                $book->update($bookId, $_POST);
                // show($bookId);
                // die;
                $categories = $_POST['categories'];

                foreach ($categories as $categoryName) {
                    if (isset($categoryMap[$categoryName])) {
                        $categoryId = $categoryMap[$categoryName];
                        $categoryData = [
                            'book' => $bookId,
                            'category' => $categoryId,
                        ];
                        $category->insertBookCategory($categoryData);
                    }
                }
                // show($bookId);
                // show($_POST);
                // die;
            }
            redirect('member/lended');
        }

        // show($_POST);

        // die;


        $this->view('member/editBook', $data);
    }

    public function deleteBook($id)
    {
        $book = new Book();
        try {
            $book->deleteBookCategories($id);
            $book->delete($id);
        } catch (Exception $e) {
            message("Failed to remove the book try again" . $e);
            //     return json_encode($e);
        }
        redirect('member/lended');
    }

    private function getCategoryMap()
    {
        $category = new Category();
        $categories = $category->getAll();
        // show($categories);
        // die;
        $map = [];
        foreach ($categories as $cat) {
            $map[$cat->name] = $cat->category_id;
        }
        // show($map);
        // die;
        return $map;
    }

    public function updateRating($ratingId)
    {
        // show($ratingId);
        // die;
        $userRating = new UserRating();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            // show($data);
            // die;
            try {
                $userRating->update($ratingId, $data);
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                echo json_encode(['success' => false]);
            }
        }
    }
}
