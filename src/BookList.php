<?php


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

    //Searching book_list database with column_id as a variable
    static function find($column_id, $search_id) {
        //$column_id is what the user is search for ie due_date, book_id, etc
        //if $search_id is a date, it will be a string, else it will be an int
        if (is_string($search_id)) {
            $search_book_list = $GLOBALS['DB']->query("SELECT * FROM book_list WHERE {$column_id} = '{$search_id}'");
        }
        else {
            $search_book_list = $GLOBALS['DB']->query("SELECT * FROM book_list WHERE {$column_id} = {$search_id}");
        }
        $found_books = array();
        $found_book = $search_book_list->fetchAll(PDO::FETCH_ASSOC);
        foreach ($found_book as $book){
            $author_id = $book['author_id'];
            $book_id = $book['book_id'];
            $due_date = $book['due_date'];
            $checkout_patron_id = $book['checkout_patron_id'];
            $id = $book['id'];
            $new_book = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            array_push($found_books, $new_book);
        }
        //returned output is in an array incase there is more than one book found. I.E. due date being searched and finds more than one book with that due date
        return $found_books;
    }

    //Searching book_list database for specific book with author and book id inputs
    static function findBookList($id1, $id2) {
        $search_book_list = $GLOBALS['DB']->query("SELECT * FROM book_list WHERE author_id = {$id1} AND book_id = {$id2}");
        $found_books = array();
        $found_book = $search_book_list->fetchAll(PDO::FETCH_ASSOC);
        foreach ($found_book as $book){
            $author_id = $book['author_id'];
            $book_id = $book['book_id'];
            $due_date = $book['due_date'];
            $checkout_patron_id = $book['checkout_patron_id'];
            $id = $book['id'];
            $new_book = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            array_push($found_books, $new_book);
        }
        return $found_books;
    }

    static function deleteAll(){
        $GLOBALS['DB']->exec("DELETE FROM book_list;");
    }

    static function overDueBooks () {

    }
}



?>
