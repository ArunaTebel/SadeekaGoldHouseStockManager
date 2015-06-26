<?php

namespace StockManagerBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

class SalesType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('category_name', 'entity', array(
            'class' => 'StockManagerBundle:Category',
            'property' => 'category_name',
                )
        );
//                $factory = $builder->getFormFactory();
//
//        $builder->addEventListener(
//                FormEvents::PRE_BIND, function ($event) use ($factory) {
//            $form = $event->getForm();
//
//            // this would be your entity, i.e. SportMeetup
//            $data = $event->getData();
//            $serial_no = $data['serial_no'];
//            $form->get('serial_no')->setData($serial_no);
//        }
//        );
        
        $builder->add('serial_no', 'entity', array('class' =>
            'StockManagerBundle:Item', 'property' => 'serial_no', 'required' => true));
        $builder->add('weight_g', 'number', array(
            'attr' => array(
                'placeholder' => 'Weight (mg)',
            ),
            'label' => false,
            'read_only' => true
        ));
        $builder->add('weight_mg', 'number', array(
            'attr' => array(
                'placeholder' => 'Weight (mg)',
            ),
            'label' => false,
            'read_only' => true
        ));
        $builder->add('date', 'text');
        $builder->add('Sell', 'submit');

        
    }

    public function getName() {
        return 'sales';
    }

}
