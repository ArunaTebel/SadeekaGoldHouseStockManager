<?php

namespace StockManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('category_name', 'text', array(
            'attr' => array(
                'placeholder' => 'Category Name',
            ),
            'label' => false,
        ));
        $builder->add('category_code', 'text', array(
            'attr' => array(
                'placeholder' => 'Category Code',
            ),
            'label' => false,
        ));
        $builder->add('Save', 'submit');
    }

    public function getName() {
        return 'category';
    }

}
