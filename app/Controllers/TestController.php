<?php

namespace App\Controllers;

use App\Utilitaire\Controller;
use App\Controllers\RestCurl;
use App\Controllers\UtilitaireController;

/**
 * Class problemeController
 * @package App\Controllers\User
 */
class TestController extends Controller
{
    
    Public function testAction($request, $response){
  //   	// Get cURL resource
		// $curl = curl_init();
		// // Set some options - we are passing in a useragent too here
		// curl_setopt_array($curl, array(
		//     CURLOPT_RETURNTRANSFER => 1,
		//     CURLOPT_URL => 'http://'.$this->serverPath.':8083/commentaire/commentaires/PROJET/7',
		//     CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		// ));
		// // Send the request & save response to $resp
		// $resp = json_decode(curl_exec($curl), true);
		// // Close request to clear up some resources
		// curl_close($curl);

		$URL = 'http://'.$this->serverPath.':8083/commentaire/commentaires/PROJET/7';

		$result = $this->RestCurl->get($URL, array());

    	return print_r($result);
    }
     
}