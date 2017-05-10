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
use AppBundle\Repository\ChoiceRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use AppBundle\Repository\CommunityRepository;

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
        $communityId = $container->get('session')->get('community_id');
        $community = null;

        if(!is_null($communityId)) {
            $em =  $container->get('doctrine.orm.entity_manager');
            $community = $em->getRepository('AppBundle:Community')->find($communityId);
        }

        $formMapper
            ->add('community', 'entity', array(
                'label' => 'form.event.community',
                'class' => 'AppBundle:Community',
                'query_builder' => function (CommunityRepository $er) use ($user) {
                    return $er->createQueryBuilder('c')
                        ->innerJoin('c.organizers', 'o')
                        ->where('o.id = :id')
                        ->setParameter('id', $user->getId());
                },
                'choice_label' => 'title',
                'required' => true,
                'attr' => array(
                    'id' => 'choice_community'
                )
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
            ->add('choices', 'entity', array(
                'label' => 'Choix',
                'class' => 'AppBundle:Choice',
                'choice_label' => 'title',
                'required' => true,
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

        $preListener = function (FormEvent $event) use ($formMapper, $community) {
            $form = $event->getForm();
            $data = $event->getData();
            if($event->getName() == FormEvents::PRE_SUBMIT) {
                $data = $form->getData();
            }

            if (!is_null($data) && !is_null($data->getId())) {
                $community = $data->getCommunity();
            }

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
                        'label' => 'form.event.choice',
                        'class' => 'AppBundle:Choice',
                        'query_builder' => function (ChoiceRepository $er) use ($community) {
                            return $er->createQueryBuilder('c')
                                ->where('c.community = :community')
                                ->setParameter('community', $community);
                        },
                        'choice_label' => 'title',
                        'required' => true,
                        'multiple' => true,
                        'expanded' => true
                    ));
                $formMapper->add('choices');

                $form->add('participants', 'entity', array(
                    'label' => 'form.event.participants',
                    'class' => 'AppBundle:Participant',
                    'choice_label' => 'email',
                    'required' => false,
                    'multiple' => true
                ));
                $formMapper->add('participants');

                $form->add('send_mail', 'choice', array(
                    'label' => 'form.event.notification',
                    'choices' => array(
                        1 => 'form.event.send_notification'
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
                $form->get('community')->setData($community);
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

    /**
     * Customize event list
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $container = $this->getConfigurationPool()->getContainer();
        $user = $container->get('security.token_storage')->getToken()->getUser();

        $query = parent::createQuery($context);
        $query->innerJoin($query->getRootAliases()[0] . '.community', 'c')
              ->innerJoin('c.organizers', 'org');
        $query->andWhere(
            $query->expr()->eq('org.id', ':user_id')
        );
        $query->setParameter('user_id', $user->getId());

        return $query;
    }

    /**
     * Customize event form
     */
    public function configure() {
        $this->setTemplate('edit', 'AppBundle:CRUD:form_event.html.twig');
        $this->setTemplate('create', 'AppBundle:CRUD:form_event.html.twig');
    }
}
