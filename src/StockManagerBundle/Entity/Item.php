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
     * @var string
     */
    private $category_name;

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
     * Get item_id
     *
     * @return integer 
     */
    public function getItemId()
    {
        return $this->item_id;
    }

     public function __toString() {
        return $this->getSerialNo(); 
    }
    /**
     * Set category_name
     *
     * @param string $categoryName
     * @return Item
     */
    public function setCategoryName($categoryName)
    {
        $this->category_name = $categoryName;

        return $this;
    }

    /**
     * Get category_name
     *
     * @return string 
     */
    public function getCategoryName()
    {
        return $this->category_name;
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
}
