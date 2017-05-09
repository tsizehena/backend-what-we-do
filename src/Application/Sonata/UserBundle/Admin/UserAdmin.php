<?php

/**
 * Created by PhpStorm.
 * User: mazaf
 * Date: 03/05/17
 * Time: 17:16
 */
namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends \Sonata\UserBundle\Admin\Model\UserAdmin
{
    protected function configureFormFields(FormMapper $formMapper) {

        parent::configureFormFields($formMapper);
        //Remove some Profile fields
        $formMapper->remove('dateOfBirth');
        $formMapper->remove('website');
        $formMapper->remove('biography');
        $formMapper->remove('gender');
        $formMapper->remove('locale');
        $formMapper->remove('timezone');
        $formMapper->remove('locale');
        $formMapper->remove('phone');
        //Remove Social blocks from User panel
        $formMapper->removeGroup('Social', 'User');
        //Remove Groups blocks from Security panel
        $formMapper->removeGroup('Groups', 'Security');
        //Remove Keys blocks from Security panel
        $formMapper->removeGroup('Keys', 'Security');
        //Add Pentagramme field into User panel, Profile block
        $formMapper->tab('User')
            ->with('Profile')
                ->add('pentagramme', 'text', array(
                    'label' => 'form.user.profile.penta',
                    'required' => false
                ))
            ->end();
        // Remove Roles block to change him bootstrap class
        $formMapper->removeGroup('Roles', 'Security');

        $container = $this->getConfigurationPool()->getContainer();
        $roles = $container->getParameter('security.role_hierarchy.roles');
        $excludedRoles = $container->getParameter('excluded_roles');

        $rolesChoices = self::flattenRoles($roles, $excludedRoles);
        $formMapper->end()->tab('Security')
            ->with('Roles', array('class' => 'col-md-8'))
                ->add('roles','choice', array(
                    'label' => 'form.user.security.roles',
                    'choices' =>  $rolesChoices,
                    'multiple'=> true,
                    'expanded' => true,
                    'required' => false
                    ))
                ->end();
    }

    /**
     * Turns the role's array keys into string <ROLES_NAME> keys.
     */
    protected static function flattenRoles($rolesHierarchy, $excludedRoles)
    {
        $flatRoles = array();
        foreach($rolesHierarchy as $roles) {

            if(empty($roles)) {
                continue;
            }

            foreach($roles as $role) {
                if(!isset($flatRoles[$role]) && !in_array($role, $excludedRoles)) {
                    $flatRoles[$role] = $role;
                }
            }
        }

        return $flatRoles;
    }
}