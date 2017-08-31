<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\LexiconBundle\Controller\API\Jibiki;

 
use GuzzleHttp\Client;
use JMS\DiExtraBundle\Annotation as DI;



/**
 *  @DI\Service("claroline_lexicon.api.JibikiUsers") 
 */
class JibikiUsers 
{
	public  $base_api_uri = 'http://totoro.imag.fr/lexinnova/apiusers/';
	public  $header 	  = ['Content-Type' => 'application/json;charset=UTF-8', 'Accept' => 'application/json'];
	private $CLIENT_USER;

	public function __construct() {
		$this->CLIENT_USER = new Client([
        // Base URI is used with relative requests
        //'base_uri' => 'http://totoro.imag.fr/lexinnova/apiusers/   http://pc-mangeot.imag.fr:8999/apiusers/',
        'base_uri' => $this->base_api_uri,
        'headers'  => $this->header
        ]);
	}

	public function post_user($name, $login, $password, $email)
    {
        $userjsondata              = new \stdClass();
        $userjsondata->user        = new \stdClass();
        $userjsondata->user->name  = $name;
        $userjsondata->user->login = $login;
        $userjsondata->user->email = $email;
        $userjsondata = (string) json_encode((array) $userjsondata);
        $response = $this->CLIENT_USER->request('POST', 'users/' .$login, ['body' => $userjsondata, 'auth' => [$login, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<span class='alert alert-danger'>REST API DELETE DICT ERROR: $code $reason</span>";
            return False;
    	}else {
        	return True; 
        } 
    } 


    public function delete_user($user, $password)
    {
        $response = $this->CLIENT_USER->request('DELETE', 'users/' . $user, ['auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();

        if ($code != 204) {
            $reason = $response->getReasonPhrase();
            echo "<span class='alert alert-danger'>REST API DELETE DICT ERROR: $code $reason</span>";
        }else {
        	$message = $code."<span className='alert alert-success'>L'utilisateur : ".$name."a bien été supprimé!</span>";
        	return $message; 
        }
    }

 	public function get_userlist()
    {
        $userlist = array();
        $response = $this->CLIENT_USER->request('GET', 'users', ['http_errors' => false]);
        $code = $response->getStatusCode();
        $body = (string) $response->getBody();
    
        $reason = $response->getReasonPhrase();
        if ($code != 200) {
            echo "<span class='alert alert-danger'>REST API POST USER ERROR: $code $reason</span>\n";
        }

        return $body;
    }


}
