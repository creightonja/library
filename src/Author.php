<?php

    class Author {

        private $author_name;
        private $id;

        function __construct($author_name, $id = null) {
            $this->author_name = $author_name;
            $this->id = $id;
        }


        function setAuthorName($new_author_name) {
            $this->author_name = $new_author_name;
        }

        function getAuthorName(){
            return $this->author_name;
        }

        function getId() {
            return $this->id;
        }

        function save() {
            $statement = $GLOBALS['DB']->exec("INSERT INTO authors (author_name)
                    VALUES ('{$this->getAuthorName()}') RETURNING id;");
            $this->id = $GLOBALS['DB']->lastInsertId('authors_id_seq');
        }

        function getBooks() {
            $query = $GLOBALS['DB']->query("SELECT DISTINCT book_id FROM book_list WHERE
                                            author_id = {$this->getId()};");
            // $book_ids = $query->fetchAll(PDO::FETCH_ASSOC);
            $books = Array();
            foreach($query as $id) {
                $book_id = $id['book_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$book_id};");
                $returned_book = $result->fetchAll(PDO::FETCH_ASSOC);
                $book_name = $returned_book[0]['book_name'];
                $id = $returned_book[0]['id'];
                $new_book = new Book($book_name, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        function update($new_author_name) {
             $GLOBALS['DB']->exec("UPDATE authors set author_name = '{$new_author_name}'
                    WHERE id = {$this->getId()};");
             $this->setAuthorName($new_author_name);
         }

        function addBook($book) {
            $GLOBALS['DB']->exec("INSERT INTO book_list (author_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
        }
        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM book_list WHERE author_id = {$this->getId()};");
        }

        //Clear all authors from authors table:
        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
        }
        //Retrieve all authors from authors table:
        static function getAll() {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = array();
            foreach ($returned_authors as $author) {
                $author_name = $author['author_name'];
                $id = $author['id'];
                $new_author = new Author($author_name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }
        //Find authors by id in authors table:
        //Built finder with DB query string instead of foreach loop. It works :P
        static function find($search_id) {
            $search_author = $GLOBALS['DB']->query("SELECT * FROM authors WHERE id = {$search_id}");
            $found_author = $search_author->fetchAll(PDO::FETCH_ASSOC);
            $author_name = $found_author[0]['author_name'];
            $id = $found_author[0]['id'];
            $new_book = new Author($author_name, $id);
            return $new_book;
        }

    }//End class


?>
