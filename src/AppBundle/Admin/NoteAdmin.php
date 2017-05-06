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
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class NoteAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('value', 'integer', array(
                'label' => 'Valeur',
                'attr' => array(
                    'class' => 'note_size'
                )
            ))
            ->add('description', 'text', array(
                'label' => 'Libelle'
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
