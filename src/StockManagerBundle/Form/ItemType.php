<?php

namespace StockManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('category', 'entity', array(
            'class' => 'StockManagerBundle:Category',
            'property' => 'category_name',
            'attr' => array(
                'placeholder' => 'Category Name',
            ),
            'label' => false));
        $builder->add('serial_no', 'text', array(
            'attr' => array(
                'placeholder' => 'Serial No.',
            ),
            'label' => false));
        $builder->add('weight_g', 'number', array(
            'attr' => array(
                'placeholder' => 'Weight (g)',
            ),
            'label' => false));
        $builder->add('weight_mg', 'number', array(
            'attr' => array(
                'placeholder' => 'Weight (mg)',
            ),
            'label' => false));
        $builder->add('Save', 'submit');
    }

    public function getName() {
        return 'category';
    }

}
