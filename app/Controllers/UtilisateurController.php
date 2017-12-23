<?php

namespace App\Controllers;

use App\Utilitaire\Controller;
use App\Controllers\RestCurl;

/**
 * Class BanqueController
 * @package App\Controllers\User
 */
class UtilisateurController extends Controller
{
     /**
     * @function index
     * @param $request
     * @param $response
     * @return mixed
     */
    //Retourner la liste des 100 premères départements par décroissant de l'ID
    Public function indexAction($request, $response)
    {
        $URL = 'http://'.$this->serverPath.':7085/login/users';
        $utilisateurs = $this->RestCurl->get($URL, array());

        return $this->view->render($response, 'table/t_utilisateur.twig', array('utilisateurs'=>$utilisateurs));
    }
    
     /**
     * @function showAction
     * @param $request
     * @param $response
     * @return mixed
     */
    //Afficher une departement en édition
    Public function showAction($request, $response)
    {
        $URL = 'http://'.$this->serverPath.':7085/login/users/'.$request->getParam('id');
        $utilisateur = $this->RestCurl->get($URL, array());

        if($utilisateur==null)
        {
            $this->flash->addMessage('error','L\'utilisateur demandé n\'existe pas.');
        }
        else
        {
            $entete= "Modification de ".$utilisateur["nom"];
            $action="Modifier";
            return $this->view->render($response, 'form/f_utilisateur.twig', 
              array("current"=>$utilisateur,"entete"=>$entete, "action"=>$action)); 
        }
    }

    
     /**
     * @function createAction
     * @param $request
     * @param $response
     * @return mixed
     */
    
    Public function formAction($request, $response)
    {
        
    }
    
     /**
     * @function newAction
     * @param $request
     * @param $response
     * @return mixed
     */
    
    Public function newAction($request, $response)
    {
        $data['role']=$request->getParam('role');
        $data['nom']=$request->getParam('nom');
        $data['email']=$request->getParam('email');
        $data['numero']=$request->getParam('numero');
        $data['login']=$request->getParam('login');
        $data['password']=$request->getParam('password');
        $data['dateCreation']=date('Y-m-d G:i:s');
        $data['dateMiseAJour']=date('Y-m-d G:i:s');
        $passVerif=$request->getParam('password-verify');

        if ($data['password']!=$passVerif) {
           $this->flash->addMessage('error', 'Votre mot de passe est incorrect. Veuillez réessayez.');
           return $this->view->render($response, 'signin.twig');
        }
        else{
            $URL = 'http://'.$this->serverPath.':7085/login/users';
            $result = $this->RestCurl->post($URL, $data);
            $this->flash->addMessage('success','utilisateur enregistré avec succès');
            return $response->withRedirect($this->router->pathFor('acceuil'));
        }
    }

     /**
     * @function editAction
     * @param $request
     * @param $response
     * @return mixed
     */
    
    Public function editAction($request, $response)
    {
        $data['role']=$request->getParam('role');
        $data['nom']=$request->getParam('nom');
        $data['email']=$request->getParam('email');
        $data['numero']=$request->getParam('numero');
        $data['login']=$request->getParam('login');
        $data['password']=$request->getParam('password');
        $data['dateCreation']=date('Y-m-d G:i:s');
        $data['dateMiseAJour']=date('Y-m-d G:i:s');
        $passVerif=$request->getParam('password-verify');

        if ($data['password']!=$passVerif) {
           $this->flash->addMessage('error', 'Votre mot de passe est incorrect. Veuillez réessayez.');
           return $this->view->render($response, 'signin.twig');
        }
        else{
            $URL = 'http://'.$this->serverPath.':7085/login/users';
            $result = $this->RestCurl->put($URL, $data);
            $this->flash->addMessage('success','utilisateur modifié avec succès');
            return $response->withRedirect($this->router->pathFor('acceuil'));
        }
    }
        
      /**
     * @function deleteAction
     * @param $request
     * @param $response
     * @return mixed
     */
    
    Public function deleteAction($request, $response)
    {
        $this->db->update("utilisateur", ["iscanceled"=>"t"], ["id"=>$request->getParam('id')]);
        
         if($this->db->error()[0]=="00000")
        {
            $this->flash->addMessage('success','utilisateur mise à jour avec succès');
        } 
        else 
        {
            $this->flash->addMessage('error','Une erreur est survenue lors de la mise à jour.');
        }
            return $response->withRedirect($this->router->pathFor('utilisateur.liste'));
        
    } 

}