<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //Linking class for testing
    require_once "src/Author.php";

    //Setting server up to apache and mysql passwords.
    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase {

        //Clears data for next test after each test:
        protected function tearDown() {
            Author::deleteAll();
        }

        //Test getters:
        function test_getAuthorName() {

            //Arrange
            $author_name = "Aristole";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            //Act
            $result = $test_author->getAuthorName();

            //Assert
            $this->assertEquals($result, $author_name);
        }

        function testSetAuthorName()
        {
            //Arrange
            $author_name = "Stephen King";
            $id = 1;
            $test_author = new Author($author_name, $id);

            //Act
            $test_author->setAuthorName("Plato");
            $result = $test_author->getAuthorName();

            //Assert
            $this->assertEquals("Plato", $result);
        }

        function test_getId() {

            //Arrange
            $author_name = "Aristole";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        //Test save:
        function test_save() {
            //Arrange
            $author_name = "Aristole";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author], $result);
        }

        function testUpdate () {
            //Arrange
            $author_name = "Stephen King";
            $id = 1;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $new_author_name = "Plato";

            //Act
            $test_author->update($new_author_name);

            //Assert
            $this->assertEquals("Plato", $test_author->getAuthorName());
        }

        function testDeleteAuthor()
        {
            //Arrange
            $author_name = "Plato";
            $id = 1;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $author_name2 = "Stephen King";
            $id2 = 2;
            $test_author2 = new Author($author_name, $id2);
            $test_author2->save();

            //Act
            $test_author->deleteOne();

            //Assert
            $this->assertEquals([$test_author2], Author::getAll());
        }
        
        //Test getAll:
        function test_getAll() {
            //Arrange
            $author_name = "Aristole";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $author_name2 = "Plato";
            $test_author2 = new Author($author_name2, $id);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        //Test find:
        function test_find() {
            //Arrange
            $author_name = "Aristole";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $author_name2 = "Plato";
            $test_author2 = new Author($author_name2, $id);
            $test_author2->save();

            //Act
            $id = $test_author->getId();
            $result = Author::find($id);

            //Assert
            $this->assertEquals($test_author, $result);
        }


    }
?>
