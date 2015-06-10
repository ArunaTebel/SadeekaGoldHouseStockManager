<?php

namespace StockManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use StockManagerBundle\Entity\Item;
use StockManagerBundle\Entity\Category;
use StockManagerBundle\Form\ItemType;
use StockManagerBundle\Form\CategoryType;
use StockManagerBundle\Entity\Sales;
use StockManagerBundle\Form\SalesType;
use StockManagerBundle\Form\ReportType;
use StockManagerBundle\Entity\UserLog;
use StockManagerBundle\Form\UserLogType;
use Symfony\Component\HttpFoundation\Response;

class StockController extends Controller {

    public function addCategoryAction(Request $request) {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $user=$this->get('security.token_storage')->getToken()->getUser();
            date_default_timezone_set('Asia/Colombo');
            $date = date_create(date(date('Y-m-d H:i:s')));
            $userLog = new UserLog();
            $username = $user->getUsername();
            $userLog->setUser($user);
            $userLog->setAction("Add Category"); 
            $userLog->setActionId($category->getCategoryId());
            $userLog->setDate($date);
            $em->persist($userLog);
            $em->flush($userLog);
        }
        // Get Category List
        $categoryList = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Category')
                ->findAll();
        return $this->render('StockManagerBundle:Category:add_category.html.twig', array(
                    'form' => $form->createView(),
                    'categoryList' => $categoryList)
        );
    }

    public function editCategoryAction($category_id) {
          $criteria = array_filter(array(
            'category_id' => $category_id,
        ));
        $result = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Category')
                ->find($criteria);
        $form = $this->createForm(new CategoryType(), $result);
        $request = $this->get('request');
        $em = $this->getDoctrine()->getEntityManager();
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $em->flush();
                 $user=$this->get('security.token_storage')->getToken()->getUser();
            date_default_timezone_set('Asia/Colombo');
            $date = date_create(date(date('Y-m-d H:i:s')));
            $userLog = new UserLog();
            $userLog->setUser($user);
            $userLog->setAction("Edit Category"); 
            $userLog->setActionId($category_id);
            $userLog->setDate($date);
            $em->persist($userLog);
            $em->flush($userLog);
            }
        }       
        $categoryList = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Category')
                ->findAll();
        return $this->render('StockManagerBundle:Category:add_category.html.twig', array(
                    'form' => $form->createView(),
                    'categoryList' => $categoryList)
        );
    }

    public function addItemAction(Request $request) {
        $item = new Item();
        $form = $this->createForm(new ItemType(), $item);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getEntityManager();
        if ($form->isValid()) {
            $category = $form->getData('category_name');
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
             $user=$this->get('security.token_storage')->getToken()->getUser();
            date_default_timezone_set('Asia/Colombo');
            $date = date_create(date(date('Y-m-d H:i:s')));
            $userLog = new UserLog();
            $userLog->setUser($user);
            $userLog->setAction("Add Item"); 
            $userLog->setActionId($item->getItemId());
            $userLog->setDate($date);
            $em->persist($userLog);
            $em->flush($userLog);
        }
        // Get Item List
        $itemList = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Item')
                ->findAll();
        return $this->render('StockManagerBundle:Item:add_item.html.twig', array(
                    'form' => $form->createView(),
                    'itemList' => $itemList)
        );
    }

    public function editItemAction($item_id) {
        $criteria = array_filter(array(
            'item_id' => $item_id,
        ));
        $result = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Item')
                ->find($criteria);
        $form = $this->createForm(new ItemType(), $result);
        $request = $this->get('request');
        $em = $this->getDoctrine()->getEntityManager();
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $em->flush();
                 $user=$this->get('security.token_storage')->getToken()->getUser();
            date_default_timezone_set('Asia/Colombo');
            $date = date_create(date(date('Y-m-d H:i:s')));
            $userLog = new UserLog();
            $userLog->setUser($user);
            $userLog->setAction("Edit Item"); 
            $userLog->setActionId($item_id);
            $userLog->setDate($date);
            $em->persist($userLog);
            $em->flush($userLog);
            }
        }
        $itemList = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Item')
                ->findAll();
        return $this->render('StockManagerBundle:Item:add_item.html.twig', array('form' => $form->createView()
                    , 'itemList' => $itemList));
    }

    public function addSalesAction(Request $request) {
        $sales = new Sales();
        $form = $this->createForm(new SalesType(), $sales);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getEntityManager();
        $result = $em->createQueryBuilder()
                ->select('count(item.item_id)')
                ->from('StockManagerBundle:Item', 'item');
        $count = $result->getQuery()->getSingleScalarResult();
        $sum_mg = $em->createQueryBuilder()
                        ->select('sum(item.weight_mg)')
                        ->from('StockManagerBundle:Item', 'item')
                        ->getQuery()->getSingleScalarResult();
        $sum_g = $em->createQueryBuilder()
                        ->select('sum(item.weight_g)')
                        ->from('StockManagerBundle:Item', 'item')
                        ->getQuery()->getSingleScalarResult();
        $total = $sum_g * 1000 + $sum_mg;
        $total_kg = floor($total / 1000000);
        $total_g = floor(($total / 1000000 - $total_kg) * 1000);
        $total_mg = (($total / 1000000 - $total_kg) * 1000 - $total_g) * 1000;
        if ($form->isValid()) {
            $serial_no = $form['serial_no']->getData()->getSerialNo();
            $em = $this->getDoctrine()->getManager();
            $em->persist($sales);
            $em->flush();
            $item = $em->getRepository('StockManagerBundle:Item')
                    ->findOneBy(array('serial_no' => $serial_no));
            $em->remove($item);
            $em->flush();
            
            $user=$this->get('security.token_storage')->getToken()->getUser();
            date_default_timezone_set('Asia/Colombo');
            $date = date_create(date(date('Y-m-d H:i:s')));
            $userLog = new UserLog();
            $userLog->setUser($user);
            $userLog->setAction("Add Sale"); 
            $userLog->setActionId($sales->getSalesId());
            $userLog->setDate($date);
            $em->persist($userLog);
            $em->flush($userLog);
        }
        return $this->render('StockManagerBundle:Sales:add_sale.html.twig', array('form' => $form->createView(), 'count' => $count,
                    'total_kg' => $total_kg, 'total_g' => $total_g, 'total_mg' => $total_mg));
    }

    public function viewReportAction(Request $request) {
        $form = $this->createForm(new ReportType());
        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            $choice = $form['sales_range']->getData();
            if ($form['category_name']->getData() == null) {
                $category = "all";
            } else {
                $category = $form['category_name']->getData()->getCategoryName();
            }
            // $category = $form['category_name']->getData()->getCategoryName();
            // dump($category);
            $date_from = $form['date_from']->getData();
            $date_to = $form['date_to']->getData();
            $date = date_create(date(date('Y-m-d')));
            $em = $this->getDoctrine()->getManager();
            if ($choice == 'today') {
                if ($category != 'all') {
                    $criteria = array_filter(array(
                        'date' => $date,
                        'category_name' => $category,
                    ));
                } else {
                    $criteria = array_filter(array(
                        'date' => $date,
                    ));
                }
                $result = $this->getDoctrine()
                        ->getRepository('StockManagerBundle:Sales')
                        ->findBy($criteria);
//               dump($result);die;
                // dump($result[0]->getWeightMG());die;
                return $this->render('StockManagerBundle:Report:view_report.html.twig', array('form' => $form->createView(),
                            'result' => $result));
            } else if ($choice == 'overall') {
                if ($category != 'all') {
                    $criteria = array_filter(array(
                        'category_name' => $category,
                    ));
                    $result = $this->getDoctrine()
                            ->getRepository('StockManagerBundle:Sales')
                            ->findBy($criteria);
                } else {
                    $result = $this->getDoctrine()
                            ->getRepository('StockManagerBundle:Sales')
                            ->findAll();
                }
                return $this->render('StockManagerBundle:Report:view_report.html.twig', array('form' => $form->createView(),
                            'result' => $result));
            } else {
                if ($category != 'all') {
                    $result = $this->getDoctrine()
                            ->getRepository('StockManagerBundle:Sales')
                            ->createQueryBuilder('a')
                            ->where('a.date BETWEEN :from AND :to AND a.category_name= :category')
                            ->setParameter('from', $date_from)
                            ->setParameter('to', $date_to)
                            ->setParameter('category', $category)
                            ->getQuery()
                            ->getResult();
                } else {
                    $result = $this->getDoctrine()
                            ->getRepository('StockManagerBundle:Sales')
                            ->createQueryBuilder('a')
                            ->where('a.date BETWEEN :from AND :to')
                            ->setParameter('from', $date_from)
                            ->setParameter('to', $date_to)
                            ->getQuery()
                            ->getResult();
                }
                return $this->render('StockManagerBundle:Report:view_report.html.twig', array('form' => $form->createView(),
                            'result' => $result));
                // dump($result);die;
            }
        }
        return $this->render('StockManagerBundle:Report:view_report.html.twig', array('form' => $form->createView()
                    , 'result' => null));
    }

    public function getItemSerialsByCategoryNameAction() {
        $request = $this->container->get('request');
        $categoryName = $request->request->get('categoryName');


        $items = $this->getDoctrine()->getManager()
                ->getRepository('StockManagerBundle:Item')
                ->findAll();
        $results = array();

        foreach ($items as $item) {
            if ($item->getCategory()->getCategoryName() == $categoryName) {
                array_push($results, $item->getSerialNo());
            }
        }
        if (sizeof($results) < 1) {
            $results['success'] = false;
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($results, 200);
    }

    public function getItemWeightBySerialAction() {
        $request = $this->container->get('request');
        $serialNo = $request->request->get('serialNo');
        $criteria = array_filter(array(
            'serial_no' => $serialNo,
        ));
        $item = $this->getDoctrine()->getManager()
                ->getRepository('StockManagerBundle:Item')
                ->findBy($criteria);
        $results = array();
        if ($item == null) {
            $results['success'] = false;
        }
        if (is_array($item)) {
            $item = $item[0];
        }
        $weight_g = $item->getWeightG();
        $weight_mg = $item->getWeightMg();
        $results['weight_g'] = $weight_g;
        $results['weight_mg'] = $weight_mg;
        return new \Symfony\Component\HttpFoundation\JsonResponse($results, 200);
    }
    
    public function viewUserLogsAction(Request $request) {
        $form = $this->createForm(new UserLogType());
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getEntityManager();
        if ($form->isValid()) {
             $username = $form['username']->getData()->getUsername();
             $criteria1 = array_filter(array(
                        'username' => $username,
                    ));
             $user = $this->getDoctrine()
                        ->getRepository('StockManagerBundle:User')
                        ->findOneBy($criteria1);
            // dump($user);die;
             $user_id=$user->getId();
             $criteria2 = array_filter(array(
                        'user_id' => $user_id,
                    ));
                
                $result = $this->getDoctrine()
                        ->getRepository('StockManagerBundle:UserLog')
                        ->findBy($criteria2);
                return $this->render('StockManagerBundle:UserLogs:user_logs.html.twig', array(
                    'form' => $form->createView(),'result' => $result)
        );
            
        }
        return $this->render('StockManagerBundle:UserLogs:user_logs.html.twig', array(
                    'form' => $form->createView(),'result' => null
            )
        );
    }
}
