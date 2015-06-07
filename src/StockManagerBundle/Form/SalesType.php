<?php

namespace StockManagerBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SalesType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('category_name', 'entity', array(
            'class' => 'StockManagerBundle:Category',
            'property' => 'category_name',
                )
        );
        $builder->add('serial_no', 'entity', array('class' =>
            'StockManagerBundle:Item', 'property' => 'serial_no', 'required' => true));
        $builder->add('weight_g', 'number', array(
            'attr' => array(
                'placeholder' => 'Weight (mg)',
            ),
            'label' => false
        ));
        $builder->add('weight_mg', 'number', array(
            'attr' => array(
                'placeholder' => 'Weight (mg)',
            ),
            'label' => false
        ));
        $builder->add('date', 'date');
        $builder->add('Sell', 'submit');
    }

    public function getName() {
        return 'sales';
    }

}
