<?php


/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.  
 */ 
 

namespace Claroline\LexiconBundle\Manager;  

 
use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiUsers;
use JMS\DiExtraBundle\Annotation as DI;
use Claroline\LexiconBundle\Manager\AuthUsersManager;

  

/**
 *  @DI\Service("claroline_lexicon.manager.users")
 */
class DictionariesUsersManager
{

    /**
     * @var userResources
     */
    public $userResources;

     /**
     * @var JBKUsers
     */
    public $JBKUsers;

    /**
     * @var ClaroUser  
     */  
    private $ClaroUser;
 
    /**
     * @var userRightsResources
     */
    private $userRightsResources;

    /**
     * @var userShareResources
     */
    public $userShareResources; 
 

    /**
     * Dictionaries users Manager constructor.
     * 
     * @DI\InjectParams({
     *     "userClaro"   = @DI\Inject("claroline_lexicon.authusers"),
     *     "JBKUsers"    = @DI\Inject("claroline_lexicon.api.JibikiUsers")
     * })
     */
    public function __construct($userClaro, $JBKUsers) 
    {
        $this->JBKUsers   = $JBKUsers;
        $this->userClaro  = $userClaro;
    } 


    /**
     * Get current login user from claroline
     * 
     * @return $userproperties (to global variables)
     */ 
    public function getUriUser()
    {
        $ClaroUser   = $this->userClaro->generateAuth();
        $username    = $ClaroUser['username'];
        $email       = $ClaroUser['email'];
        $id          = $ClaroUser['id'];
        $password    = $ClaroUser['password'];
        $name        = $ClaroUser['firstName'].' '.$ClaroUser['LastName'];
        $result      = array();
        array_push($result, $username, $password, $name, $email, $id);
        return $result;
    }


    /**
     * Get properties of current login user from claroline
     * 
     * @return $userproperties (json format)
     */
    public function getCurrentUser()
    {
        $userInfo           = $this->getUriUser();
        $currentuser        = new \stdClass();
        $currentuser->id    = $userInfo[4];
        $currentuser->name  = $userInfo[2];
        $currentuser->email = $userInfo[3];
        return json_encode((array) $currentuser, True);
    } 


    /**
     * Get all JIBIKI Users from throught its API
     * 
     * @return array($usernames, $login) 
     */
    public function getAllJBKUsers()  
    {
        $userlogins     = array();
        $usernames      = array();
        $userslist      = array();
        $userslistjson  = json_decode($this->JBKUsers->get_userlist(),true);
        //var_dump($userslistjson);
       	foreach ($userslistjson['user-list']['user'] as $user){
       		foreach ($user as $name=>$login){
       			if ($name == 'login') {
       				array_push($userlogins, $login);
       			}else{
       				array_push($usernames, $login);
       			}
       		}
       	}
        
        return array($usernames, $userlogins);
    }

    /**
     * Check if the current claroline username exist in JIBIKI platform
     * 
     * @return Boolean (True or False) 
     */
    public function usernameExist($U)
    {
        $usernames  = $this->getAllJBKUsers()[0];
        foreach($usernames as $user) {
        	if($user == $U) {
        		return True;
        	}
        }
    }

    /**
     * Check if the current claroline login exist in JIBIKI platform
     * 
     * @return Boolean (True or False) 
     */
    public function userloginExist($U)
    {
        $userlogins   = $this->getAllJBKUsers()[1];
        foreach($userlogins as $user) {
        	if($user == $U) {
        		return True;
        	}
        }
    }

    /*
    public function userDictionries($U)
    {
        $logins     = $this->getAllJBKUsers()[1];
        foreach($userlogins as $user) {
        	if($user == $U) {
        		return True;
        	}
        }
    }


    public function getUser()
    {
        $right = $this->checkRights($this->user);

        return False;
    }*/

     
    /**
     * Check if the current claroline user exist in JIBIKI platform.
     * If not, we create a new user in JIBIKI with the same Claroline login.
     * 
     * @return message (success or non-success) 
     */
    public function createUser()
    {
        $userInfo = $this->getUriUser();
        if ($this->JBKUsers->post_user($userInfo[2], $userInfo[0], $userInfo[1], $userInfo[3])){
            echo "<span class='alert alert-success'> Votre compte utilisateur : '".$userInfo[0]."'  
            a bien été crée sur la plateforme Jibiki &#9786; </span>";
        }
        else{
            echo "<span class='alert alert-danger'> Votre compte utilisateur : '".$userInfo[0]."'  n'a pas pu être crée sur la plateforme Jibiki. 
            Veuillez vérifier la disponibilité de votre login ou réessayer plutard &#9785; </span>";
        }
    }








}
