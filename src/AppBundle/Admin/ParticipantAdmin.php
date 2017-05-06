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
            ->add('email')
            ->add('firstname')
            ->add('lastname');

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('firstname')
            ->add('lastname');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('firstname')
            ->add('lastname')
            ->add('_action', null, array(
            'actions' => array(
                'edit' => array(),
                'delete' => array(),
            )
        ));;
    }
}
