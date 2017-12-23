<?php

namespace App\Utilitaire;

//use App\Models\User;

use App\Utilitaire\Controller;
use App\Controllers\RestCurl;



/**
 * Class Auth
 * @package App\Auth
 */
class Auth extends Controller {

    /**
     * @function attempt
     * @param $login
     * @param $password
     * @return bool
     * Connecte l'personnel si l'email et le password corresponde
     */
    public function attempt($login, $password)
    {
        $user = array();

        $URL = 'http://'.$this->serverPath.':8082/login/users/'.$login.'/'.$password;
        $result = $this->RestCurl->post($URL, array());

        // definition des variables en session
        if($result)
        {
            $URL = 'http://'.$this->serverPath.':8082/login/users/'.$login.'/'.$password;
            $resultat = $this->RestCurl->post($URL, array());

            foreach ($variable as $resultat) {
                if ($variable['login']==$login && $variable['password']==$password){
                    $user = $variable;
                }
            }

            $_SESSION['id']=$user["id"];
            $_SESSION['login']=$user["login"];
            $_SESSION['nom']=$user["nom"];
            $_SESSION['email']=$user["email"];
            $_SESSION['numero']=$user["numero"];

        }
        return $result;

    }

}
