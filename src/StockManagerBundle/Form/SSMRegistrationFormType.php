<?php

/**
 * Description of RegistrationFormType
 *
 * @author ArunaTebel
 */

namespace StockManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SSMRegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // Adding an additional form field (roles)
        $builder->add('roles', 'choice', array(
            'multiple' => true,
            'expanded' => true,
            'choices' => array('ROLE_USER' => 'User', 'ROLE_ADMIN' => 'Admin', 'ROLE_SUPER_ADMIN' => 'Super Admin'),
        ));

        // Overriding the labels of the defualt register form
        /*$emailField = $builder->get('email');
        $emailFieldOptions = $emailField->getOptions();
        $emailFieldOptions['label'] = "Email";
        $builder->add('email', $emailField->getType()->getName(), $emailFieldOptions);

        $usernameField = $builder->get('username');
        $usernameFieldOptions = $usernameField->getOptions();
        $usernameFieldOptions['label'] = "Username";
        $builder->add('username', $usernameField->getType()->getName(), $usernameFieldOptions);

        $passwordFields = $builder->get('plainPassword');
        $passwordFieldsOptions = $passwordFields->getOptions();
        $passwordFieldsOptions['first_options']['label'] = "Password";
        $passwordFieldsOptions['second_options']['label'] = "Repeat Password";
        $builder->add('plainPassword', $passwordFields->getType()->getName(), $passwordFieldsOptions);
         * 
         */
    }

    public function getParent() {
        return 'fos_user_registration';
    }

    public function getName() {
        return 'sadeeka_sm_user_registration';
    }

}
