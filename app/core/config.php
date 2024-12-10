<?php

// some app configs
define('APP_NAME', 'BOOK BUDDY');
define('APP_DESC', 'Book sharing platform for everyone');


// database configs
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define('DBHOST', 'localhost:3307');
    define('DBNAME', 'bookbuddy_db');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', 'mysql');

    define('ROOT', 'http://localhost/bookBuddy/public');
} else {
    define('ROOT', '/book-buddy/public');
    define('DBHOST', 'localhost');
    define('DBNAME', 'bookbuddy_db');
    define('DBUSER', 'root');
    define('DBPASS', '1234');
    define('DBDRIVER', 'mysql');
}
