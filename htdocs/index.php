<?php

// FRONTCONTROLLER

/**
 * Bootstrap the framework.
 */
// Where are all the files? Booth are needed by Anax.
define("ANAX_INSTALL_PATH", realpath(__DIR__ . "/.."));
define("ANAX_APP_PATH", ANAX_INSTALL_PATH);

// Include essentials
require ANAX_INSTALL_PATH . "/config/error_reporting.php";

// Get the autoloader by using composers version.
require ANAX_INSTALL_PATH . "/vendor/autoload.php";

// Add all resources to $app
$app = new \ylwr15\App\App();
$app->request = new \Anax\Request\Request();
$app->url     = new \Anax\Url\Url();
$app->response = new \Anax\Response\Response();
$app->router  = new \Anax\Route\RouterInjectable();
$app->view     = new \Anax\View\ViewContainer();

// Init the object of the request class.
$app->request->init();

// Init the url-object with default values from the request object.
$app->url->setSiteUrl($app->request->getSiteUrl());
$app->url->setBaseUrl($app->request->getBaseUrl());
$app->url->setStaticSiteUrl($app->request->getSiteUrl());
$app->url->setStaticBaseUrl($app->request->getBaseUrl());
$app->url->setScriptName($app->request->getScriptName());

// Update url configuration with values from config file.
$app->url->configure("url.php");
$app->url->setDefaultsFromConfiguration();
$app->view->setApp($app);
$app->view->configure("view.php");
// Load the routes
require ANAX_INSTALL_PATH . "/config/route.php";

// Leave to router to match incoming request to routes
$app->router->handle($app->request->getRoute());
