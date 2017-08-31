<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\LexiconBundle\Controller\openResources;


use Claroline\CoreBundle\Entity\Group;
use Claroline\CoreBundle\Entity\User;
use Claroline\CoreBundle\Entity\Workspace\Workspace;
use Claroline\CoreBundle\Library\Security\Utilities;
use Claroline\CoreBundle\Manager\GroupManager;
use Claroline\CoreBundle\Manager\MailManager;
use Claroline\CoreBundle\Manager\UserManager;
use Claroline\CoreBundle\Manager\WorkspaceManager;
use Claroline\CoreBundle\Pager\PagerFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DesktopLexiconController extends Controller
{
    
    /**
     * @EXT\Route(
     *     "/content/{type}/{nameResource}/{lang}/{author}",
     *     name="lexicon_content",
     *     requirements={
     *        "type" : "[\w]*",
     *        "nameResource" : "[\w]+",
     *        "lang" : "[\w]+",
     *        "author" : "[\w]*"
     *     }
     * )
     * @EXT\Method("GET")
     * @EXT\Template("ClarolineLexiconBundle:content-resource.html.twig")
     */
    
    public function indexContent($nameResource, $lang)
    {
        //echo($nameResource);
        $user         = $this->container->get('claroline_lexicon.manager.users')->getCurrentUser();
        $data_content = $this->container->get('claroline_lexicon.api.JibikiResources')->get_volume_entries($nameResource, $lang, 'GREATER_THAN_OR_EQUAL');
        return $this->render('ClarolineLexiconBundle:Pages:content-resource.html.twig', array(
            'data' => $data_content, 
            'active_user' => $user,
            'resourceName' => $nameResource
            )
        );
    }

    /**
     * Create new lexicale resource for users.
     *
     * @EXT\Route("/create", name="lexicon_create_new_resource")
     * @EXT\Method("POST")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createNewResource(Request $request)
    {
        $errors = [];

        $data = $this->decodeRequestData($request);
        $user = $this->container->get('claroline_lexicon.manager.users')->getCurrentUser();
        
        $new_resource = $this->container->get('claroline_lexicon.api.JibikiResources')->create_resource($data, $user);


        if (empty($data)) {
            $errors[] = [
                'path' => '',
                'message' => 'Invalid JSON data.',
            ];
        } else {
            try {
                $this->shareManager->share($data, $user);
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }

        if (!empty($errors)) {
            return new JsonResponse($errors, 422);
        } else {
            return new JsonResponse(null, 201);
        }
    }

}
