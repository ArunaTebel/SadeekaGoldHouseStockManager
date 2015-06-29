<?php

namespace StockManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType {

    protected $isEditForm = false;

    public function __construct($isEditForm = false) {
        $this->isEditForm = $isEditForm;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('category', 'entity', array(
            'class' => 'StockManagerBundle:Category',
            'property' => 'category_name',
            'attr' => array(
                'placeholder' => 'Category Name',
            ),
            'label' => false,
            'disabled' => $this->isEditForm
        ));
        $builder->add('serial_no', 'text', array(
            'attr' => array(
                'placeholder' => 'Serial No.',
            ),
            'label' => false,
            'disabled' => $this->isEditForm
        ));
        $builder->add('weight_g', 'number', array(
            'attr' => array(
                'placeholder' => 'Weight (g)',
        )));
        $builder->add('weight_mg', 'number', array(
            'attr' => array(
                'placeholder' => 'Weight (mg)',
        )));
        $builder->add('Save', 'submit');
    }

    public function getName() {
        return 'category';
    }

}
