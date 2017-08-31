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
 *  @DI\Service("claroline_lexicon.api.JibikiContentResource") 
 */
class JibikiContentResource
{
    public  $base_api_uri = 'http://totoro.imag.fr/lexinnova/api';
    public  $header       = ['Content-Type' => 'application/xml;charset=UTF-8', 'Accept' => 'application/xml'];
    //public $guzzleclient  = new Client(['base_uri' => $base_api_uri, 'headers'  => $header]);
    public $name;
    public $fullname;
    public $category;
    public $type;
    public $owner;
    public $homepage;
    public $creationDate;
    public $installationDate;
    public $contents;
    public $domain;
    public $source;
    public $authors;
    public $legal; 
    public $access;
    public $comments;
    public $administrators = array();
    public $src = array();
    public $trg = array();
    public $xslSheet;
    public $volumes = array();
    public $xml;
    public $instance;
    private $RESOURCE_CONTENT;
  
  /*
    public function __construct()
    {
        $this->name = $name;
        $this->category = $category;
        $this->type = $type;
        $this->authors = $authors;
        $this->RESOURCE_CONTENT = new Client(['base_uri' => $base_api_uri, 'headers'  => $header]);
    }*/

    public function __construct()
    {
        $this->RESOURCE_CONTENT = new Client(['base_uri' => $this->base_api_uri, 'headers'  => $this->header]);
    }


    public static function withID($id)
    {
        $instance = new self();
        $instance->loadByID($id);

        return $instance;   
    }


    public function get_entries($dictname, $strategy)
    {
        $article = '';
        //Lexinnova/esp/cdm-headword/a/?strategy=GREATER_THAN OR EQUAL
        //echo 'url:',JIBIKI_API, $dictname . '/' . $src.'/'.$key.'/'.$value.'/entries'; et moi 
        $response = $this->RESOURCE_CONTENT->request('GET', '/Lexinnova/esp/cdm-headword/a/', ['query' => ['strategy' => $strategy], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 200) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>JIBIKI REST API GET ENTRIES ERROR: $code $reason</p>\n";
        } else {
            $article = simplexml_load_string($response->getBody());
        }

        return $article;
    }


    public function get_articlesold($dictname, $src, $key, $value, $strategy)
    {
        $article = '';
        //echo 'url:',JIBIKI_API, $dictname . '/' . $src.'/'.$key.'/'.$value.'/entries'; et moi 
        $response = $this->RESOURCE_CONTENT->request('GET', $dictname.'/'.$src.'/'.$key.'/'.$value.'/entries', ['query' => ['strategy' => $strategy], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 200) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>REST API GET ARTICLE ERROR: $code $reason</p>\n";
        } else {
            $article = simplexml_load_string($response->getBody());
        }

        return $article;
    }


