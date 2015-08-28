<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";

    $server = 'mysql:host=localhost;dbname=shoestores';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            //Brand::deleteAll();
            Store::deleteAll();
        }

        function testGetStoreName() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);

            //Act
            $result = $test_store->getStoreName();

            //Assert
            $this->assertEquals($store_name, $result);
        }
    }

?>
