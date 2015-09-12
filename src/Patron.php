<?php

    class Patron {
        private $patron_name;
        private $id;

        function __construct($patron_name, $id = null) {
            $this->patron_name = $patron_name;
            $this->id = $id;
        }

        function setPatronName($new_patron_name) {
            $this->patron_name = $new_patron_name;
        }

        function getPatronName() {
            return $this->patron_name;
        }

        function getId() {
            return $this->id;
        }

        function save() {
            $statement = $GLOBALS['DB']->exec("INSERT INTO patrons (patron_name)
                    VALUES ('{$this->getPatronName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId('patrons_id_seq');
        }

        function update ($new_patron_name) {
            $GLOBALS['DB']->exec("UPDATE patrons set patron_name = '{$new_patron_name}'
                    WHERE id = {$this->getId()};");
            $this->setPatronName($new_patron_name);
        }

        function deleteOne() {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM book_list WHERE patron_id = {$this->getId()};");
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

        static function getAll() {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = array();
            foreach ($returned_patrons as $patron) {
                $patron_name = $patron['patron_name'];
                $id = $patron['id'];
                $new_patron = new Patron($patron_name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function find($search_id) {
            $search_patron = $GLOBALS['DB']->query("SELECT * FROM patrons
                                            WHERE id = {$search_id};");
            $found_patron = $search_patron->fetchAll(PDO::FETCH_ASSOC);
            $patron_name = $found_patron[0]['patron_name'];
            $id = $found_patron[0]['id'];
            $new_patron = new Patron($patron_name, $id);
            return $new_patron;
        }

    }//End class

?>
