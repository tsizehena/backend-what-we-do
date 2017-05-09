<?php
/**
 * Created by PhpStorm.
 * User: mazaf
 * Date: 08/05/17
 * Time: 10:53
 */
namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Community;

class CRUDController extends Controller
{
    public function communityAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $communities = $user->getCommunities();
        // Redirect to event create form if use has single community
        if(sizeof($communities) == 1) {
            $community = $communities->first();
            $this->get('session')->set('community_id', $community->getId());
            $this->get('session')->set('by_pass_community', 1);

            return new RedirectResponse($this->admin->generateUrl('create'));
        //Choose community
        } else {
            $request = $this->get('request');
            $defaultData = array();
            //Form to choose community
            $communityForm = $this->createFormBuilder($defaultData)
                ->setAction($this->admin->generateUrl('community'))
                ->add('community', 'entity', array(
                    'label' => 'form.event.community',
                    'class' => 'AppBundle:Community',
                    'choice_label' => 'title',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )))
                ->add('submit', 'submit', array(
                    'label' => 'form.community.create',
                    'attr' => array(
                        'class' => 'btn btn-success'
                    )
                ))->getForm();
            //Bind request
            $communityForm->handleRequest($request);
            if ($communityForm->isSubmitted() && $communityForm->isValid()) {
                $community = $communityForm->get('community')->getData();
                if ($community instanceof  Community == true) {
                    //Save selected community into session
                    $this->get('session')->set('community_id', $community->getId());
                    //Set flag to by pass choose form community
                    $this->get('session')->set('by_pass_community', 1);

                    return new RedirectResponse($this->admin->generateUrl('create'));
                }
            }

            return $this->render('AppBundle:CRUD:choice_community.html.twig', array(
                'form' => $communityForm->createView(),
                'action' => 'edit',
                'object' => array()
            ));
        }
    }
}