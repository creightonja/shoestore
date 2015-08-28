
# Shoe Stores

##### Shoe store search function, 8/28/2015

#### By Jason Creighton

## Description

This application will allow users to create relationships between shoe stores and the brands they carry, and then search either by brand or store
to find the associated shoes from either category.

## Setup

- clone this repository
- Run $ composer install in project folder
- Start apache server
- Start mySQL server
- Start php server in web directory folder
- Run phpmyadmin and import database from folder
- navigate web browser to localhost:8000


## SQL Strings Used

- "INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}')"
- "UPDATE brands SET brand_name = '{$new_brand_name}' WHERE id = {$this->getId()};"
- "DELETE FROM brands WHERE id = {$this->getId()};"
- "DELETE FROM shoes_stores WHERE brand_id = {$this->getId()};"
- "INSERT INTO shoes_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});"
- "SELECT stores.* FROM brands JOIN shoes_stores ON (brands.id = shoes_stores.brand_id)
             JOIN stores ON (shoes_stores.store_id = stores.id) WHERE brands.id = {$this->getId()};"
- SELECT * FROM brands;
- Duplicates for Stores.
- This assignment did not require a many to many table setup since each unique instance of a brand did not need to be listed multiple times on a store page.  If
    there were unique brands with multiple shoe styles in stores, then the assignment would call for a many to many relationship.

## Technologies Used

PHP, phpunit, phpmyadmin, Silex, Twig, HTML, CSS, Boostrap, Symfony, MySQL, Apache

### Legal


Copyright (c) 2015 Jason Creighton

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
