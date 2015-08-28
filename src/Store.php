<?php

    require_once "Brand.php";

    class Store {
        private $store_name;
        private $id;

        function __construct($store_name, $id = null) {
            $this->store_name = $store_name;
            $this->id = $id;
        }

        function setStoreName($new_store_name) {
            $this->store_name = (string) $new_store_name;
        }

        function getStoreName() {
            return $this->store_name;
        }

        function getId() {
            return $this->id;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO stores (store_name) VALUES ('{$this->getStoreName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function getBrands() {
            $selected_brand = $GLOBALS['DB']->query("SELECT brands.* FROM
                stores  JOIN shoes_stores ON  (stores.id = shoes_stores.store_id)
                         JOIN brands ON (shoes_stores.brand_id = brands.id)
                         WHERE stores.id = {$this->getId()};");
            $found_brands = $selected_brand->fetchAll(PDO::FETCH_ASSOC);
            //returning the brands for one particular store
            $brands_store = Array();
            foreach($found_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands_store, $new_brand);
            }
            return $brands_store;
        }

        function update($new_store_name) {
            $GLOBALS['DB']->exec("UPDATE stores set store_name = '{$new_store_name}' WHERE id = {$this->getId()};");
            $this->setStoreName($new_store_name);
        }

        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM shoes_stores WHERE store_id = {$this->getId()};");
        }

        function addBrand($brand) {
            $GLOBALS['DB']->exec("INSERT INTO shoes_stores (store_id, brand_id) VALUES ({$this->getId()}, {$brand->getId()});");
        }

        static function getAll() {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach($returned_stores as $store) {
                $store_name = $store['store_name'];
                $id = $store['id'];
                $new_store = new Store($store_name, $id, $store_number);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }

        static function find($search_id){
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }
    }
?>
