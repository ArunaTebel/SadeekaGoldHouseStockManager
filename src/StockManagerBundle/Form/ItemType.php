<?php
namespace StockManagerBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder,array $options) {
 
        $builder->add('category_name','entity',array('class'=>
   'StockManagerBundle:Category' ,'property'=>'category_name'));
        $builder->add('serial_no');
        $builder->add('weight_g');
        $builder->add('weight_mg');
        $builder->add('Save','submit');
       
    }
    
    public function getName() {
        return 'category';
    }

}

