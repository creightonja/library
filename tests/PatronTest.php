<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Author::deleteAll();
            Book::deleteAll();
            Patron::deleteAll();
        }

        function test_setPatronName() {
            //Arrange
            $patron_name = "Paco";
            $id = null;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();

            //Act
            $new_name = "Burrito";
            $test_patron->setPatronName($new_name);
            $result = $test_patron->getPatronName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_getPatronName() {
            //Arrange
            $patron_name = "Paco";
            $id = null;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();

            //Act
            $result = $test_patron->getPatronName();

            //Assert
            $this->assertEquals($result, $patron_name);
        }

        function test_getId() {
            //Arrange
            $patron_name = "Paco";
            $id = null;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();

            //Act
            $result = $test_patron->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save() {
            //Arrange
            $patron_name = "Paco";
            $id = null;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron], $result);
        }

        function test_Update() {
            //Arrange
            $patron_name = "Paco";
            $id = null;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();
            $new_patron_name = "BurritoJr";

            //Act
            $test_patron->update($new_patron_name);
            $result = $test_patron->getPatronName();

            //Assert
            $this->assertEquals($new_patron_name, $result);
        }

        function test_DeletePatron() {
            $patron_name = "Paco";
            $id = 1;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();

            $patron_name2 = "BurritoJr";
            $id2 = 2;
            $test_patron2 = new Patron($patron_name2, $id2);
            $test_patron2->save();

            //Act
            $test_patron->deleteOne();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron2], $result);
        }

        function test_getAll() {

            //Arrange
            $patron_name = "Paco";
            $id = 1;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();

            $patron_name2 = "BurritoJr";
            $id2 = 2;
            $test_patron2 = new Patron($patron_name2, $id2);
            $test_patron2->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function test_find() {
            //Arrange
            $patron_name = "Paco";
            $id = 1;
            $test_patron = new Patron($patron_name, $id);
            $test_patron->save();

            $patron_name2 = "BurritoJr";
            $id2 = 2;
            $test_patron2 = new Patron($patron_name2, $id2);
            $test_patron2->save();

            //Act
            $test_id = $test_patron->getId();
            $result = Patron::find($test_id);

            //Arrange
            $this->assertEquals($test_patron, $result);
        }
    } //End class test

?>
