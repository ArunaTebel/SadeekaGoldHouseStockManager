<?php

namespace StockManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of UserLogType
 *
 * @author Chaya
 */
class UserLogType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username', 'entity', array('class' =>
            'StockManagerBundle:User', 'property' => 'username',
            'mapped' => false,
            'required' => false,
            'empty_value' => 'All'));
        $builder->add('date_range', 'choice', array(
            'choices' => array('today' => 'Todays Logs', 'overall' => 'Overall Logs', 'between' => 'Logs Between'),
            'mapped' => false,
            'multiple' => false,
            'expanded' => true,
        ));
        $builder->add('date_from', 'date', array('mapped' => 'false'));
        $builder->add('date_to', 'date', array('mapped' => 'false'));
        $builder->add('View', 'submit');
    }

    public function getName() {
        return 'userLogs';
    }

}
