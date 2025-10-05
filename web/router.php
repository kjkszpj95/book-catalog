<?php
if (file_exists($_SERVER["DOCUMENT_ROOT"] . $_SERVER["REQUEST_URI"])) {
    return false;
}
$_GET['q'] = $_SERVER['REQUEST_URI'];
require 'index.php';