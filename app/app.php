<?php

    //Loading class functionality
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    //Silex preloads
    $app = new Silex\Application();
    $app['debug'] = true;

    //PDO setup
    $server = 'mysql:host=localhost;dbname=shoestores';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    //Patch and delete functions from symfony
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();


    //Use silex to load page and twig path
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
                    'twig.path' => __DIR__.'/../views'
    ));

    //Index page rendering links to stores and brands
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    //-------------------------------------- Begin Brand Functionality ---------------------------------------

    //Brands page, lists, add, edit, or delete a brand links.
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //Adds a new brand to DB, renders to brands.html
    $app->post("/brands", function() use ($app) {
        $brand_name = $_POST['brand_name'];
        $brand = new Brand($brand_name, $id=null);
        $brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //Showing a brand's schedule of stores.  Renders to particular brand's page with crud function
    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    //Linking brand to a store
    $app->post("/add_brands", function() use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'stores' => Store::getAll(), 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    //Updates brand, comes from brand.html, posts back to brands.html with updated brand info
    $app->patch("/brand/{id}/edit", function($id) use ($app){
        $new_brand_name = $_POST['new_brand_name'];
        $brand = Brand::find($id);
        $brand->update($new_brand_name);
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });
    //Deletes brand, comes from brand.html, posts back to brands.html minus deleted brand
    $app->delete("/brand/{id}/edit", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->deleteOne();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //Delete All Brands from DB
    $app->post("/delete_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    // -------------------------End Brand Routes -------------------------


    // -------------------------Begin Store Routes -------------------------



    //Main stores page, displays all stores.
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //Adds a new store to stores table.
    $app->post("/stores", function() use ($app) {
        $id = null;
        $store = new Store($_POST['store_name']);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //Listing all brands for a selected store. Check all_brands variable for error issue
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    //
    $app->post("/add_stores", function() use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $brand->addStore($store);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'brands' => Brand::getAll(), 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });


    //
    $app->post("/delete_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    //Updates store, comes from store.html, posts back to stores.html
    $app->patch("/store/{id}/edit", function($id) use ($app){
        $new_store_name = $_POST['new_store_name'];
        $store = Store::find($id);
        $store->update($new_store_name);
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });
    //Deletes store, comes from store.html, posts back to stores.html
    $app->delete("/store/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        $store->deleteOne();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });
    return $app;
?>
