<?php
// module liste disponible dans le fichier de configuration

foreach ($_liste_modules as $key => $value) 
{
    
    $controller = $value.'Controller';
    $nsController = '\\App\\Controllers\\'.$controller;
    
  $container[$controller] = function($container)use($nsController) {
    return new $nsController($container);
    }; 
 }

 // les classes utilitaires
 
 $UtilitaireList = ["Auth","RestCurl"];

foreach ($UtilitaireList as $key => $value) 
{
    
    $controller = $value;
    $nsController = '\\App\\Utilitaire\\'.$controller;
    
  $container[$controller] = function($container)use($nsController) {
    return new $nsController($container);
    }; 
 }
 
 