<?php

namespace App\Middleware;

/**
 * Class AuthMiddleware
 * @package App\Middleware
 */
class AuthMiddleware extends Middleware {

    /**
     * @param $request
     * @param $response
     * @param $next
     * @return mixed
     */
    public function __invoke($request, $response, $next) {
        
        // verification du droit de connection
        if(!$this->container->Auth->check()) 
        {
            $this->container->flash->addMessage('error', 'Veuillez vous connecter avant d\'avoir accès à la page !');
            return $response->withRedirect($this->container->router->pathFor('login'));
        }

     // verification du menu demandé
     $liste_url = array();
     $liste_url_online = array();
     $radical = '/sahges-paye/'; // quand je suis en local
     $radical_online = '/';  // quand je suis en ligne
     
     // recuperation de l'url demandé
     $url_request = parse_url($_SERVER['REDIRECT_URL'],PHP_URL_PATH); 

      $liste_url[]= 'dashboard';
      $liste_url_online[]= 'dashboard';
     
     // sousrepertoire
    /* foreach ($this->container->utilitaire->sousmenu_all() as $key => $value) 
     {
        $liste_url[]= $radical.$value['url'];
        $liste_url_online[]= $radical_online.$value['url'];
     }
      
      $droit = 'ok';
      
     if(!in_array($url_request,$liste_url) and !in_array($url_request,$liste_url_online))
     {
        $droit = 'ko'; 
     }

        
    $this->container->view->getEnvironment()->addGlobal('sys_acces', $droit); */
    $this->container->view->getEnvironment()->addGlobal('sys_acces', 'ok'); 
    $this->container->view->getEnvironment()->addGlobal('user_theme', 'classy'); 
    
     //Récupération du codemodule si défférent de null
    if($request->getParam('syscodemodule')!=null)
    {
        //Mette le codemodule récupéré en session
        $_SESSION["syscodemodule"]=$request->getParam('syscodemodule');
        $codemodule=$_SESSION["syscodemodule"];
    }
    else 
    {
        $codemodule=isset($_SESSION["syscodemodule"])?$_SESSION["syscodemodule"]:"";
    }
        
    //Récupération des menus et sousmenus du module courant
    $sousmenus=$this->container->MenuController->getUserSousmenus($codemodule);
    $menus=$this->container->MenuController->getUserMenus($codemodule);
    $this->container->view->getEnvironment()->addGlobal('sys_sousmenus', $sousmenus);
    $this->container->view->getEnvironment()->addGlobal('sys_menus', $menus);
   
    //return print_r($sousmenus);
    $response = $next($request, $response);
        return $response;
    }

}