<?php

require_once "src/Book.php";
require_once "src/Author.php";

class BookList {

    private $author_id;
    private $book_id;
    private $due_date;
    private $checkout_patron_id;
    private $id;

    function __construct($author_id, $book_id, $due_date = null, $checkout_patron_id = null, $id = null) {
        $this->author_id = $author_id;
        $this->book_id = $book_id;
        $this->due_date = $due_date;
        $this->checkout_patron_id = $checkout_patron_id;
        $this->id = $id;
    }

    function setDueDate($new_due_date){
        $this->due_date = (string) $new_due_date;
    }

    function setCheckoutPatronId($new_checkout_patron_id) {
        $this->checkout_patron_id = (int) $new_checkout_patron_id;
    }

    function getAuthorId(){
        return $this->author_id;
    }

    function getBookId(){
        return $this->book_id;
    }

    function getDueDate(){
        return $this->due_date;
    }

    function getCheckoutPatronId(){
        return $this->checkout_patron_id;
    }

    function getId(){
        return $this->id;
    }

    function save(){
        $statement = $GLOBALS['DB']->exec("INSERT INTO book_list (author_id, book_id, due_date,
                    checkout_patron_id) VALUES ({$this->getAuthorId()}, {$this->getBookId()},
                    '{$this->getDueDate()}', {$this->getCheckoutPatronId()});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll(){
        $returned_book_list = $GLOBALS['DB']->query("SELECT * FROM book_list;");
        $book_list = array();
        foreach ($returned_book_list as $book) {
            $author_id = $book['author_id'];
            $book_id = $book['book_id'];
            $due_date = $book['due_date'];
            $checkout_patron_id = $book['checkout_patron_id'];
            $id = $book['id'];
            $new_book = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            array_push($book_list, $new_book);
        }
        return $book_list;
    }

    static function find($column_id, $search_id) {
        //$column_id is what the user is search for ie due_date, book_id, etc
        $search_book_list = $GLOBALS['DB']->query("SELECT * FROM book_list WHERE {$column_id} = {$search_id}");
        $found_book = $search_book_list->fetchAll(PDO::FETCH_ASSOC);
        $author_id = $found_book[0]['author_id'];
        $book_id = $found_book[0]['book_id'];
        $due_date = $found_book[0]['due_date'];
        $checkout_patron_id = $found_book[0]['checkout_patron_id'];
        $id = $found_book[0]['id'];
        $new_book = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
        return $new_book;
    }

    static function deleteAll(){
        $GLOBALS['DB']->exec("DELETE FROM book_list;");
    }
}



?>
