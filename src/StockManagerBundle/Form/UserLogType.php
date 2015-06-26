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
        $builder->add('date', 'date', array(
            'data' => new \DateTime()
        ));
        $builder->add('View', 'submit');
    }

    public function getName() {
        return 'userLogs';
    }

}
