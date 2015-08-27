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

        function test_getAll() {

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

            $due_date2 = "2015-08-27";
            $id2 = 4;
            $checkout_patron_id2 = 2;
            $test_book_list2 = new BookList($author_id, $book_id, $due_date2, $checkout_patron_id2, $id2);
            $test_book_list2->save();


            //Act
            $result = BookList::getAll();

            //Assert
            $this->assertEquals([$test_book_list, $test_book_list2], $result);
        }

        function test_deleteAll() {

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
            BookList::deleteAll();
            $result = BookList::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_findGetCheckoutPatronId(){
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

            $due_date2 = "2015-08-27";
            $id2 = 4;
            $checkout_patron_id2 = 2;
            $test_book_list2 = new BookList($author_id, $book_id, $due_date2, $checkout_patron_id2, $id2);
            $test_book_list2->save();

            //Act
            $search_id = $test_book_list2->getCheckoutPatronId();
            $column_id = "checkout_patron_id";
            $result = BookList::find($column_id, $search_id);

            //Assert
            $this->assertEquals([$test_book_list2], $result);
        }

        function test_findDueDate(){
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

            $due_date2 = "2015-08-27";
            $id2 = 4;
            $checkout_patron_id2 = 2;
            $test_book_list2 = new BookList($author_id, $book_id, $due_date2, $checkout_patron_id2, $id2);
            $test_book_list2->save();

            //Act
            $search_id = $test_book_list2->getDueDate();
            $column_id = "due_date";
            $result = BookList::find($column_id, $search_id);

            //Assert
            $this->assertEquals([$test_book_list2], $result);
        }

        function test_findMultipleDueDate(){
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

            $due_date2 = "2015-08-27";
            $id2 = 4;
            $checkout_patron_id2 = 2;
            $test_book_list2 = new BookList($author_id, $book_id, $due_date2, $checkout_patron_id2, $id2);
            $test_book_list2->save();

            $due_date3 = "2015-08-27";
            $id3 = 5;
            $checkout_patron_id3 = 3;
            $test_book_list3 = new BookList($author_id, $book_id, $due_date3, $checkout_patron_id3, $id3);
            $test_book_list3->save();

            //Act
            $search_id = $test_book_list2->getDueDate();
            $column_id = "due_date";
            $result = BookList::find($column_id, $search_id);

            //Assert
            $this->assertEquals([$test_book_list2, $test_book_list3], $result);
        }

        function test_findByAuthorBookId(){
            //Arrange
            $book_name = "Gattica";
            $book_id = 2;
            $test_book = new Book($book_name, $book_id);
            $test_book->save();

            $author_name = "Aristole";
            $author_id2 = 1;
            $test_author = new Author($author_name, $author_id2);
            $test_author->save();

            $book_name = "Battlestar";
            $book_id = 2;
            $test_book2 = new Book($book_name, $book_id);
            $test_book2->save();

            $author_name = "Plato";
            $author_id2 = 1;
            $test_author2 = new Author($author_name, $author_id2);
            $test_author2->save();

            $author_id = $test_author->getId();
            $book_id = $test_book->getId();
            $due_date = "2015-08-29";
            $id = 3;
            $checkout_patron_id = 1;
            $test_book_list = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            $test_book_list->save();

            $author_id2 = $test_author2->getId();
            $book_id2 = $test_book2->getId();
            $due_date2 = "2015-08-27";
            $id2 = 4;
            $checkout_patron_id2 = 2;
            $test_book_list2 = new BookList($author_id2, $book_id2, $due_date2, $checkout_patron_id2, $id2);
            $test_book_list2->save();

            $due_date3 = "2015-08-27";
            $id3 = 5;
            $checkout_patron_id3 = 3;
            $test_book_list3 = new BookList($author_id, $book_id, $due_date3, $checkout_patron_id3, $id3);
            $test_book_list3->save();

            //Act
            $search_id1 = $test_book_list->getAuthorId();
            $search_id2 = $test_book_list->getBookId();
            $result = BookList::findBookList($search_id1, $search_id2);

            //Assert
            $this->assertEquals([$test_book_list, $test_book_list3], $result);
        }

        function test_updateBookList(){
            //Arrange
            $book_name = "Gattica";
            $book_id = 2;
            $test_book = new Book($book_name, $book_id);
            $test_book->save();

            $author_name = "Aristole";
            $author_id2 = 1;
            $test_author = new Author($author_name, $author_id2);
            $test_author->save();

            $book_name = "Battlestar";
            $book_id = 2;
            $test_book2 = new Book($book_name, $book_id);
            $test_book2->save();

            $author_name = "Plato";
            $author_id2 = 1;
            $test_author2 = new Author($author_name, $author_id2);
            $test_author2->save();

            $author_id = $test_author->getId();
            $book_id = $test_book->getId();
            $due_date = "2015-08-29";
            $id = 3;
            $checkout_patron_id = 1;
            $test_book_list = new BookList($author_id, $book_id, $due_date, $checkout_patron_id, $id);
            $test_book_list->save();

            $author_id2 = $test_author2->getId();
            $book_id2 = $test_book2->getId();
            $due_date2 = "2015-08-27";
            $id2 = 4;
            $checkout_patron_id2 = 2;
            $test_book_list2 = new BookList($author_id2, $book_id2, $due_date2, $checkout_patron_id2, $id2);
            $test_book_list2->save();

            $due_date3 = "2015-08-27";
            $id3 = 5;
            $checkout_patron_id3 = 3;
            $test_book_list3 = new BookList($author_id, $book_id, $due_date3, $checkout_patron_id3, $id3);
            $test_book_list3->save();

            //Act
            $new_due_date = "2016-07-26";
            $new_checkout_patron_id = 99;
            $test_book_list->update($new_due_date, $new_checkout_patron_id);
            $result = $test_book_list->getCheckoutPatronId();

            //Assert
            $this->assertEquals($new_checkout_patron_id, $result);
        }

    }//End Class

?>
