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

/**
 *  @DI\Service("claroline_lexicon.authusers")
 */
class AuthUsersManager
{

    /**
     * @var container
     */
    private $container;

    /**
     * @var even
     */
    private $even;

	/**
	 * @DI\InjectParams({
	 *     "container"    = @DI\Inject("service_container")
	 * })
	 */

	public function __construct($container)
    {

		$this->container = $container;
	}


	private function makePassword($currentUser)
    {

		$user     = $currentUser->getUsername();
		$password = md5($user);
		return $password;
	}

	public function generateAuth()
    {

		$currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
		if (is_string($currentUser)) {
            echo "<span class='alert alert-danger'>Vous n'êtes plus connecté ! Veuillez vous reconnecter pour continuer ! </span>\n";
        }else{
			$userProprieties              	  = array();
			$userProprieties['username']      = $currentUser->getUsername();
			$userProprieties['firstName']     = $currentUser->getFirstName();
			$userProprieties['LastName']      = $currentUser->getLastName();
			$userProprieties['email']         = $currentUser->getMail();
			$userProprieties['id']            = $currentUser->getId();
			$userProprieties['password']      = $currentUser->getPassword();
			$userProprieties['makepassword']  = $this->makePassword($currentUser);

			return $userProprieties;
		}
	}



}

