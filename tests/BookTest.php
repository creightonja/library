<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //Linking class for testing
    require_once "src/Book.php";
    require_once "src/Author.php";

    //Setting server up to apache and mysql passwords.
    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase {

        //Clears data for next test after each test
        protected function tearDown() {
            Book::deleteAll();
            Author::deleteAll();
        }

        //Test getters:
        function test_getBookName() {

            //Arrange
            $book_name = "Gattica";
            $id = 1;
            $test_book = new Book($book_name, $id);
            $test_book->save();

            //Act
            $result = $test_book->getBookName();

            //Assert
            $this->assertEquals($result, $book_name);
        }

        function testSetBookName() {
            //Arrange
            $book_name = "Gattica";
            $id = 1;
            $test_book = new Book($book_name, $id);
            $test_book->save();

            //Act
            $test_book->setBookName("How to run");
            $result = $test_book->getBookName();

            //Assert
            $this->assertEquals("How to run", $result);
        }

        function test_getId() {
            //Arrange
            $book_name = "Gattica";
            $id = 1;
            $test_book = new Book($book_name, $id);
            $test_book->save();

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        //Test save:
        function test_save() {
            //Arrange
            $book_name = "Gattica";
            $id = 1;
            $test_book = new Book($book_name, $id);
            $test_book->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book], $result);
        }

        //Test getAll:
        function test_getAll() {
            //Arrange
            $book_name = "Gattica";
            $id = 1;
            $test_book = new Book($book_name, $id);
            $test_book->save();

            $book_name2 = "How to run";
            $id2 = 2;
            $test_book2 = new Book($book_name2, $id2);
            $test_book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        //Test deleteAll:
        function test_deleteAll(){
            //Arrange
            $book_name = "Gattica";
            $id = 1;
            $test_book = new Book($book_name, $id);
            $test_book->save();

            $book_name2 = "How to run";
            $id2 = 2;
            $test_book2 = new Book($book_name2, $id2);
            $test_book2->save();

            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        //Test find:
        function test_find(){
            //Arrange
            $book_name = "Gattica";
            $id = 1;
            $test_book = new Book($book_name, $id);
            $test_book->save();

            $book_name2 = "How to run";
            $id2 = 2;
            $test_book2 = new Book($book_name2, $id2);
            $test_book2->save();

            //Act
            $id = $test_book->getId();
            $result = Book::find($id);

            //Assert
            $this->assertEquals($test_book, $result);
        }

        //Test add author to book
        function test_addAuthor(){
            //Arrange
            $author_name = "MTH101";
            $crn = 1234;
            $id = 1;
            $test_author = new Author($author_name, $crn, $id);
            $test_author->save();

            $book_name = "Gattica";
            $id = 1;
            $test_book = new Book($book_name, $id);
            $test_book->save();

            //Act
            $test_book->addAuthor($test_author);
            $result = $test_book->getAuthors();

            //Assert
            $this->assertEquals([$test_author], $result);
        }

        function testUpdate() {
             //Arrange
             $book_name = "Gattica";
             $id = 1;
             $test_book = new Book($book_name, $id);
             $test_book->save();
             $new_book_name = "How to run";

             //Act
             $test_book->update($new_book_name);

             //Assert
             $this->assertEquals($new_book_name, $test_book->getBookName());
         }

         function testDeleteBook() {
             //Arrange
             $book_name = "Gattica";
             $id = 1;
             $test_book = new Book($book_name, $id);
             $test_book->save();

             $book_name2 = "How to run";
             $id2 = 2;
             $test_book2 = new Book($book_name2, $id2);
             $test_book2->save();

             //Act
             $test_book->deleteOne();

             //Assert
             $this->assertEquals([$test_book2], Book::getAll());
         }

         function testAddAuthor() {
             //Arrange
             $author_name = "Stephen King";
             $id = 1;
             $test_author = new Author($author_name, $id);
             $test_author->save();

             $book_name = "Gattica";
             $id = 1;
             $test_book = new Book($book_name, $id);
             $test_book->save();

             //Act
             $test_book->addAuthor($test_author);
             $result = $test_book->getAuthors();

             //Assert
             $this->assertEquals([$test_author], $result);
         }

         function testGetAuthor() {
             //Arrange
             $author_name = "Stephen King";
             $id = 1;
             $test_author = new Author($author_name, $id);
             $test_author->save();

             $author_name2 = "Bob Smith";
             $id2 = 2;
             $test_author2 = new Author($author_name2, $id2);
             $test_author2->save();

             $book_name = "Gattica";
             $id = 1;
             $test_book = new Book($book_name, $id);
             $test_book->save();
             //Act
             $test_book->addAuthor($test_author);
             $test_book->addAuthor($test_author2);

             //Assert
             $this->assertEquals($test_book->getAuthors(), [$test_author, $test_author2]);
         }

         function testDelete() {
             //Arrange
             $author_name = "Stephen King";
             $id = 1;
             $test_author = new Author($author_name, $id);
             $test_author->save();

             $book_name = "Gattica";
             $id = 1;
             $test_book = new Book($book_name, $id);
             $test_book->save();

             //Act
             $test_book->addAuthor($test_author);
             $test_book->deleteOne();

             //Assert
             $this->assertEquals([], $test_author->getBooks());
         }
     //Finished all book tests

    }
?>
