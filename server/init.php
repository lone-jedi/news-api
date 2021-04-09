<?php
/*
    Headers for JSON API
*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Credentials: true");
header('Content-type: json/application');

/*
    Constants
*/
const BASE_URL = '/js/pro/api/server/';

const DB_HOST = 'localhost';
const DB_NAME = 'newsapi';
const DB_USER = 'root';
const DB_PASS = '';

/*
*  Requires
*/
// Exceptions
require_once 'exceptions/HttpException.php';

// Core
require_once 'core/Router.php';
require_once 'core/db/DbInstance.php';
require_once 'core/db/DbModel.php';
require_once 'core/Registry.php';

// Models
require_once 'models/News.php';

// Controllers
require_once 'controllers/NewsController.php';

// Config
require_once 'config/routes.php';