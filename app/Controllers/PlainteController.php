<?php

namespace App\Controllers;

use App\Utilitaire\Controller;
use App\Controllers\RestCurl;
use App\Controllers\UtilitaireController;

/**
 * Class problemeController
 * @package App\Controllers\User
 */
class PlainteController extends Controller
{
    /**
     * @function index
     * @param $request
     * @param $response
     * @return mixed
     */
    Public function indexAction($request, $response)
    {
        $URL = 'http://'.$this->serverPath.':7082/plainte/plaintes';
        $plaintes = $this->RestCurl->get($URL, array());

        $URL2 = 'http://'.$this->serverPath.':7082/plainte/plaintes';
        $etapes = $this->RestCurl->get($URL2, array());

        //return print_r($plaintes);
        
        return $this->view->render($response, 'table/t_plainteListe.twig', array('plaintes'=>$plaintes, 'etapes'=>$etapes));
    }


    /**
     * @function etape
     * @param $request
     * @param $response
     * @return mixed
     */
    Public function etapeAction($request, $response)
    {
        $idPlainte = $request->getParam('idPlainte');
        $idEtape = $request->getParam('idEtape');

        $URL = 'http://'.$this->serverPath.':7082/plainte/plaintes/'.$idPlainte.'/'.$idEtape;

        $plainte = $this->RestCurl->post($URL, array());

        return $response->withRedirect($this->router->pathFor('acceuil'));
    }

    /**
     * @function etat
     * @param $request
     * @param $response
     * @return mixed
     */
    Public function etatAction($request, $response)
    {
        $idPlainte = $request->getParam('idPlainte');

        $URL = 'http://'.$this->serverPath.':7082/plainte/plaintes/valider/'.$idPlainte;

        $plainte = $this->RestCurl->post($URL, array());

        return $response->withRedirect($this->router->pathFor('acceuil'));
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
        $URL = 'http://'.$this->serverPath.':7082/plainte/plaintes/'.$request->getParam('id');

        $plainte = $this->RestCurl->get($URL, array());

        if($plainte==null)
        {
            $this->flash->addMessage('error','La plainte demandée n\'existe pas.');
        }
        else
        {
            $entete= "Modification de ".$plainte["nom"];
            $action="Modifier";
            return $this->view->render($response, 'form/f_plainte.twig', 
              array("current"=>$plainte,"entete"=>$entete, "action"=>$action)); 
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
        $current=  array();
        $entete="Enregistrement d'une nouvele plainte";
        return $this->view->render($response,'form/f_plainte.twig',
              array("current"=>$current,"entete"=>$entete, "action"=>$action));
    }
    
     /**
     * @function newAction
     * @param $request
     * @param $response
     * @return mixed
     */
    
    Public function newAction($request, $response)
    {
        $data['plaignantPhone']=$request->getParam('plaignantPhone');
        $data['plaignantEmail']=$request->getParam('plaignantEmail');
        $data['contenu']=$request->getParam('contenu');
        $data['longitude']=$request->getParam('longitude');
        $data['latitude']=$request->getParam('latitude');
        //$data['longitude']=0;
        //$data['lattitude']=0;
        $data['dateCreation']=date('Y-m-d G:i:s');
        $data['dateMiseAJour']=date('Y-m-d G:i:s');

        return print_r($data);

        $URL = 'http://'.$this->serverPath.':7082/plainte/plaintes';

        $plainte = $this->RestCurl->post($URL, $data);

        return $response->withRedirect($this->router->pathFor('acceuil'));
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
        
        
        $this->db->update("plainte", $data, ["id"=>$request->getParam('id')]);
        
        if($this->db->error()[0]=="00000")
        {
       
            $this->flash->addMessage('success','plainte mise à jour avec succès');
            return $response->withRedirect($this->router->pathFor('plainte.liste'));
        } 
        else 
        {
            $this->flash->addMessage('error','Une erreur est survenue lors de la mise à jour.');
            return $response->withRedirect($this->router->pathFor('plainte.form'));
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
        $this->db->update("plainte", ["iscanceled"=>"t"], ["id"=>$request->getParam('id')]);
        
         if($this->db->error()[0]=="00000")
        {
            $this->flash->addMessage('success','plainte mise à jour avec succès');
        } 
        else 
        {
            $this->flash->addMessage('error','Une erreur est survenue lors de la mise à jour.');
        }
            return $response->withRedirect($this->router->pathFor('plainte.liste'));
        
    }
}