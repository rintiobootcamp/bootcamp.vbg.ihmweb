<?php

namespace App\Controllers;

use App\Utilitaire\Controller;
use App\Controllers\RestCurl;
use App\Controllers\UtilitaireController;

/**
 * Class problemeController
 * @package App\Controllers\User
 */
class AcceuilController extends Controller
{
    
    Public function index($request, $response){

    	return $this->view->render($response, 'index.twig');
    }

    Public function mapPage($request, $response){
    	return $this->view->render($response, 'map.twig');
    }

    Public function contact($request, $response){
    	return $this->view->render($response, 'contact.twig');
    }

    Public function envoiMail($request, $response){
    	$data['nom']=$request->getParam('nom');
        $data['message']=$request->getParam('message');
        $data['sujet']=$request->getParam('sujet');
        $user = "mboabello@yahoo.fr";

        $this->UtilitaireController->mail($user, $data['sujet'], $data['message']);
        
        return $this->view->render($response, 'index.twig');
    }

    Public function signin($request, $response){
    	return $this->view->render($response, 'signin.twig');
    }

    Public function validateSignin($request, $response){
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
        	return $this->view->render($response, 'index.twig');
        } 
    }

    Public function noterAction($request, $response){
    	$data['noteType']=$request->getParam('noteType');
    	$data['userId']=$_SESSION['id'];

        $URL = 'http://'.$this->serverPath.':7081/note/notes';
		$result = $this->RestCurl->post($URL, $data);
        return $this->view->render($response, 'index.twig');
    }

    Public function suivreAction($request, $response){
    	$data['reference']=$request->getParam('reference');

        $URL = 'http://'.$this->serverPath.':7082/plainte/plaintes/suivre/'.$data['reference'];
		$listeWorkflows = $this->RestCurl->get($URL, array());

		$URL2 = 'http://'.$this->serverPath.':7082/plainte/plaintes/etape';
		$listeEtapes = $this->RestCurl->get($URL2, array());

		$workflows = $this->UtilitaireController->getWorkflow($listeEtapes,$listeWorkflows);

        return $this->view->render($response, 'table/t_plainte.twig', array('workflows'=>$workflows, 'reference' => $data['reference']));
    }
     
}