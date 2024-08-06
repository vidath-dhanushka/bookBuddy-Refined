<?php

class Database
{
    private $con;

    private function connect()
    {
        if (!$this->con) {
            $str = DBDRIVER . ':host=' . DBHOST . ';dbname=' . DBNAME;
            $this->con = new PDO($str, DBUSER, DBPASS);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->con;
    }

    public function query($query, $data = [], $type = 'object')
    {
        $con = $this->connect();

        $stm = $con->prepare($query);
        if ($stm) {

            foreach ($data as $key => $value) {
                $newKey = str_replace('.', '', $key);

                // Remove the old key and set the value with the new key
                unset($data[$key]);
                $data[$newKey] = $value;
            }

            $check = $stm->execute($data);
            if ($check) {
                if ($type != 'object') {
                    $type = PDO::FETCH_ASSOC;
                } else {
                    $type = PDO::FETCH_OBJ;
                }
                $result = $stm->fetchAll($type);

                if (is_array($result) && count($result) > 0) {
                    return $result;
                }
                return $con->lastInsertId();
            }
        }
        return false;
    }

    public function beginTransaction()
    {
        $this->connect()->beginTransaction();
    }

    public function commit()
    {
        $this->connect()->commit();
    }

    public function rollback()
    {
        $this->connect()->rollBack();
    }

    public function create_tables()
    {
        $query = "CREATE TABLE IF NOT EXISTS courier(
            courier_id    SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            company_name  VARCHAR(32) UNIQUE NOT NULL,
            reg_no        VARCHAR(16) UNIQUE NOT NULL,
            email         VARCHAR(96) UNIQUE NOT NULL,
            phone         VARCHAR(16) UNIQUE NOT NULL,
            rate_first_kg DECIMAL(9, 2)      NOT NULL,
            rate_extra_kg DECIMAL(9, 2)      NOT NULL,
            estimate_days SMALLINT           NOT NULL,
            reg_time      DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time      DATETIME ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS user
        (
            user_id          MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username         VARCHAR(32) UNIQUE NOT NULL,
            first_name       VARCHAR(32)        NOT NULL,
            last_name        VARCHAR(32)        NOT NULL,
            email            VARCHAR(96) UNIQUE NOT NULL,
            phone            VARCHAR(16)        NOT NULL,
            user_image       VARCHAR(64),
            address_line1    VARCHAR(128),
            address_line2    VARCHAR(128),
            address_city     VARCHAR(32),
            address_district VARCHAR(32),
            address_zip      CHAR(5),
            password         CHAR(128)          NOT NULL,
            status           VARCHAR(16)        NOT NULL,
            role             VARCHAR(16)        NOT NULL DEFAULT 'MEMBER',
            courier          SMALLINT UNSIGNED REFERENCES courier (courier_id),
            balance          DECIMAL(9, 2)      NOT NULL DEFAULT 0,
            holding_balance  DECIMAL(9, 2)      NOT NULL DEFAULT 0,
            reg_time         DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time         DATETIME ON UPDATE CURRENT_TIMESTAMP
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS transaction
        (
            transaction_id MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user           MEDIUMINT UNSIGNED NOT NULL REFERENCES user (user_id),
            description    VARCHAR(64)        NOT NULL,
            payment_method VARCHAR(64)        NOT NULL,
            status         VARCHAR(32)        NOT NULL,
            amount         DECIMAL(9, 2)      NOT NULL,
            reg_time       DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time       DATETIME ON UPDATE CURRENT_TIMESTAMP
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS category
        (
            category_id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name        VARCHAR(32) UNIQUE NOT NULL,
            reg_time    DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time    DATETIME ON UPDATE CURRENT_TIMESTAMP
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS book
        (
            book_id     MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title       VARCHAR(64)        NOT NULL,
            description LONGTEXT           NOT NULL,
            language    VARCHAR(16)        NOT NULL,
            isbn        CHAR(13),
            price       DECIMAL(9, 2)      NOT NULL,
            status      VARCHAR(16)        NOT NULL,
            weight      DECIMAL(9, 2)      NOT NULL,#(grams)
            `condition` VARCHAR(16)        NOT NULL,
            duration    SMALLINT           NOT NULL,
            owner       MEDIUMINT UNSIGNED NOT NULL REFERENCES user (user_id),
            author      VARCHAR(32)        NOT NULL,
            book_image  VARCHAR(64),
            reg_time    DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time    DATETIME ON UPDATE CURRENT_TIMESTAMP
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS book_category
        (
            book_category_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            book             MEDIUMINT UNSIGNED NOT NULL REFERENCES book (book_id),
            category         SMALLINT UNSIGNED  NOT NULL REFERENCES category (category_id),
            reg_time         DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time         DATETIME ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE (book, category)
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS book_rating
        (
            book_rating_id MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            book      MEDIUMINT UNSIGNED NOT NULL REFERENCES book (book_id),
            user      MEDIUMINT UNSIGNED NOT NULL REFERENCES user (user_id),
            rating    TINYINT            NOT NULL,
            review    LONGTEXT,
            reg_time  DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time  DATETIME ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE (book, user)
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS delivery
        (
            delivery_id               MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            book_borrow               MEDIUMINT UNSIGNED NOT NULL REFERENCES book_borrow (book_borrow_id),
            sender_name               VARCHAR(32)   NOT NULL,
            sender_address_line1      VARCHAR(128),
            sender_address_line2      VARCHAR(128),
            sender_address_city       VARCHAR(32),
            sender_address_district   VARCHAR(32),
            sender_address_zip        CHAR(5),
            sender_phone              VARCHAR(16)   NOT NULL,
            receiver_name             VARCHAR(32)   NOT NULL,
            receiver_address_line1    VARCHAR(128),
            receiver_address_line2    VARCHAR(128),
            receiver_address_city     VARCHAR(32),
            receiver_address_district VARCHAR(32),
            receiver_address_zip      CHAR(5),
            receiver_phone            VARCHAR(16)   NOT NULL,
            reg_time                  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time                  DATETIME ON UPDATE CURRENT_TIMESTAMP
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `order`
        (
            order_id       MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            lender            MEDIUMINT UNSIGNED NOT NULL REFERENCES user (user_id),
            weight                    DECIMAL(9, 2) NOT NULL,
            charge                    DECIMAL(9, 2),
            courier                   SMALLINT UNSIGNED REFERENCES courier (courier_id),
            reg_time        DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time        DATETIME ON UPDATE CURRENT_TIMESTAMP
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS book_borrow
        (
            book_borrow_id MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            book           MEDIUMINT UNSIGNED NOT NULL REFERENCES book (book_id),
            `order`         MEDIUMINT UNSIGNED NOT NULL REFERENCES `order` (order_id),
            user           MEDIUMINT UNSIGNED NOT NULL REFERENCES user (user_id),
            status         VARCHAR(32)        NOT NULL DEFAULT 'PENDING',
            reg_time       DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time       DATETIME ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE (book, user, `order`)
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS user_rating
        (
            user_rating_id MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            borrower       MEDIUMINT UNSIGNED NOT NULL REFERENCES user (user_id),
            lender         MEDIUMINT UNSIGNED NOT NULL REFERENCES user (user_id),
            book           MEDIUMINT UNSIGNED NOT NULL REFERENCES book (book_id),
            rating         TINYINT            NOT NULL,
            reg_time       DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time       DATETIME ON UPDATE CURRENT_TIMESTAMP
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS cart
        (
            cart_id  MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            book     MEDIUMINT UNSIGNED NOT NULL REFERENCES book (book_id),
            user     MEDIUMINT UNSIGNED NOT NULL REFERENCES user (user_id),
            reg_time DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time DATETIME ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE (book, user)
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS topup
        (
            topup_id    MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user        MEDIUMINT UNSIGNED NOT NULL REFERENCES user (user_id),
            amount      DECIMAL(9, 2)      NOT NULL,
            order_id    VARCHAR(32) UNIQUE NOT NULL,
            hash        CHAR(32) UNIQUE    NOT NULL,
            verify_time DATETIME,
            reg_time    DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
            mod_time    DATETIME ON UPDATE CURRENT_TIMESTAMP
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS ebook
        (
            `ebook_id` INT AUTO_INCREMENT,
            `title` VARCHAR(255) NOT NULL,
            `subtitle` VARCHAR(255),
            `author` VARCHAR(255) NOT NULL, 
            `isbn` VARCHAR(17) UNIQUE,
            `language` VARCHAR(50),
            `edition` INT,
            `publisher` VARCHAR(255) NOT NULL,
            `publish_date` DATE NOT NULL,
            `pages` INT NOT NULL,
            `description` TEXT NOT NULL,
            `book_cover`  VARCHAR(1024) NOT NULL,
            `file`  VARCHAR(1024) NOT NULL,
            `license_type` VARCHAR(50) NOT NULL,
            `borrowing_time` INT NOT NULL,
            `librarian_id` MEDIUMINT UNSIGNED, 
            `copyright_status` INT NOT NULL DEFAULT 0,
            `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `mod_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (ebook_id),
            FOREIGN KEY (librarian_id) REFERENCES user(user_id) ON DELETE SET NULL
        );";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `ebook_category` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `ebook_id` INT NOT NULL, 
            `category_id` SMALLINT UNSIGNED NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (ebook_id) REFERENCES ebook(ebook_id) ON DELETE CASCADE,
            FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE CASCADE
            );
        ";

        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `ebook_review` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `ebook_id` INT DEFAULT NULL,
            `user_id` MEDIUMINT UNSIGNED NULL,
            `rating` int(11) DEFAULT NULL,
            `description` text DEFAULT NULL,
            `date` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`),
            FOREIGN KEY (`ebook_id`) REFERENCES `ebook`(`ebook_id`) ON DELETE CASCADE,
            FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE
        );";

        $this->query($query);
    }
}
