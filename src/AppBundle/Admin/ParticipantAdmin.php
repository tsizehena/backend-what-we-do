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

class ParticipantAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email', 'email', array(
                'label' => 'form.participant.email'
            ))
            ->add('firstname', 'text', array(
                'label' => 'form.participant.firstname',
                'required' => false
            ))
            ->add('lastname', 'text', array(
                'label' => 'form.participant.lastname',
                'required' => false
            ));

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email', null, array('label' => 'form.participant.email'))
            ->add('firstname', null, array('label' => 'form.participant.firstname'))
            ->add('lastname', null, array('label' => 'form.participant.lastname'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email', null, array('label' => 'form.participant.email'))
            ->add('firstname', null, array('label' => 'form.participant.firstname'))
            ->add('lastname', null, array('label' => 'form.participant.lastname'))
            ->add('_action', null, array(
            'label' => 'list.action',
            'actions' => array(
                'edit' => array(),
                'delete' => array(),
            )
        ));;
    }
}
