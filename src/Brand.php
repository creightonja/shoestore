<?php

    class Brand
    {
        private $brand_name;
        private $id;

        function __construct($brand_name, $id = null)
        {
            $this->brand_name = $brand_name;
            $this->id = $id;
        }

        function setBrandName($new_brand_name)
        {
            $this->brand_name = (string) $new_brand_name;
        }

        function getBrandName()
        {
            return $this->brand_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->exec("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_brand_name) {
            $GLOBALS['DB']->exec("UPDATE brands SET brand_name = '{$new_brand_name}' WHERE id = {$this->getId()};");
            $this->setBrandName($new_brand_name);
        }

        function deleteOne() {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM shoes_stores WHERE brand_id = {$this->getId()};");
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO shoes_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        }

        function getStores()
        {
            //join statement
            $selected_store = $GLOBALS['DB']->query("SELECT stores.* FROM
                brands JOIN shoes_stores ON (brands.id = shoes_stores.brand_id)
                         JOIN stores ON (shoes_stores.store_id = stores.id)
                         WHERE brands.id = {$this->getId()};");
            //convert output of the join statement into an array
            $found_stores = $selected_store->fetchAll(PDO::FETCH_ASSOC);
            $brand_stores = array();
            foreach($found_stores as $found_store) {
                $store_name = $found_store['store_name'];
                $id = $found_store['id'];
                $new_store = new Store($store_name, $id);
                array_push($brand_stores, $new_store);
            }
            return $brand_stores;
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function find($search_id) {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $brand) {
                $brand_id = $brand->getId();
                if ($brand_id == $search_id) {
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

    }
?>
