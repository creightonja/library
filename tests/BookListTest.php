<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //Linking class for testing
    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/BookList.php";

    //Setting server up to apache and mysql passwords.
    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookListTest extends PHPUnit_Framework_TestCase {

        //Clears data for next test after each test
        protected function tearDown() {
            Book::deleteAll();
            Author::deleteAll();
            BookList::deleteAll();
        }

        //Test getters:
        function test_getAuthorId() {

            //Arrange
            $book_name = "Gattica";
            $book_id = 2;
            $test_book = new Book($book_name, $book_id);
            $test_book->save();

            $author_name = "Aristole";
            $author_id2 = 1;
            $test_author = new Author($author_name, $author_id2);
            $test_author->save();

            $author_id = $test_author->getId();
            $book_id = $test_book->getId();
            $due_date = "2015-08-29";
            $id = 3;
            $checkout_patron_id = 1;
            $test_book_list = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            $test_book_list->save();


            //Act
            $result = $test_book_list->getAuthorId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }


        function test_getBookId() {

            //Arrange
            $book_name = "Gattica";
            $book_id = 2;
            $test_book = new Book($book_name, $book_id);
            $test_book->save();

            $author_name = "Aristole";
            $author_id2 = 1;
            $test_author = new Author($author_name, $author_id2);
            $test_author->save();

            $author_id = $test_author->getId();
            $book_id = $test_book->getId();
            $due_date = "2015-08-29";
            $id = 3;
            $checkout_patron_id = 1;
            $test_book_list = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            $test_book_list->save();


            //Act
            $result = $test_book_list->getBookId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getDueDate() {

            //Arrange
            $book_name = "Gattica";
            $book_id = 2;
            $test_book = new Book($book_name, $book_id);
            $test_book->save();

            $author_name = "Aristole";
            $author_id2 = 1;
            $test_author = new Author($author_name, $author_id2);
            $test_author->save();

            $author_id = $test_author->getId();
            $book_id = $test_book->getId();
            $due_date = "2015-08-29";
            $id = 3;
            $checkout_patron_id = 1;
            $test_book_list = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            $test_book_list->save();


            //Act
            $result = $test_book_list->getDueDate();

            //Assert
            $this->assertEquals($due_date, $result);
        }

        function test_getCheckoutPatronId() {

            //Arrange
            $book_name = "Gattica";
            $book_id = 2;
            $test_book = new Book($book_name, $book_id);
            $test_book->save();

            $author_name = "Aristole";
            $author_id2 = 1;
            $test_author = new Author($author_name, $author_id2);
            $test_author->save();

            $author_id = $test_author->getId();
            $book_id = $test_book->getId();
            $due_date = "2015-08-29";
            $id = 3;
            $checkout_patron_id = 1;
            $test_book_list = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            $test_book_list->save();


            //Act
            $result = $test_book_list->getCheckoutPatronId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getId() {

            //Arrange
            $book_name = "Gattica";
            $book_id = 2;
            $test_book = new Book($book_name, $book_id);
            $test_book->save();

            $author_name = "Aristole";
            $author_id2 = 1;
            $test_author = new Author($author_name, $author_id2);
            $test_author->save();

            $author_id = $test_author->getId();
            $book_id = $test_book->getId();
            $due_date = "2015-08-29";
            $id = 3;
            $checkout_patron_id = 1;
            $test_book_list = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            $test_book_list->save();


            //Act
            $result = $test_book_list->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save() {

            //Arrange
            $book_name = "Gattica";
            $book_id = 2;
            $test_book = new Book($book_name, $book_id);
            $test_book->save();

            $author_name = "Aristole";
            $author_id2 = 1;
            $test_author = new Author($author_name, $author_id2);
            $test_author->save();

            $author_id = $test_author->getId();
            $book_id = $test_book->getId();
            $due_date = "2015-08-29";
            $id = 3;
            $checkout_patron_id = 1;
            $test_book_list = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            $test_book_list->save();


            //Act
            $result = BookList::getAll();

            //Assert
            $this->assertEquals([$test_book_list], $result);
        }


    }//End Class

?>
