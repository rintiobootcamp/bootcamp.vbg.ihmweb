<?php

namespace App\Controllers;

use App\Utilitaire\Controller;

/**
 * Class AuthController
 * @package App\Controllers\Auth
 */
class AuthController extends Controller{

    /**
     * @function index
     * @param $request
     * @param $response
     * @return mixed
     */
    public function index($request, $response)
    {
       return $this->view->render($response, 'form/f_login.twig');
    }



    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function authAction($request, $response) {

        $auth = $this->Auth->attempt(
            $request->getParam('login'),
            $request->getParam('password')
        );

        //return  print_r($auth);

        if (!$auth) {
            $this->flash->addMessage('error', 'Votre identifiant ou votre mot de passe est incorrect. Veuillez contacter l\'administrateur');
            return $response->withRedirect($this->router->pathFor('pauth.signin'));
        }
        $this->flash->addMessage('info', 'Utilisateur connecté');
        return $response->withRedirect($this->router->pathFor('acceuil'));
    }

     /**
     * @param $request
     * @param $response
     * @return mixed
     */
     public function logout($request,$response)
     {
        unset($_SESSION);
        session_destroy();
        return $response->withRedirect($this->router->pathFor('login'));

    }

}
