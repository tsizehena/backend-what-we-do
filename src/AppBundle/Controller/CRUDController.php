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
       // $id = $this->get('request')->get($this->admin->getIdParameter());
        $request = $this->get('request');
        $defaultData = array();
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
                'label' => 'Créer un événement',
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ))
            ->getForm();

        $communityForm->handleRequest($request);

        if ($communityForm->isSubmitted() && $communityForm->isValid()) {

            $community = $communityForm->get('community')->getData();
            if ($community instanceof  Community == true) {
                $this->get('session')->set('community_id', $community->getId());
                return new RedirectResponse($this->admin->generateUrl('create'));
            }
        }

        //return new RedirectResponse($this->admin->generateUrl('create'));
        return $this->render('AppBundle:CRUD:choice_community.html.twig', array(
            'form' => $communityForm->createView(),
            'action' => 'edit',
            'object' => array()
        ));
    }
}