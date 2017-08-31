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
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\DiExtraBundle\Annotation as DI;



class LexiconController extends Controller
{

    /**
     * @EXT\Route(
     *     "/{path}",
     *     name="lexicon_home",
     *     requirements={
     *        "path": "home"
     *     }
     * )
     * @EXT\Method("GET")
     * @EXT\Template("ClarolineLexiconBundle:Pages:home.html.twig")
     */
    
    public function indexHome()
    {
        $user         = $this->container->get('claroline_lexicon.manager.users')->getCurrentUser();
        $data_content = $this->container->get('claroline_lexicon.manager.dictionaries')->getAllUserResources();

        return $this->render('ClarolineLexiconBundle:Pages:home.html.twig', array('data' => $data_content, 'active_user' => $user));
    }

    /**
     * @EXT\Route(
     *     "/{typeResource}/{idResource}",
     *     name="lexicon_consult",
     *     requirements={
     *        "idResource" : "\d+\w+",
     *        "typeResource" : "dictionary|glossary"
     *      }
     * )
     * @EXT\Method("GET")
     * Displays the message form with the "to" field filled with users of a group.
     */
    public function freeConsultResource($typeResource, $idResource)
    {
       return $this->render('ClarolineLexiconBundle:Pages:content-resource.html.twig');
    }



}











