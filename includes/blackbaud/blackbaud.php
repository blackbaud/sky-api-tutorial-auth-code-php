<?php
// Error reporting, for development only.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'session.php';
require_once join(DIRECTORY_SEPARATOR, array($_SERVER['DOCUMENT_ROOT'], 'config.php'));
require_once join(DIRECTORY_SEPARATOR, array('api', 'constituents.php'));
require_once 'auth.php';
require_once 'http.php';
