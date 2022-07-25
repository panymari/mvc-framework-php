<?php

require_once './config/const.php';
require_once 'vendor/autoload.php'; //автозагрузчик классов
require_once 'vendor/main.php'; //основной класс приложения


$application = new Application();
$application->run();

//tests
//$cart = new Cart();
//get info of ech product and service
//var_dump($cart->getProductInfo(new TvSetProduct("TV set", "test1", "12.07.2020", 10000)));
//var_dump($cart->getProductInfo(new FridgeProduct("fridge", "test2", "13.07.2020", 121212)));
//var_dump($cart->getProductInfo(new LaptopProduct("laptop", "test3", "14.07.2020", 23231)));
//var_dump($cart->getProductInfo(new MobilePhoneProduct("mobile phone", "test4", "15.07.2020", 1173672)));
//
//var_dump($cart->getServiceInfo(new ConfigureService("20.05.2022", "test1", 10000)));
//var_dump($cart->getServiceInfo(new DeliveryService("21.05.2022", "test2", 121212)));
//var_dump($cart->getServiceInfo(new Install("22.05.2022", "test3", 23231)));
//var_dump($cart->getServiceInfo(new Service("23.05.2022", "test4", 1173672)));


//add several products
//var_dump($cart->addProduct(new Fridge("fridge", "test2", "13.07.2020", 121212)));
//var_dump("<br><br>");
//var_dump($cart->addProduct(new TvSet("TV set", "test1", "12.07.2020", 10000)));

//without error on service, but with advise in product
//var_dump($cart->addProduct(new TvSet("TV set", "test1", "12.07.2020", 10000)));
//var_dump($cart->addService(new Service("23.05.2022", "test4", 1173672)));


//okay adding test and product
//$cart->addProduct(new TvSet("TV set", "test1", "12.07.2020", 10000));
//var_dump($cart->addService(new Service("23.05.2022", "test4", 1173672)));

//error "Please, select any product"
//var_dump($cart->addService(new Service("23.05.2022", "test4", 1173672)));
//$cart->addProduct(new TvSet("TV set", "test1", "12.07.2020", 10000));