//$user = '{"id":"3","name":"MBONING Elvis","email":"juslestawo@yahoo.fr"}';
        //$data_content = '{"totalResults":5,"questions":[{"random":false,"multiple":false,"choices":[{"type":"text\/html","data":"le lexique","id":"b6a240e4-9db1-4b6d-b818-319e3389b658"},{"type":"text\/html","data":"la langue","id":"4d4c2648-522f-4323-b10d-91d183400424"},{"type":"text\/html","data":"le dictionnaire","id":"7d79e2b5-9072-4841-82e4-d4fdf69e2f4d"},{"type":"text\/html","data":"le corpus","id":"67cfadfa-bee4-4df6-93a1-de57350cd763"},{"type":"text\/html","data":"les glossaires","id":"21ffdcd4-f23c-4fea-a12f-6c961d924a4c"}],"solutions":[{"id":"b6a240e4-9db1-4b6d-b818-319e3389b658","score":0},{"id":"4d4c2648-522f-4323-b10d-91d183400424","score":0},{"id":"7d79e2b5-9072-4841-82e4-d4fdf69e2f4d","score":1},{"id":"67cfadfa-bee4-4df6-93a1-de57350cd763","score":0},{"id":"21ffdcd4-f23c-4fea-a12f-6c961d924a4c","score":0}],"id":"74de4d6f-f000-45bd-9ef6-548b9aa934a2","type":"Dictionnaire","content":"Quel est lobjet de la lexicographie ?","title":"","meta":{"authors":[{"id":"3","name":"MBONING Elvis","email":"juslestawo@yahoo.fr"}],"created":"2017-05-30T12:10:15","updated":"2017-05-30T12:25:44","model":false,"usedBy":["05dda38f-8669-48e4-8314-90f3d8db328d"],"sharedWith":[{"adminRights":false,"user":{"id":"1","name":"MBONING Elvis","email":"julestawo@yahoo.fr"}}]},"score":{"type":"sum"},"description":"","hints":[],"objects":[],"resources":[]},{"random":false,"multiple":false,"choices":[{"type":"text\/html","data":"Paris","id":"86aff498-6682-4fd7-91b7-8e7aec3df865"},{"type":"text\/html","data":"Lyon","id":"f317790e-083b-4a91-b623-d0b2726d5b92"},{"type":"text\/html","data":"Lille","id":"01bf9bda-7ded-4e25-ad83-615426692784"},{"type":"text\/html","data":"Gen\u00e8ve","id":"a5221a4a-4027-4222-ad82-42f280a47472"},{"type":"text\/html","data":"Douala","id":"57aeb29d-a06c-45ef-b332-52a63270ac0a"},{"type":"text\/html","data":"Grenoble","id":"0420db57-9499-442e-b208-9186771e6e16"}],"solutions":[{"id":"86aff498-6682-4fd7-91b7-8e7aec3df865","score":1},{"id":"f317790e-083b-4a91-b623-d0b2726d5b92","score":0},{"id":"01bf9bda-7ded-4e25-ad83-615426692784","score":1},{"id":"a5221a4a-4027-4222-ad82-42f280a47472","score":0},{"id":"57aeb29d-a06c-45ef-b332-52a63270ac0a","score":0},{"id":"0420db57-9499-442e-b208-9186771e6e16","score":0}],"id":"4ac75f3c-474d-43fa-b494-40cc471cde98","type":"Dictionnaire","content":"Quelle ville en France enseigne la lexicographie ?","title":"","meta":{"authors":[{"id":"3","name":"MBONING Elvis","email":"juslestawo@yahoo.fr"}],"created":"2017-05-30T12:10:15","updated":"2017-05-30T12:25:44","model":false,"usedBy":["05dda38f-8669-48e4-8314-90f3d8db328d"],"sharedWith":[{"adminRights":false,"user":{"id":"1","name":"MBONING Elvis","email":"julestawo@yahoo.fr"}}]},"score":{"type":"sum"},"description":"","hints":[],"objects":[],"resources":[]},{"random":false,"multiple":false,"choices":[{"type":"text\/html","data":"lexicologue","id":"fef3e303-62ea-4d07-a4c0-3fa63fb4b428"},{"type":"text\/html","data":"dictionneur","id":"2187ebcc-0bb0-4642-9270-6f9a7e5fecd6"},{"type":"text\/html","data":"lexicographe","id":"b7a0859f-f523-4bdb-921f-1dcebecc97b0"},{"type":"text\/html","data":"taliste","id":"04c3fa16-d81d-4344-ac9c-02840abbc172"},{"type":"text\/html","data":"\u00e9diteur","id":"d9e2adc2-7901-4644-8e7b-12ed7af4e26d"},{"type":"text\/html","data":"linguiste","id":"b63a46a8-08ce-4ca5-9c40-1449013596aa"}],"solutions":[{"id":"fef3e303-62ea-4d07-a4c0-3fa63fb4b428","score":0},{"id":"2187ebcc-0bb0-4642-9270-6f9a7e5fecd6","score":0},{"id":"b7a0859f-f523-4bdb-921f-1dcebecc97b0","score":1},{"id":"04c3fa16-d81d-4344-ac9c-02840abbc172","score":0},{"id":"d9e2adc2-7901-4644-8e7b-12ed7af4e26d","score":0},{"id":"b63a46a8-08ce-4ca5-9c40-1449013596aa","score":1}],"id":"87eadeef-f691-46e6-bccf-eb222755902e","type":"Dictionnaire","content":"Comment appelle t-on les personnes qui travaillent sur un dictionnaire ?","title":"","meta":{"authors":[{"id":"3","name":"MBONING Elvis","email":"juslestawo@yahoo.fr"}],"created":"2017-05-30T12:10:15","updated":"2017-05-30T12:25:44","model":false,"usedBy":["05dda38f-8669-48e4-8314-90f3d8db328d"],"sharedWith":[]},"score":{"type":"sum"},"description":"","hints":[],"objects":[],"resources":[]},{"random":false,"penalty":0,"firstSet":[{"type":"text\/html","data":"lexicographe","id":"b5f6cc99-dedf-4cd8-af20-6a7a617ec448"},{"type":"text\/html","data":"m\u00e9talexicographe","id":"ef34ef9c-3096-4f1c-99c1-d43c90f2c6ee"}],"secondSet":[{"type":"text\/html","data":"celui qui construit les dictionnaires de langue","id":"7a2464a0-d5c4-4098-8d82-1b1e77a8dfd2"},{"type":"text\/html","data":"celui \u00e9tudie les dictionnaires de langue","id":"8526bcdc-750b-4025-a66c-8d4eaf97b426"}],"solutions":[{"firstId":"b5f6cc99-dedf-4cd8-af20-6a7a617ec448","secondId":"7a2464a0-d5c4-4098-8d82-1b1e77a8dfd2","score":1},{"firstId":"ef34ef9c-3096-4f1c-99c1-d43c90f2c6ee","secondId":"8526bcdc-750b-4025-a66c-8d4eaf97b426","score":1}],"id":"96ebb600-7f05-4637-b444-6f8c39e4edcd","type":"Glossaire","content":"Associer les mots entre eux","title":"","meta":{"authors":[{"id":"3","name":"MBONING Elvis","email":"juslestawo@yahoo.fr"}],"created":"2017-05-30T12:25:44","updated":"2017-05-30T14:50:55","model":false,"usedBy":["05dda38f-8669-48e4-8314-90f3d8db328d"],"sharedWith":[{"adminRights":false,"user":{"id":"1","name":"MBONING Elvis","email":"julestawo@yahoo.fr"}}]},"score":{"type":"sum"},"description":"","hints":[],"objects":[],"resources":[]},{"random":false,"penalty":0,"firstSet":[{"type":"text\/html","data":"TAL","id":"5375b647-9dc4-4950-90b4-92d627097126"},{"type":"text\/html","data":"XML","id":"5d08308c-bccf-4f02-b853-4147df4cdc17"}],"secondSet":[{"type":"text\/html","data":"xenial Markup Language","id":"819b7750-fb98-43c4-9e48-12db1a58b7b0"},{"type":"text\/html","data":"traitement automatique des langues","id":"eb1f7587-07a9-40f1-930e-9614a63f1065"}],"solutions":[{"firstId":"5d08308c-bccf-4f02-b853-4147df4cdc17","secondId":"819b7750-fb98-43c4-9e48-12db1a58b7b0","score":1},{"firstId":"5375b647-9dc4-4950-90b4-92d627097126","secondId":"eb1f7587-07a9-40f1-930e-9614a63f1065","score":2}],"id":"9e8c0bf6-5e34-4c65-82dd-46119e9c51e6","type":"Glossaire","content":"Associer les termes et leurs valeurs correspondantes&nbsp;","title":"","meta":{"authors":[{"id":"3","name":"MBONING Elvis","email":"juslestawo@yahoo.fr"}],"created":"2017-05-30T12:25:44","updated":"2017-05-30T14:50:55","model":false,"usedBy":["05dda38f-8669-48e4-8314-90f3d8db328d"],"sharedWith":[]},"score":{"type":"sum"},"description":"","hints":[],"objects":[],"resources":[]}],"pagination":{"current":0,"pageSize":-1},"sortBy":{}}';