<?php


class Book {

    private $book_name;
    private $id;


    function __construct($book_name, $id = null) {
        $this->book_name = $book_name;
        $this->id = $id;
    }

    function setBookName($new_book_name){
        $this->book_name = $new_book_name;
    }

    function getBookName(){
        return $this->book_name;
    }

    function getId(){
        return $this->id;
    }

    //Add a author to a book:
    function addAuthor($author){
        $GLOBALS['DB']->exec("INSERT INTO book_list (author_id, book_id)
                    VALUES ({$author->getId()}, {$this->getId()});");
    }

    //Get all authors assigned to a book:
    //This method is UNFINISHED.
    function getAuthors() {
        //join statement
        $found_authors = $GLOBALS['DB']->query("SELECT authors.* FROM
        books JOIN book_list ON (books.id = book_list.book_id)
                 JOIN authors ON (book_list.author_id = authors.id)
                 WHERE (books.id = {$this->getId()});");
         //convert output of the join statement into an array
         $found_authors = $found_authors->fetchAll(PDO::FETCH_ASSOC);
         $book_list = array();
         foreach($found_authors as $found_author) {
             $author_name = $found_author['author_name'];
             $id = $found_author['id'];
             $new_author = new Author($author_name, $id);
             array_push($book_list, $new_author);
         }
         return $book_list;
    }

    //Save a book to books table:
    function save() {
        $statement = $GLOBALS['DB']->exec("INSERT INTO books (book_name)
                        VALUES ('{$this->getBookName()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    //change book name
    function update($new_book_name) {
        $GLOBALS['DB']->exec("UPDATE books SET book_name = '{$new_book_name}' WHERE id = {$this->getId()};");
        $this->setBookName($new_book_name);
    }

    //delete one book
    function deleteOne() {
        $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM book_list WHERE book_id = {$this->getId()};");
    }

    //Clear all books from books table:
    static function deleteAll(){
        $GLOBALS['DB']->exec("DELETE FROM books;");
    }

    //Retrieve all books from books table:
    static function getAll(){
        $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
        $books = array();
        foreach ($returned_books as $book) {
            $book_name = $book['book_name'];
            $id = $book['id'];
            $new_book = new Book ($book_name, $id);
            array_push($books, $new_book);
        }
        return $books;
    }

    //Find books by id in books table:
    //Built finder with DB query string instead of foreach loop.  It works :P
    static function find($search_id){
        $search_book = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$search_id}");
        $found_book = $search_book->fetchAll(PDO::FETCH_ASSOC);
        $book_name = $found_book[0]['book_name'];
        $id = $found_book[0]['id'];
        $new_book = new Book($book_name, $id);
        return $new_book;
    }



}

?>
