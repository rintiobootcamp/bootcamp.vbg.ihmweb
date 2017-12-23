<?php

use \App\Middleware\AuthMiddleware;
use \App\Middleware\GuestMiddleware;

// Page de connexion
$app->get('/', 'AcceuilController:index')->setName('acceuil');

$app->group('', function() use ($app) {
        $this->post('/authentification','AuthController:authAction')->setName('auth');
        $this->get('/logout','AuthController:logout')->setName('logout');
       // $this->post('/login','AuthController:authAction')->setName('pauth.signin');
        $this->get('/login','AuthController:index')->setName('pauth.signin');
        $this->get('/error','AuthController:error')->setName('error');
        $this->get('/contact', 'AcceuilController:contact')->setName('contact');
        $this->get('/signin', 'AcceuilController:signin')->setName('signin');
        $this->get('/map', 'AcceuilController:mapPage')->setName('map');
        $this->post('/envoi','AcceuilController:envoiMail')->setName('envoi');
        $this->post('/validate','AcceuilController:validateSignin')->setName('validate');
        $this->post('/noter','AcceuilController:noterAction')->setName('noter');
        $this->post('/suivre','AcceuilController:suivreAction')->setName('suivre');
        $this->get('/test', 'TestController:testAction')->setName('test');
        $this->get('/plainte.form', 'PlainteController:formAction')->setName('plainte.form');
        $this->get('/plainte.liste', 'PlainteController:indexAction')->setName('plainte.liste');
        $this->post('/plainte.create', 'PlainteController:newAction')->setName('plainte.create');
        $this->post('/plainte.etape', 'PlainteController:etapeAction')->setName('plainte.etape');
        $this->post('/plainte.etat', 'PlainteController:etatAction')->setName('plainte.etat');
        
})->add(new GuestMiddleware($container));


//__ Page dont l'authentification est requise
$app->group('', function() use ($app,$_liste_modules) {
    $this->get('/dashboard','AuthController:getPanel')->setName('panel'); // avoir le panneau des modules
    
    // Liste des routes standards
    foreach ($_liste_modules as $key => $value)
    {
        $this->get('/'.strtolower($value).'/form',$value.'Controller:formAction')->setName(strtolower($value).'.form'); // Avoir le formulaire des utilisateurs
        $this->post('/'.strtolower($value).'/create',$value.'Controller:newAction')->setName(strtolower($value).'.create'); // Créer utilisateur renvoi user.liste
        $this->post('/'.strtolower($value).'/edit',$value.'Controller:editAction')->setName(strtolower($value).'.edit'); // modifier l'utilisateur
        $this->get('/'.strtolower($value).'/liste',$value.'Controller:indexAction')->setName(strtolower($value).'.liste'); // avoir la liste des utilisateurs
        $this->get('/'.strtolower($value).'/show',$value.'Controller:showAction')->setName(strtolower($value).'.show'); // Voir l'utilisateur
        $this->get('/'.strtolower($value).'/search',$value.'Controller:searchAction')->setName(strtolower($value).'.search'); // Faire des recherches dans la table
        $this->get('/'.strtolower($value).'/delete',$value.'Controller:deleteAction')->setName(strtolower($value).'.delete'); // Faire suppressions logiques
        $this->get('/'.strtolower($value).'/report',$value.'Controller:reportAction')->setName(strtolower($value).'.report'); // 
        $this->get('/'.strtolower($value).'/reportexcel',$value.'Controller:reportExcelAction')->setName(strtolower($value).'.reportexcel'); //
    }
    
    //$this->get('/test','TestController:testAction')->setName('test'); // avoir
    $this->get('/courrier/listeclient','CourrierController:indexclientAction')->setName('courrier.listeclient'); //
    $this->get('/courrier/listeadministratif','CourrierController:indexadministratifAction')->setName('courrier.listeadministratif'); //
    $this->get('/courrier/getcourriers','CourrierController:ajax_getCourriers')->setName('courrier.getcourriers');
    $this->post('/corbeille/addcourriers','CorbeilleController:addcourriersAction')->setName('corbeille.addcourriers');
    $this->get('/corbeille/affiche','CorbeilleController:afficheAction')->setName('corbeille.affiche');
    $this->get('/transmission/unique','TransmissionController:transmissionAction')->setName('transmission.unique');
    $this->get('/transmission/accuser','TransmissionController:accuserAction')->setName('transmission.accuser');
    
})->add(new AuthMiddleware($container));

