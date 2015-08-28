<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost;dbname=shoestores';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function testGetBrandName() {
            //Arrange
            $brand_name = "Nike";
            $id = 2;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            //Act
            $result = $test_brand->getBrandName();

            //Assert
            $this->assertEquals($brand_name, $result);
        }

        function testSetBrandName() {
            //Arrange
            $brand_name = "Nike";
            $id = 2;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            //Act
            $test_brand->setBrandName("Pablo");
            $result = $test_brand->getBrandName();

            //Assert
            $this->assertEquals("Pablo", $result);
        }

        function test_getId() {
            //Arrange
            $brand_name = "Nike";
            $id = 2;
            $test_brand = new Brand($brand_name, $id);


            //Act
            $result = $test_brand->getId();

            //Assert
            $this->assertEquals(2, $result);
        }

        function test_save() {
            //Arrange
            $brand_name = "Nike";
            $id = 2;
            $test_brand = new Brand($brand_name, $id);

            //Act
            $test_brand->save();

            //Assert
            $result = Brand::getAll();
            $this->assertEquals([$test_brand], $result);
        }

        function testSaveSetsId () {
            //Arrange
            $brand_name = "Nike";
            $id = 2;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            //Act
            $test_brand->save();

            //Assert
            $this->assertEquals(true, is_numeric($test_brand->getId()));
        }

        function test_getAll() {
            //Arrange
            $brand_name = "Nike";
            $id = 2;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            $brand_name2 = "Addidas";
            $id2 = 3;
            $test_brand2 = new Brand($brand_name2, $id2);
            $test_brand2->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        // function test_deleteAll() {
        //     //Arrange
        //     $brand_name = "Nike";
        //     $id = 2;
        //     $test_brand = new Brand($brand_name, $id);
        //     $test_brand->save();
        //
        //     $brand_name2 = "Addidas";
        //     $id2 = 3;
        //     $test_brand2 = new Brand($brand_name2, $id2);
        //     $test_brand2->save();
        //
        //     //Act
        //     Brand::deleteAll();
        //
        //     //Assert
        //     $result = Brand::getAll();
        //     $this->assertEquals([], $result);
        // }
        //
        // function test_find() {
        //     //Arrange
        //     $brand_name = "Nike";
        //     $id = 2;
        //     $test_brand = new Brand($brand_name, $id);
        //     $test_brand->save();
        //
        //     $brand_name2 = "Addidas";
        //     $id2 = 3;
        //     $test_brand2 = new Brand($brand_name2, $id2);
        //     $test_brand2->save();
        //
        //     //Act
        //     $id = $test_Brand->getId();
        //     $result = Brand::find($id);
        //
        //     //Assert
        //     $this->assertEquals($test_Brand, $result);
        // }
        //
        // function testUpdate() {
        //     //Arrange
        //     $brand_name = "Nike";
        //     $id = 2;
        //     $test_brand = new Brand($brand_name, $id);
        //     $test_brand->save();
        //     $new_brand_name = "Addidas";
        //
        //     //Act
        //     $test_brand->update($new_brand_name);
        //
        //     //Assert
        //     $this->assertEquals("Pablo", $test_brand->getBrandName());
        // }
        //
        // function testDeleteBrand() {
        //     //Arrange
        //     $brand_name = "Nike";
        //     $id = 2;
        //     $test_brand = new Brand($brand_name, $id);
        //     $test_brand->save();
        //
        //     $brand_name2 = "Addidas";
        //     $id2 = 3;
        //     $test_brand2 = new Brand($brand_name2, $id2);
        //     $test_brand2->save();
        //
        //     //Act
        //     $test_brand->deleteOne();
        //
        //     //Assert
        //     $this->assertEquals([$test_brand2], Brand::getAll());
        // }
        //
        // function testAddStore()
        // {
        //     //Arrange
        //     $store_name = "Shoe Barn";
        //     $id = 1;
        //     $test_store = new Store ($store_name, $id);
        //     $test_store->save();
        //
        //     $brand_name2 = "Addidas";
        //     $id2 = 3;
        //     $test_brand2 = new Brand($brand_name2, $id2);
        //     $test_brand2->save();
        //
        //     //Act
        //     $test_brand->addStore($test_store);
        //     $result = $test_brand->getStores();
        //
        //     //Assert
        //     $this->assertEquals([$test_store], $result);
        // }
        //
        // function testGetStores()
        // {
        //     //Arrange
        //     $store_name = "Shoe Barn";
        //     $id = 1;
        //     $test_store = new Store ($store_name, $id);
        //     $test_store->save();
        //
        //     $store_name2 = "Bobs shoes";
        //     $id2 = 2;
        //     $test_store2 = new Store ($store_name2, $id2);
        //     $test_store2->save();
        //
        //     $brand_name2 = "Addidas";
        //     $id2 = 3;
        //     $test_brand2 = new Brand($brand_name2, $id2);
        //     $test_brand2->save();
        //
        //     //Act
        //     $test_brand->addStore($test_store);
        //     $test_brand->addStore($test_store2);
        //
        //     //Assert
        //     $this->assertEquals($test_brand->getStores(), [$test_store, $test_store2]);
        // }
        //
        // function testDelete() {
        //     //Arrange
        //     $store_name = "Shoe Barn";
        //     $id = 1;
        //     $test_store = new Store ($store_name, $id);
        //     $test_store->save();
        //
        //     $brand_name2 = "Addidas";
        //     $id2 = 3;
        //     $test_brand2 = new Brand($brand_name2, $id2);
        //     $test_brand2->save();
        //
        //     //Act
        //     $test_brand->addStore($test_store);
        //     $test_brand->deleteOne();
        //
        //     //Assert
        //     $this->assertEquals([], $test_store->getBrands());
        // }
            //Finished all brand tests
    }
?>
