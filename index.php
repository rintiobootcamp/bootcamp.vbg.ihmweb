<?php

//__ gestion des erreurs
ini_set('display_errors','on');
ini_set('session.gc_maxlifetime', 36000);
error_reporting(E_ALL);

require __DIR__ . '/boot/kernel.php';

$app->run();
