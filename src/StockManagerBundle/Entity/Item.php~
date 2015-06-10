<?php

namespace StockManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 */
class Item
{
    /**
     * @var integer
     */
    private $item_id;

    /**
     * @var integer
     */
    private $category_id;

    /**
     * @var string
     */
    private $serial_no;

    /**
     * @var integer
     */
    private $weight_g;

    /**
     * @var integer
     */
    private $weight_mg;

    /**
     * @var \StockManagerBundle\Entity\Category
     */
    private $category;


    /**
     * Get item_id
     *
     * @return integer 
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return Item
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set serial_no
     *
     * @param string $serialNo
     * @return Item
     */
    public function setSerialNo($serialNo)
    {
        $this->serial_no = $serialNo;

        return $this;
    }

    /**
     * Get serial_no
     *
     * @return string 
     */
    public function getSerialNo()
    {
        return $this->serial_no;
    }

    /**
     * Set weight_g
     *
     * @param integer $weightG
     * @return Item
     */
    public function setWeightG($weightG)
    {
        $this->weight_g = $weightG;

        return $this;
    }

    /**
     * Get weight_g
     *
     * @return integer 
     */
    public function getWeightG()
    {
        return $this->weight_g;
    }

    /**
     * Set weight_mg
     *
     * @param integer $weightMg
     * @return Item
     */
    public function setWeightMg($weightMg)
    {
        $this->weight_mg = $weightMg;

        return $this;
    }

    /**
     * Get weight_mg
     *
     * @return integer 
     */
    public function getWeightMg()
    {
        return $this->weight_mg;
    }

    /**
     * Set category
     *
     * @param \StockManagerBundle\Entity\Category $category
     * @return Item
     */
    public function setCategory(\StockManagerBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \StockManagerBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
    public function __toString() {
        return $this->getSerialNo(); 
    }
}
