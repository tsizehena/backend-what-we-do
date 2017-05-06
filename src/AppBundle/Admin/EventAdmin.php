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
            ->add('title')
            ->add('description');

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
