<?php
require 'vendor/autoload.php';
require 'init.php';

if(MODULE){
    try {
        $className = MODULE;
        $class = new ReflectionClass("\Controller\\$className\\$className");
        $class = $class->newInstance();
        if (defined('ACTION')) {
            $actionName = ACTION;
            $reflectionMethod = new ReflectionMethod($class, $actionName);
            $reflectionMethod->invokeArgs($class, $_GET);
        } else {
            switch($_SERVER['REQUEST_METHOD']){
                case "POST":
                    $class->save($_POST);
                    break;
                case "DELETE":
                    $class->delete($_GET['id']);
                    break;
                default:
                    $class->get($_GET['id']);
            }
        }
    } catch (Exception $e) {
        die("Error".($e->getMessage() ? " - ".$e->getMessage() : ""));
    }
}