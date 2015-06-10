<?php

/**
 * Description of RegistrationListener
 *
 * @author ArunaTebel
 */

namespace StockManagerBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RegistrationListener implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(FormEvent $event) {
        $rolesArr = array('ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN');

        /** @var $user \FOS\UserBundle\Model\UserInterface */
        $user = $event->getForm()->getData();
    }

}
