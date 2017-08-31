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
use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiContentResource;
use JMS\DiExtraBundle\Annotation as DI;



/**
 *  @DI\Service("claroline_lexicon.api.JibikiResources") 
 */
class JibikiResources
{
    public  $base_api_uri = 'totoro.imag.fr/lexinnova/api/*';
	public  $header 	  = ['Content-Type' => 'application/xml;charset=UTF-8', 'Accept' => 'application/xml'];
	private $CLIENT_RESOURCES;

	public function __construct() {
		$this->CLIENT_RESOURCES = new Client([
        // Base URI is used with relative requests
        //'base_uri' => 'http://totoro.imag.fr/lexinnova/apiusers/',
        'base_uri' => $this->base_api_uri,
        'headers'  => $this->header
        ]);
	}


    public function get_volume_entries($dictname, $lang, $strategy)
    {
        $entries    = '';
        $urlRequest = $dictname.'/'.$lang.'/cdm-headword/a/';

        
        //echo ($requesto);
        $response = $this->CLIENT_RESOURCES->request('GET', $urlRequest, ['http_errors' => false, 'query' => ['strategy' => $strategy, 'sortBy' => 'asc']]);
        $code = $response->getStatusCode();
        if ($code != 200) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>JIBIKI REST API GET ENTRIES ERROR: $code $reason</p>\n";
        } else {
            $entries = simplexml_load_string((string) $response->getBody());
        }
        
        //var_dump($response->getBody()->getContents());
        return $entries;
    }


    public function get_volume($dictname, $lang)
    {
        $volume = '';
        $response = $this->CLIENT_RESOURCES->request('GET', $dictname.'/'.$lang, ['http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 200) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>JIBIKI REST API GET VOLUME ERROR: $code $reason</p>\n";
        } else {
            $volumexml = simplexml_load_string($response->getBody());
            $volume = JibikiContentResource::fromXML($volumexml);
        }
        #var_dump($volume);
        return $volume;
    }


	public function get_dictionary($dictname)
    {
        
        $answer = array();
        $response = $this->CLIENT_RESOURCES->request('GET', '', ['http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 200) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>JIBIKI REST API GET DICTLIST ERROR: $code $reason</p>\n";
        } else {
            $xml = (string) $response->getBody();
            $dictlist = simplexml_load_string($xml);
            foreach ($dictlist as $dictxml) {
                $dict = JibikiContentResource::fromXML($dictxml);
                foreach ($dict->src as $volumelang) {
                    $volume = $this->get_volume($dict->name, $volumelang);
                    $dict->volumes[$volumelang] = $volume;
                }
                $answer[$dict->name] = $dict;
            }
        
        } 

        return $answer;
    }


    public function get_all_dictionaries($user, $password)
    {
        $dict = '';
        $dictxml = '';
        $answer = array();
        $response = $this->CLIENT_RESOURCES->request('GET', '', ['http_errors' => false, 'auth' => [$user, $password]]);
        $code = $response->getStatusCode();
        if ($code != 200) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>JIBIKI REST API GET DICTLIST ERROR: $code $reason</p>\n";
        } else {
            $dictlist = simplexml_load_string($response->getBody());
            foreach ($dictlist as $dictxml) {
                $dict = JibikiContentResource::fromXML($dictxml);
                foreach ($dict->src as $volumelang) {
                    $volume = $this->get_volume($dict->name, $volumelang);
                    $dict->volumes[$volumelang] = $volume;
                }
                $answer[$dict->name] = $dict;
            }
        }
        return $answer;
    }


    public function post_volume($dictname, $src, $voldata, $user, $password)
    {
        $response = $this->CLIENT_RESOURCES->request('POST', $dictname.'/'.$src, ['body' => $voldata, 'auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>JIBIKI REST API POST VOLUME ERROR : $code $reason</p>\n";
            echo $response->getBody();
        }

        return $code;
    }


    public function put_volume($dictname, $src, $voldata, $user, $password)
    {
        $volume = '';
        $response = $this->CLIENT_RESOURCES->request('PUT', $dictname.'/'.$src, ['body' => $voldata, 'auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>JIBIKI REST API PUT VOLUME ERROR : $code $reason</p>\n";
        } else {
            $volumexml = simplexml_load_string($response->getBody());
            $volume = ContentResource::fromXML($volumexml);
        }

        return $volume;
    }


    public function delete_volume($dictname, $src, $voldata, $user, $password)
    {
        $response = $this->CLIENT_RESOURCES->request('DELETE', $dictname.'/'.$src, ['auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 204) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>JIBIKI REST API DELETE VOLUME ERROR : $code $reason</p>\n";
        }

        return $code;
    }


    public function create_resource($data, $user)
    {
        var_dump($data, $user);
        $response = $this->CLIENT_RESOURCES->request('POST', $dictname.'/'.$src, ['body' => $voldata, 'auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>JIBIKI REST API POST VOLUME ERROR : $code $reason</p>\n";
            echo $response->getBody();
        }

        return $code;
    }
    
}

