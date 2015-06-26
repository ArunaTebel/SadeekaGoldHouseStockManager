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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use StockManagerBundle\Entity\UserLog;
use StockManagerBundle\Form\UserLogType;

class StockController extends Controller {


    const ADD_ITEM_ACTION = "ADD_ITEM";
    const ADD_SALES_ACTION = "ADD_SALES";


    public function addCategoryAction(Request $request) {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            date_default_timezone_set('Asia/Colombo');
            $date = date_create(date(date('Y-m-d H:i:s')));
            /** No User log needed for adding a category
              $userLog = new UserLog();
              $username = $user->getUsername();
              $userLog->setUser($user);
              $userLog->setAction("Add Category");
              $userLog->setActionId($category->getCategoryId());
              $userLog->setDate($date);
              $em->persist($userLog);
              $em->flush($userLog);
             * 
             */
            return new RedirectResponse($this->generateUrl('StockManagerBundle_add_category'));
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
                $user = $this->get('security.token_storage')->getToken()->getUser();
                date_default_timezone_set('Asia/Colombo');
                $date = date_create(date(date('Y-m-d H:i:s')));
                /** No User log needed for editing a category
                  $userLog = new UserLog();
                  $userLog->setUser($user);
                  $userLog->setAction("Edit Category");
                  $userLog->setActionId($category_id);
                  $userLog->setDate($date);
                  $em->persist($userLog);
                  $em->flush($userLog);
                 * 
                 */
                return new RedirectResponse($this->generateUrl('StockManagerBundle_add_category'));
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
        $em = $this->getDoctrine()->getEntityManager();
        //$count = $result->getQuery()->getSingleScalarResult();
        $result = $this->getDoctrine()->getManager()
                ->getRepository('StockManagerBundle:Item')
                ->findBy(array(), array('item_id' => 'DESC'));
        //dump($result[0]->getCategoryId());die;
        if ($result != null) {
            $last_category_code = $result[0]->getCategory()->getCategoryCode();
            $last_serial_no = $result[0]->getSerialNo();
            $last_serial_id = str_replace($last_category_code, "", $last_serial_no);
            $new_serial_id = $last_serial_id + 1;
            if ($new_serial_id < 10) {
                $new_serial_id = "000" . $new_serial_id;
            } else if ($new_serial_id >= 10 & $new_serial_id < 100) {
                $new_serial_id = "00" . $new_serial_id;
            } else if ($new_serial_id >= 100 & $new_serial_id < 1000) {
                $new_serial_id = "0" . $new_serial_id;
            }
            $new_serial_no = $last_category_code . $new_serial_id;
            // dump($new_serial_no);die;
            $item->setCategory($result[0]->getCategory());
            $item->setSerialNo($new_serial_no);
        }
        $form = $this->createForm(new ItemType(), $item);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getEntityManager();
        if ($form->isValid()) {
            $category = $form->getData('category_name');
            $weight_mg = $form->getData('weight_mg')->getWeightMg();
            $mod = $weight_mg % 10;
            $sub = substr($weight_mg, 0, 2);
            if ($mod != 0) {
                $new_weight_mg = $sub . "0";
            }
            $item->setWeightMg($new_weight_mg);
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            date_default_timezone_set('Asia/Colombo');
            $date = date_create(date(date('Y-m-d')));
            $userLog = new UserLog();
            $userLog->setUser($user);
            $userLog->setAction(self::ADD_ITEM_ACTION);
            $userLog->setSerialNo($item->getSerialNo());
            $userLog->setCategory($item->getCategory()->getCategoryName());
            $userLog->setDate($date);
            $userLog->setWeightG($item->getWeightG());
            $userLog->setWeightMg($item->getWeightMg());
            $em->persist($userLog);
            $em->flush($userLog);
            $item->setCategoryId($category);
            //  $next_serial_number -> $item->getSerialNo()
            return new RedirectResponse($this->generateUrl('StockManagerBundle_add_item'));
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
                $user = $this->get('security.token_storage')->getToken()->getUser();
                date_default_timezone_set('Asia/Colombo');
                $date = date_create(date(date('Y-m-d H:i:s')));
                /** No User log needed for editing an item
                  $userLog = new UserLog();
                  $userLog->setUser($user);
                  $userLog->setAction("Edit Item");
                  $userLog->setActionId($item_id);
                  $userLog->setDate($date);
                  $em->persist($userLog);
                  $em->flush($userLog);
                 * 
                 */
                return new RedirectResponse($this->generateUrl('StockManagerBundle_add_item'));
            }
        }
        $itemList = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Item')
                ->findAll();
        return $this->render('StockManagerBundle:Item:add_item.html.twig', array('form' => $form->createView()
                    , 'itemList' => $itemList));
    }

    public function deleteItemAction($item_id) {
        $criteria = array_filter(array(
            'item_id' => $item_id,
        ));
        $result = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Item')
                ->find($criteria);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($result);
        $em->flush();
        return new RedirectResponse($this->generateUrl('StockManagerBundle_add_item'));
    }

    public function deleteCategoryAction($category_id) {
        $criteria = array_filter(array(
            'category_id' => $category_id,
        ));
        $result = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Category')
                ->find($criteria);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($result);
        $em->flush();
        return new RedirectResponse($this->generateUrl('StockManagerBundle_add_category'));
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
//        dump($form->getData()->getSerialNo());die;
        if ($form->isValid()) {
            $serial_no = $form['serial_no']->getData()->getSerialNo();
//            dump($serial_no);die;
            $date = $form['date']->getData();
            $dateTime = new \DateTime($date);
            $sales->setDate($dateTime);
            $em = $this->getDoctrine()->getManager();
//            dump($serial_no);die;
            $em->persist($sales);
            $em->flush();
            $item = $em->getRepository('StockManagerBundle:Item')
                    ->findOneBy(array('serial_no' => $serial_no));

//            dump($item->getItemId());die;
            $user = $this->get('security.token_storage')->getToken()->getUser();
            date_default_timezone_set('Asia/Colombo');
            $date = date_create(date(date('Y-m-d')));
            $userLog = new UserLog();
            $userLog->setUser($user);
            $userLog->setAction(self::ADD_SALES_ACTION);
            $userLog->setCategory($item->getCategory()->getCategoryName());
            $userLog->setSerialNo($item->getSerialNo());
            $userLog->setWeightG($item->getWeightG());
            $userLog->setWeightMg($item->getWeightMg());
            $userLog->setDate($date);
            $em->persist($userLog);
            $em->flush($userLog);
            $em->remove($item);
            $em->flush();
            return new RedirectResponse($this->generateUrl('StockManagerBundle_add_sales'));
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
                $sum_g = 0;
                $sum_mg = 0;
                foreach ($result as $sale) {
                    $sum_mg += $sale->getWeightMg();
                    $sum_g +=$sale->getWeightG();
                }
                if ($sum_mg > 1000) {
                    $temp = $sum_mg % 1000;
                    $sum_g = $sum_g + substr($sum_mg, 0, 1);
                    $sum_mg = $temp;
                }
                // dump($result[0]->getWeightMG());die;
                return $this->render('StockManagerBundle:Report:view_report.html.twig', array('form' => $form->createView(),
                            'result' => $result, 'sum_g' => $sum_g, 'sum_mg' => $sum_mg));
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
                $sum_g = 0;
                $sum_mg = 0;
                foreach ($result as $sale) {
                    $sum_mg += $sale->getWeightMg();
                    $sum_g +=$sale->getWeightG();
                }
                if ($sum_mg > 1000) {
                    $temp = $sum_mg % 1000;
                    $sum_g = $sum_g + substr($sum_mg, 0, 1);
                    $sum_mg = $temp;
                }
                return $this->render('StockManagerBundle:Report:view_report.html.twig', array('form' => $form->createView(),
                            'result' => $result, 'sum_g' => $sum_g, 'sum_mg' => $sum_mg));
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
                $sum_g = 0;
                $sum_mg = 0;
                foreach ($result as $sale) {
                    $sum_mg += $sale->getWeightMg();
                    $sum_g +=$sale->getWeightG();
                }
                if ($sum_mg > 1000) {
                    $temp = $sum_mg % 1000;
                    $sum_g = $sum_g + substr($sum_mg, 0, 1);
                    $sum_mg = $temp;
                }
                return $this->render('StockManagerBundle:Report:view_report.html.twig', array('form' => $form->createView(),
                            'result' => $result, 'sum_g' => $sum_g, 'sum_mg' => $sum_mg));
                // dump($result);die;
            }
        }
        return $this->render('StockManagerBundle:Report:view_report.html.twig', array('form' => $form->createView()
                    , 'result' => null, 'sum_g' => null, 'sum_mg' => null));
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
                array_push($results, $item->getItemId() . " " . $item->getSerialNo());
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
        $addItemLogs = $addSalesLogs = array();
        if ($form->isValid()) {
            $date = $form['date']->getData();
            if ($form['username']->getData() == null) {
                $username = "all";
                $criteria = array_filter(array(
                    'date' => $date,
                ));
                $result = $this->getDoctrine()
                        ->getRepository('StockManagerBundle:UserLog')
                        ->findBy($criteria);
            } else {
                $username = $form['username']->getData()->getUsername();
                $criteria1 = array_filter(array(
                    'username' => $username,
                ));
                $user = $this->getDoctrine()
                        ->getRepository('StockManagerBundle:User')
                        ->findOneBy($criteria1);
                $user_id = $user->getId();

                $criteria2 = array_filter(array(
                    'user_id' => $user_id,
                ));

                $result = $this->getDoctrine()
                        ->getRepository('StockManagerBundle:UserLog')
                        ->findBy($criteria2);
            }
            foreach ($result as $userLog) {
                if ($userLog->getAction() == self::ADD_ITEM_ACTION) {
                    array_push($addItemLogs, $userLog);
                } elseif ($userLog->getAction() == self::ADD_SALES_ACTION) {
                    array_push($addSalesLogs, $userLog);
                }
            }
            $grouped_item_logs = array();

            foreach ($addItemLogs as $key => $item) {
                $grouped_item_logs[$item->getCategory()][$key] = $item;
            }
//            dump($grouped_item_logs);
//            die;
            return $this->render('StockManagerBundle:UserLogs:user_logs.html.twig', array(
                        'form' => $form->createView(),
                        'add_item_logs' => $grouped_item_logs,
                        'add_sales_logs' => $addSalesLogs,
                        'date' => $date->format('Y-m-d')
            ));
        }
        return $this->render('StockManagerBundle:UserLogs:user_logs.html.twig', array(
                    'form' => $form->createView(),
                    'add_item_logs' => null,
                    'add_sales_logs' => null,
                    'date' => null
        ));
    }
    public function setNextSerialNoByCategoryAction() {
        $request = $this->container->get('request');
        $categoryName = $request->request->get('categoryName');
        //dump($categoryName);die;
        $items = $this->getDoctrine()->getManager()
                ->getRepository('StockManagerBundle:Item')
                ->findBy(array(), array('item_id' => 'DESC'));
        $results = array();
        foreach ($items as $item) {
            if ($item->getCategory()->getCategoryName() == $categoryName) {
                array_push($results, $item);
            }
        }
        if ($results != null) {
            $last_category_code = $results[0]->getCategory()->getCategoryCode();
            $last_serial_no = $results[0]->getSerialNo();
            $last_serial_id = str_replace($last_category_code, "", $last_serial_no);
            $new_serial_id = $last_serial_id + 1;
            if ($new_serial_id < 10) {
                $new_serial_id = "000" . $new_serial_id;
            } else if ($new_serial_id >= 10 & $new_serial_id < 100) {
                $new_serial_id = "00" . $new_serial_id;
            } else if ($new_serial_id >= 100 & $new_serial_id < 1000) {
                $new_serial_id = "0" . $new_serial_id;
            }
            $new_serial_no = $last_category_code . $new_serial_id;
        } else {
            $criteria = array_filter(array(
                'category_name' => $categoryName,
            ));
            $category_obj = $this->getDoctrine()
                    ->getRepository('StockManagerBundle:Category')
                    ->findOneBy($criteria);
            $new_category_code = $category_obj->getCategoryCode();
            $new_serial_no = $new_category_code . "0001";
        }
        if ($item == null) {
            $results['success'] = false;
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse($new_serial_no, 200);
    }

    public function viewSummaryAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $category_objects = $this->getDoctrine()->getManager()
                                  ->getRepository('StockManagerBundle:Category')
                                   ->findBy(array(), array('category_id' => 'DESC'));
        $category_size = $category_objects[0]->getCategoryId();
        $quantity = array();
        for ($i = 1; $i <= $category_size; $i++) {
            $temp_result = $this->getDoctrine()
                    ->getRepository('StockManagerBundle:Item')
                    ->createQueryBuilder('a')
                    ->select('count(a.item_id)')
                    ->where(' a.category_id= :category_id')
                    ->setParameter('category_id', $i)
                    ->getQuery()
                    ->getResult();
            array_push($quantity, $temp_result[0][1]);
        }
        $category_names = array();
        $result_cat = $this->getDoctrine()
                ->getRepository('StockManagerBundle:Category')
                ->findAll();
        foreach ($result_cat as $temp) {
            array_push($category_names, $temp->getCategoryName());
        }

        $result = array_combine($category_names, $quantity);
        return $this->render('StockManagerBundle:Summary:view_summary.html.twig', array(
                    'result' => $result
                        )
        );
    }

 
}
