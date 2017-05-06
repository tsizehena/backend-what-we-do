<?php

/**
 * Created by PhpStorm.
 * User: mazaf
 * Date: 03/05/17
 * Time: 13:22
 */
namespace  AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CommunityAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title')
            ->add('description')
            ->add('noteMin', 'integer', array(
                'label' => 'Note min',
                'required' => false,
                'attr' => array(
                    'class' => 'note_size',
                    'readonly' => true
                ),
                'data' => 0
            ))->add('noteMax', 'integer', array(
                'label' => 'Note max',
                'required' => true,
                'attr' => array(
                    'class' => 'note_size note_max'
                )
            ))->add('notes', 'sonata_type_collection',
                array(
                    'by_reference' => false,
                    'cascade_validation' => true,
                    'type_options' => array(
                    'delete' => false
                )),
                array(
                    'edit' => 'inline',
                    'inline' => 'table'
                ),
                array('class' => 'role-wrapper')
            )->add('choices', 'entity', array(
                'label' => 'Choix',
                'class' => 'AppBundle:Choice',
                'choice_label' => 'title',
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ))->add('organizers', 'entity', array(
                'label' => 'Organisateurs',
                'class' => 'ApplicationSonataUserBundle:User',
                'choice_label' => 'email',
                'required' => false,
                'multiple' => true
            ))->add('participants', 'entity', array(
                'label' => 'Participants',
                'class' => 'AppBundle:Participant',
                'choice_label' => 'email',
                'required' => false,
                'multiple' => true
            ));

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

    public function configure() {
        $this->setTemplate('edit', 'AppBundle:CRUD:from_community.html.twig');
        $this->setTemplate('create', 'AppBundle:CRUD:from_community.html.twig');
    }
}