    public function post_article($dictname, $src, $articleid, $articledata, $user, $password)
    {
        $article = '';
        $response = $this->RESOURCE_CONTENT->request('POST', $dictname.'/'.$src.'/'.$articleid, ['body' => $articledata, 'auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>REST API POST ARTICLE ERROR: $code $reason</p>\n";
        } else {
            $article = simplexml_load_string($response->getBody());
        }

        return $article;
    }

    public function put_article($dictname, $src, $articleid, $articledata, $user, $password)
    {
        $article = '';
        $response = $this->RESOURCE_CONTENT->request('PUT', $dictname.'/'.$src.'/'.$articleid, ['body' => $articledata, 'auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>REST API PUT ARTICLE ERROR: $code $reason</p>\n";
        } else {
            $article = simplexml_load_string($response->getBody());
        }

        return $article;
    }

    public function put_article_part($dictname, $src, $contributionid, $xpath, $value, $user, $password)
    {
        $article = '';
        $response = $this->RESOURCE_CONTENT->request('PUT', $dictname.'/'.$src.'/'.$contributionid.'/'.$value, ['body' => $xpath, 'auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>REST API PUT ARTICLE PART ERROR: $code $reason</p>\n";
        } else {
            $article = simplexml_load_string($response->getBody());
        }

        return $article;
    }

    public function delete_article($dictname, $src, $articleid, $user, $password)
    {
        $response = $this->RESOURCE_CONTENT->request('DELETE', $dictname.'/'.$src.'/'.$articleid, ['auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 204) {
            $reason = $response->getReasonPhrase();
            echo "<p class='alert alert-danger'>REST API DELETE ARTICLE ERROR: $code $reason</p>\n";
        } else {
            echo "<p> L'article $dictname a bien été supprimé !</p>";
        }

        return $code;
    }

    public static function fromData($name, $category, $type, $authors)
    {
        $shortname = preg_replace('/[^A-Za-z0-9\-]/', '', $shortname);
        if (!preg_match('/^[A-Z][a-zA-Z0-9\-]+$/', $shortname)) {
            echo '<p class="alert alert-danger">','Le nom abrégé du dictionnaire contient des caractères non autorisés !','</p>';
        }
        $instance = new self($shortname, $category, $type, $authors);
        $instance->fullname = $name;
        $instance->creationDate = date('c');
        $instance->owner = $authors;
        array_push($instance->administrators, $name);
        $instance->access = 'private';

        return $instance;
    }


   
    public function fromXML($xmldata)
    {
        $instance = new self((string) $xmldata->{'dictionary-metadata'}['name'], (string) $xmldata->{'dictionary-metadata'}['category'], (string) $xmldata->{'dictionary-metadata'}['type'], (string) $xmldata->{'dictionary-metadata'}->authors);
        $instance->xml = $xmldata->{'dictionary-metadata'};
        $instance->fullname = (string) $instance->xml['fullname'];
        $instance->name = (string) $instance->xml['name'];
        $instance->owner = (string) $instance->xml['owner'];
        $instance->lastModifdate = (string) $instance->xml['last-modification-date'];
        $instance->createdate = (string) $instance->xml['creation-date'];
        $instance->homepage = (string) $instance->xml['homepage'];
        $instance->creationDate = (string) $instance->xml['creation-date'];
        $instance->installationDate = (string) $instance->xml['installation-date'];
        $instance->contents = (string) $instance->xml->contents;
        $instance->domain = (string) $instance->xml->domain;
        $instance->source = (string) $instance->xml->source;
        $instance->legal = (string) $instance->xml->legal;
        $instance->access = (string) $instance->xml->access || 'private';
        $instance->comments = (string) $instance->xml->comments;
        
        //var_dump($instance->source);
        //echo var_dump($instance->xml->administrators);
        $admin = $instance->xml->administrators;
        if (isset($admin)) {
            foreach ($admin->{'user-ref'} as $user) {
               array_push($instance->administrators, (string) $user['name']);
               #echo($user['name']);
            }
        }else {
            echo($admin['name']);
            array_push($instance->administrators, (string) $admin['name']);
        }
        //var_dump($instance->administrators);
        $srclangs = array();
       // echo $instance->xml->languages->children();
       
        $langsrc = $instance->xml->languages;
        if (isset($langsrc)) {
            foreach ($langsrc->{"source-language"} as $srclangXML) {
                $d = $srclangXML->attributes('d', true);
                $langsrc = (string) $d['lang'];
                array_push($instance->src, $langsrc);
            }
        } else {
            array_push($instance->src, $langsrc['source-language']);
        }

        $langtg = $instance->xml->languages;
        if (isset($langtg)) {
            foreach ($langtg->{"target-language"} as $trglangXML) {
                $d = $trglangXML->attributes('d', true);
                $lang = (string) $d['lang'];
                array_push($instance->trg, $lang);
            } 
        } else {
            array_push($instance->trg, $langtg['target-language']);
        }

        $ns_stylesheet = $xmldata->children('http://www.w3.org/1999/XSL/Transform');
        if (!empty($ns_stylesheet)) {
            $instance->xslSheet = $ns_stylesheet->stylesheet->asXML();
        }
        

        return $instance;
    }


    public function XML2Array($xml) 
    { 
        $array = simplexml_load_string ($xml); 
        $newArray = array( ) ; 
        $array = (array)$array ; 
        foreach ($array as $key => $value) 
        { 
            $value = (array)$value ; 
            $newArray[$key] = $value[0] ; 
        } 
        $newArray = array_map("trim", $newArray); 
        return $newArray ; 
    } 


    public function __clone()
    {
        $this->creationDate = date('c');
        $this->xml{'creation-date'} = $this->creationDate;
        $this->installationDate = date('c');
        $this->xml{'installation-date'} = $this->installationDate;
        $c = count($this->volumes);
        foreach ($this->src as $src) {
            $this->volumes[$src] = clone $this->volumes[$src];
        }
    }

    public function addVolume($volume)
    {
        $volumes[$volume->src] = $volume;
    }

    public function setAuthor($author)
    {
        $this->authors = $author;
        $this->xml->authors = $author;
        $this->owner = $author;
        $this->xml['owner'] = $author;
        $this->administrators = array();
        array_push($this->administrators, $author);
        $adm = $this->xml->administrators;
        // il peut y avoir plusieurs admin
        unset($adm->{'user-ref'}[0]);
        $userref = $adm->addChild('user-ref');
        $userref->addAttribute('name', $author);
        foreach ($this->src as $src) {
            $this->volumes[$src]->setAuthor($author);
        }
    }

    public function setName($name)
    {
        $shortname = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
        if (!preg_match('/^[A-Z][a-zA-Z0-9\-]+$/', $shortname)) {
            echo '<p class="alert alert-danger">','Le nom abrégé du dictionnaire contient des caractères non autorisés !','</p>';
        }
        $this->fullname = $name;
        $this->xml['fullname'] = $name;
        $this->name = $shortname;
        $this->xml['name'] = $shortname;
        foreach ($this->src as $src) {
            $this->volumes[$src]->setNameFromDict($name);
        }
    }

    public function save($user, $password)
    {
        $this->lastModificationDate = date('c');
        $body = '<d:dictionary-metadata-files  xmlns:d="http://www-clips.imag.fr/geta/services/dml">';
        $body .= $this->xml->asXML();
        if (!empty($this->xslSheet)) {
            $body .= $this->xslSheet;
        }
        $body .= '</d:dictionary-metadata-files>';
        $code = post_dictionnaire($this->name, $body, $user, $password);
        // dictionary already existing
        if ($code == 409) {
            $code = put_dictionnaire($this->name, $body, $user, $password);
        }
        foreach ($this->src as $src) {
            $code = $this->volumes[$src]->save($this->name, $user, $password);
        }

        return $code;
    }

    public function __toString()
    {
        return $this->name.'<pre>'.htmlspecialchars($this->xml->asXML()).'</pre>';
    }



   
}

