<?php
namespace StockManagerBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
class CategoryType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder,array $options) {
 
        $builder->add('category_name');
        $builder->add('category_code');
        $builder->add('Save','submit');
       
    }
    
    public function getName() {
        return 'category';
    }

}
