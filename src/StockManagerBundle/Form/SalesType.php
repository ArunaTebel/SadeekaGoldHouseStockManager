<?php

namespace StockManagerBundle\Form;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SalesType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        
        $builder->add('category_name', 'entity', array('class' =>
            'StockManagerBundle:Category', 'property' => 'category_name'));
        $builder->add('serial_no', 'entity', array('class' =>
            'StockManagerBundle:Item', 'property' => 'serial_no'));
        $builder->add('weight_g');
        $builder->add('weight_mg');
        $builder->add('date','date');
        $builder->add('Sell', 'submit');
    }

    public function getName() {
        return 'sales';
    }
 

}