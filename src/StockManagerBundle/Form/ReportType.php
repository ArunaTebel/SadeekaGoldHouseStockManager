<?php

namespace StockManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ReportType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('sales_range', 'choice', array(
            'choices' => array('today' => 'Todays Sales', 'overall' => 'Overall Sales', 'between' => 'Sales Between'),
            'mapped' => false,
            'multiple' => false,
            'expanded' => true,
        ));
//        $builder->add('all', 'choice', array(
//            'choices' => array('all_cat' => 'All Categories'),
//            'mapped' => false,
//            'multiple' => false,
//            'expanded' => true,
//        ));
        $builder->add('category_name', 'entity', array('class' =>
            'StockManagerBundle:Category', 'property' => 'category_name',
            'mapped' => false,
            'required'=> false,
            'empty_value'=>'All'));
        $builder->add('date_from', 'date', array('mapped' => 'false'));
        $builder->add('date_to', 'date', array('mapped' => 'false'));
        $builder->add('Generate', 'submit');
    }

    public function getName() {
        return 'reports';
    }

}
