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
            Brand::deleteAll();
            Store::deleteAll();
        }


        //Begin setter and getter tests
        function testSetStoreName() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);

            //Act
            $test_store->setStoreName("Bobs Shoes");
            $result = $test_store->getStoreName();

            //Assert
            $this->assertEquals("Bobs Shoes", $result);
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

        function test_getId() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = 2;
            $test_store = new Store($store_name, $id);

            //Act
            $result = $test_store->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }


        function test_save() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);

            //Act
            $test_store->save();

            //Assert
            $result = Store::getAll();
            $this->assertEquals($test_store, $result[0]);
        }

        function testSaveSetsId () {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);

            //Act
            $test_store->save();

            //Assert
            $this->assertEquals(true, is_numeric($test_store->getId()));
        }

        function test_getAll() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $store_name2 = "Bobs Shoes";
            $id2 = 2;
            $test_store2 = new Store ($store_name2, $id2);
            $test_store2->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_deleteAll() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $store_name2 = "Bobs Shoes";
            $id2 = 2;
            $test_store2 = new Store ($store_name2, $id2);
            $test_store2->save();

            //Act
            Store::deleteAll();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([], $result);
        }

        function test_find() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $store_name2 = "Bobs Shoes";
            $id2 = 2;
            $test_store2 = new Store ($store_name2, $id2);
            $test_store2->save();

            //Act
            $id = $test_store->getId();
            $result = Store::find($id);

            //Assert
            $this->assertEquals($test_store, $result);
        }

        function testUpdate() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);
            $test_store->save();
            $new_store_name = "Bobs Shoes";

            //Act
            $test_store->update($new_store_name);

            //Assert
            $this->assertEquals($new_store_name, $test_store->getStoreName());
        }

        function testDeleteStore() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = 1;
            $test_store = new Store ($store_name, $id);
            $test_store->save();

            $store_name2 = "Bobs Shoes";
            $id2 = 2;
            $test_store2 = new Store ($store_name2, $id2);
            $test_store2->save();

            //Act
            $test_store->deleteOne();

            //Assert
            $this->assertEquals([$test_store2], Store::getAll());
        }

        function testAddBrand()
        {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $brand_name = "Nike";
            $id2 = 2;
            $test_brand = new Brand($brand_name, $id2);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);
            $result = $test_store->getBrands();

            //Assert
            $this->assertEquals([$test_brand], $result);
        }

        function testGetBrands()
        {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $brand_name = "Nike";
            $id2 = 2;
            $test_brand = new Brand($brand_name, $id2);
            $test_brand->save();

            $brand_name2 = "Nike";
            $id3 = 3;
            $test_brand2 = new Brand($brand_name2, $id3);
            $test_brand2->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            //Assert
            $this->assertEquals($test_store->getBrands(), [$test_brand, $test_brand2]);
        }

        function testDelete() {
            //Arrange
            $store_name = "Shoe Barn";
            $id = null;
            $test_store = new Store($store_name, $id);
            $test_store->save();

            $brand_name = "Nike";
            $id2 = 2;
            $test_brand = new Brand($brand_name, $id2);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->deleteOne();

            //Assert
            $this->assertEquals([], $test_brand->getStores());
        }

    }

?>
