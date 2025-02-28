<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(__FILE__)));
}

spl_autoload_register(function ($className) {
    $libSource =  ROOT.DS.'lib'.DS.strtolower($className).'.class.php';
    $modelsSource = ROOT.DS.'models'.DS.ucfirst($className).'.php';
    $controllersSource = ROOT.DS.'controllers'.DS.str_replace('controller', '', strtolower($className)).'.controller.php';

    if (file_exists($libSource)) {
        require_once "{$libSource}";
    }
    else if (file_exists($modelsSource)) {
        require_once "{$modelsSource}";
    }
    else if (file_exists($controllersSource)) {
        require_once "{$controllersSource}";
    }
    else {
        throw new Exception('Failed to include class '.$className);
    }
});

require_once(ROOT.DS.'config'.DS.'config.php');