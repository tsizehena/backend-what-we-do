<?php

/**
 * Created by PhpStorm.
 * User: mazaf
 * Date: 03/05/17
 * Time: 13:22
 */
namespace  AppBundle\Admin;

use AppBundle\Repository\ParticipantRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Entity\Community;
use AppBundle\Entity\Choice;
use AppBundle\Repository\ChoiceRepository;
use Sonata\AdminBundle\Route\RouteCollection;

class EventAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('community');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $user = $container->get('security.token_storage')->getToken()->getUser();
        $communities = $user->getCommunities();
        $community = sizeof($communities) > 0 ? $communities->first() : null;
        $formMapper
            ->add('community', 'entity', array(
                'label' => 'form.event.community',
                'class' => 'AppBundle:Community',
                'choice_label' => 'title',
                'required' => true
            ))
            ->add('title', 'text', array(
                'label' => 'form.title'
            ))
            ->add('description', null, array(
                'label' => 'form.description',
                'required' => false
            ))
            ->add('campaign_begin', 'sonata_type_date_picker', array(
                'label' => 'form.event.campaign_begin',
                'format' => 'dd-MM-yyyy'
            ))
            ->add('campaign_end', 'sonata_type_date_picker', array(
                'label' => 'form.event.campaign_end',
                'format' => 'dd-MM-yyyy'
            ))
            ->add('days', 'entity', array(
                'label' => 'Jours',
                'class' => 'AppBundle:Day',
                'choice_label' => 'description',
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ))
            ->add('choices', 'entity', array(
                'label' => 'Choix',
                'class' => 'AppBundle:Choice',
                'choice_label' => 'title',
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ))
            ->add('participants', 'entity', array(
                'label' => 'Participants',
                'class' => 'AppBundle:Participant',
                'choice_label' => 'email',
                'required' => false,
                'multiple' => true
            ))
            ->add('send_mail', 'choice', array(
                'label' => 'Notification',
                'choices' => array(
                    1 => 'Envoyer des notifications'
                ),
                'multiple' => true,
                'mapped' => false,
                'expanded' => true,
                'required' => false
            ));

        $builder = $formMapper->getFormBuilder();
        $factory = $builder->getFormFactory();

        $preListener = function (FormEvent $event) use ($formMapper, $community) {
            $form = $event->getForm();

            if($community instanceof Community == true) {
                //Remove choices field
                $form->remove('choices');
                $formMapper->remove('choices');

                $form->remove('participants');
                $formMapper->remove('participants');

                $form->remove('send_mail');
                $formMapper->remove('send_mail');
                //Add customize choices field
                $form->add('choices', 'entity', array(
                        'label' => 'Choix',
                        'class' => 'AppBundle:Choice',
                        'query_builder' => function (ChoiceRepository $er) use ($community) {
                            return $er->createQueryBuilder('c')
                                ->innerJoin('c.communities', 'com')
                                ->where('com.id = :id')
                                ->setParameter('id', $community->getId());
                        },
                        'choice_label' => 'title',
                        'required' => false,
                        'multiple' => true,
                        'expanded' => true
                    ));
                $formMapper->add('choices');

                $form->add('participants', 'entity', array(
                    'label' => 'Participants',
                    'class' => 'AppBundle:Participant',
                    'choice_label' => 'email',
                    'required' => false,
                    'multiple' => true
                ));
                $formMapper->add('participants');

                $form->add('send_mail', 'choice', array(
                    'label' => 'Notification',
                    'choices' => array(
                        1 => 'Envoyer des notifications'
                    ),
                    'multiple' => true,
                    'mapped' => false,
                    'expanded' => true,
                    'required' => false
                ));
                $formMapper->add('send_mail', 'choice');
            }
        };

        $postSetListener = function (FormEvent $event) use ($formMapper, $community) {
            $form = $event->getForm();
            $data = $event->getData();

            if($community instanceof Community == true && (!is_null($data) && is_null($data->getId()))) {
                $form->get('participants')->setData($community->getParticipants());
            }
        };

        $postSubmitListener = function (FormEvent $event) use ($formMapper, $community) {
            $form = $event->getForm();
            $data = $event->getData();

            if(!is_null($data)) {
                $participants = $data->getParticipants();
                if (sizeof($participants) > 0 && sizeof($form->get('send_mail')->getData())> 0) {
                    foreach($participants as $item){
                        //Send invitation email
                        //dump($item->getEmail());
                    }
                }
            }
        };

        //Pre listener
        $builder->addEventListener(FormEvents::PRE_SET_DATA, $preListener);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $preListener);

        //Post listener
        $builder->addEventListener(FormEvents::POST_SET_DATA, $postSetListener);
        $builder->addEventListener(FormEvents::POST_SUBMIT, $postSubmitListener);
     }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title')
                   ->add('description')
                   ->add('_action', null, array(
                       'actions' => array(
                           //'show' => array(),
                           'edit' => array(),
                           'delete' => array(),
                       )
                   ));
    }
}
