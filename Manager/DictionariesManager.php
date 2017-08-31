<?php


namespace Claroline\LexiconBundle\Manager;


/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiResources;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Bundle\TwigBundle\TwigEngine;


/**
 *  @DI\Service("claroline_lexicon.manager.dictionaries") 
 */

class DictionariesManager
{
   
    /**
     *  
     * @var users
     */
    public $users;

    /**
     * @var userClaro
     */
    public $userClaro;

    /**
     * @var userManager
     */
    public $userManager;

    /**
     * @var JBKusers
     */
    public $JBKusers;

    /**
     * @var ClaroUser
     */
    private $ClaroUser;
  
    /**
     * @var userResources 
     */
    public $userResources; 

    /**
     * @var userRightsResources
     */
    private $userRightsResources;

    /**
     * @var JBKresources
     */
    private $JBKresources;

    /**
     * @var userShareResources
     */
    private $userShareResources;


    /**
     * DictionariesManager constructor. 
     * 
     * @DI\InjectParams({
     *     "userClaro"    = @DI\Inject("claroline_lexicon.authusers"),
     *     "userManager"  = @DI\Inject("claroline_lexicon.manager.users"),
     *     "JBKresources" = @DI\Inject("claroline_lexicon.api.JibikiResources")
     * })
     */
    public function __construct($userClaro, $userManager, $JBKresources)
    {
        $this->JBKresources     = $JBKresources;
        $this->userClaro        = $userClaro;
        $this->userManager      = $userManager;
    }
 
    /**
     * Checks if a user have a login into JIBIKI. If not, his login is created. 
     * otherwise we load all its authorised data from JIBIKI 
     * 
     * @return $Resources (json data dictionaries)                
     */ 
    public function getAllUserResources()       
    {    
        $JBKusers      = $this->userManager->getAllJBKUsers();
        $ClaroUser     = $this->userClaro->generateAuth();
        $userslogin    = $JBKusers[1];  
        $clarousername = $ClaroUser['username'];   
        $claropass     = $ClaroUser['password'];
        if ($this->userManager->userloginExist($clarousername)) {
            $dico      = $this->JBKresources->get_all_dictionaries($clarousername, $claropass);
            $Resources = $this->serializeResources($dico); 
            return $Resources;
        }    
        else{     
            $message   = "<span class='alert alert-danger'> Vous n'avez pas un compte utilisateur sur la plateforme Jibiki. 
            Nous allons vous créer un rapidement ! </span>";
            echo $message;
            $this->userManager->createUser();
            $dico      = $this->JBKresources->get_all_dictionaries($clarousername, $claropass);
            $Resources = $this->serializeResources($dico); 
            return $Resources;
        }  
          
    }       
  
    /**
     * Create data format resources form JIBIKI for current Claroline user  
     * 
     * @return $resourcesjsondata (json data dictionaries and metadata)
     */ 
    public function serializeResources($resources)
    {    
        $resourcesjsondata = new \stdClass(); 
        $diconame          = array(); 
        $dicocontent       = array(); 
        foreach ($resources as $titledico => $dico) { 
            array_push($diconame, $titledico);
            $jsondico = $this->resourcesToJson($dico); 
            array_push($dicocontent, $jsondico);
        }
        $resourcesjsondata->totalResults         = count($diconame);
        $resourcesjsondata->questions            = array_map(function($n){return $n;}, $dicocontent);
        $resourcesjsondata->pagination           = new \stdClass();
        $resourcesjsondata->pagination->current  =  0;
        $resourcesjsondata->pagination->pageSize = -1; 
        $resourcesjsondata->sortBy               = new \stdClass(); 
        return json_encode((array) $resourcesjsondata, True); 
    } 
      
    /**
     * Create data format for each resources form JIBIKI
     * 
     * @return $resourcejsondata (json data dictionaries)    
     */
    public function resourcesToJson($dico) 
    {  
        //var_dump($dico->src[0]);
        $ClaroUser                           = $this->userClaro->generateAuth();
        $resourcejsondata                    = new \stdClass();
        $resourcejsondata->id                = $dico->name; 
        $resourcejsondata->type              = $dico->name;
        $resourcejsondata->lang              = $dico->src; 
        $resourcejsondata->title             = "";
        $resourcejsondata->category          = $dico->category;
        $resourcejsondata->content           = $dico->fullname;
        $resourcejsondata->userClaro         = $ClaroUser['username'];
        $resourcejsondata->meta              = new \stdClass(); 
        $resourcejsondata->meta->created     = $dico->creationDate;
        $resourcejsondata->meta->updated     = $dico->lastModifdate;
        $resourcejsondata->meta->model       = false;
        $resourcejsondata->meta->usedBy      = array();      
        $resourcejsondata->meta->sharedWith  = array();
        $resourcejsondata->description       = $dico->comments;
        $resourcejsondata->hints             = array();
        $resourcejsondata->meta->authors     = array();
        array_push($resourcejsondata->meta->authors, $this->author($dico)); 
        array_push($resourcejsondata->meta->sharedWith, $this->shareWith($dico));
        return $resourcejsondata;
    }

    /**
     * Create data format for active Claroline user  
     * 
     * @return $author (json data for active user)
     */ 
    public function author($dico)
    {
        $ClaroUser     = $this->userClaro->generateAuth();
        $author        = new \stdClass();
        $author->id    = (string) $ClaroUser['id'];
        $author->name  = $dico->owner;
        $author->email = $dico->owner.'@yahoo.fr';
        return $author;
    }
 
    /**
     * Create data format for shared user dictionaries  
     * 
     * @return $share (json data for shared user)
     */
    public function shareWith($dico)
    {
        $ClaroUser          = $this->userClaro->generateAuth();
        $share              = new \stdClass();
        $share->adminRights = false;
        $share->user        = new \stdClass();
        $share->user->id    = (string) $this->ClaroUser['id'];
        $share->user->name  = $dico->authors;
        $share->user->email = $dico->owner.'@yahoo.fr'; 
        return $share;
    }

   
    /**
     * Get properties of current login user from claroline
     * 
     * @return $userproperties (json format)
     */
    public function getCurrentUser()
    {
        $ClaroUser          = $this->userClaro->generateAuth();
        $currentuser        = new \stdClass();
        $currentuser->id    = $ClaroUser['id'];
        $currentuser->name  = $ClaroUser['firstName'].' '.$ClaroUser['LastName'];
        $currentuser->email = $ClaroUser['email'];
        return json_encode((array) $currentuser, True);
    } 


    /**
     * Get properties of current login user from claroline
     * 
     * @return $ResourceContent  (json format)
     */
    public function getContentResource($nameResource, $lang, $strategy)
    {
        $oooo                            = $this->JBKresources->get_volume_entries($nameResource, $lang, $strategy);
        //echo($oooo);
        $ResourceContent                 = new \stdClass();
        $ResourceContent->idname         = $nameResource;
        $ResourceContent->lang           = $lang;
        $ResourceContent->titleResource  = $nameResource;
        $ResourceContent->dataItems      = [];

        return json_encode((array) $ResourceContent, True);;
    } 


    /*
    public function getUserResources()
    {
        $right = $this->checkRights($this->JBKusers);

        return False;
    }

    public function getShareUserResources()
    {
        $right = $this->checkRights($this->user); 

        return False;
    }

    public function getPrivateUserResources()
    { 
        $right = $this->checkRights($this->user);

        return False;
    }*/


    /**
     * Checks the correct rights of the current user.
     * (not implemnted)
     */
    public function checkRights($user)
    {
        return False;
    }

   
   
}


