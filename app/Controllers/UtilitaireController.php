<?php


namespace App\Controllers;

use App\Utilitaire\Controller;
use Slim\Http\UploadedFile;

/**
 * Class UserController
 * @package App\Controllers\User
 */
class UtilitaireController extends Controller
{

    Public function mail($destinaire,$subject,$body)
    {


       $this->mail->isSMTP();

       $this->mail->SMTPDebug = 2;

       $this->mail->Debugoutput = 'html';

       $this->mail->Host = 'smtp.gmail.com';

       $this->mail->Port = 587;

       $this->mail->SMTPSecure = 'tls';

       $this->mail->SMTPAuth = true;

       $this->mail->Username = "bellomouhoutassim@gmail.com";

       $this->mail->Password = "bafetimbi";               

       $this->mail->setFrom('bellomouhoutassim@gmail.com','VBG-OUT');
       $this->mail->addAddress($destinaire, 'CSP');
       $this->mail->isHTML(true);

       $this->mail->Subject = $subject;
       $this->mail->Body    = $body;


       if(!$this->mail->send()) 
       {
        $result =array("status"=>"error","message"=>"Message non envoyé");
                       // echo 'Message could not be sent.';
        return json_encode($result);
      } else {
        $result =array("status"=>"success","message"=>"Mail envoyé");
        return json_encode($result);
      }
    }

    Public function mailGroup($destinataires,$subject,$body)
    {

      $this->mail->isSMTP();

      $this->mail->SMTPDebug = 2;

            //Ask for HTML-friendly debug output
      $this->mail->Debugoutput = 'html';

            //Set the hostname of the mail server
      $this->mail->Host = 'smtp.gmail.com';

            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
      $this->mail->Port = 587;

            //Set the encryption system to use - ssl (deprecated) or tls
      $this->mail->SMTPSecure = 'tls';

            //Whether to use SMTP authentication
      $this->mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
      $this->mail->Username = "no.reply.gestionincidents@gmail.com";

            //Password to use for SMTP authentication
      $this->mail->Password = "Sgi@2019";               

      for($j=0; $j<sizeof($destinataires); $j++){
        $this->mail->addAddress($destinataires[$j], 'Client');
      }

      $this->mail->setFrom('no.reply.gestionincidents@gmail.com','Gestionnaires Incidents Informatiques');
            //$this->mail->addAddress($destinataires, 'Client');     // Add a recipient

            $this->mail->isHTML(true);                                  // Set email format to HTML

            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;


            if(!$this->mail->send()) 
            {
              $result =array("status"=>"error","message"=>"Message non envoyé");
               // echo 'Message could not be sent.';
              return json_encode($result);
            } else {
              $result =array("status"=>"success","message"=>"Mail envoyé");
              return json_encode($result);
            }
          }
    }

    Public function getWorkflow($listeEtapes,$listeWorkflows)
    {
        $workflows = array();

        foreach ($variable as $listeWorkflows) {
            foreach ($etape as $listeEtapes) {
                if ($etape['id']==$variable['idEtape']) {
                  $workflows[] = $etape;
                }
            }
             
        }
        return $workflows;
    }

}