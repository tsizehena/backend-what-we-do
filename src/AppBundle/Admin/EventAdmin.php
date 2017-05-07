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

class EventAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('community', 'entity', array(
                'label' => 'Communauté',
                'class' => 'AppBundle:Community',
                'choice_label' => 'title',
                'required' => true
            ))
            ->add('title', 'text', array(
                'label' => 'form.event.title'
            ))
            ->add('description', 'text', array(
                'label' => 'form.event.description'
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
}
