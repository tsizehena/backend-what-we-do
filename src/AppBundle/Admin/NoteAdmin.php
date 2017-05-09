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
                'label' => 'form.note.value',
                'attr' => array(
                    'class' => 'note_size',
                    'readonly' => true,
                    'required' => false
                )
            ))
            ->add('description', 'text', array(
                'label' => 'form.note.label'
            ))
            // We use input type "hidden" to placeholder delete button because input type button isn't work in sonata
            ->add('delete', 'hidden', array(
                'label' => '',
                'mapped' => false
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
                           'edit' => array(),
                           'delete' => array(),
                       )
                   ));
    }
}
