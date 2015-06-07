<?php

namespace StockManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StockManagerBundle:Default:index.html.twig', array('name' => $name));
    }
}
