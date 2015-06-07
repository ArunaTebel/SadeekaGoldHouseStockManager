<?php

namespace StockManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Category
 */
class Category {

    /**
     * @var string
     */
    private $category_name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $items;
    public $all='all';

    /**
     * Constructor
     */
    public function __construct() {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->getCategoryName(); 
    }

    /**
     * Set category_name
     *
     * @param string $categoryName
     * @return Category
     */
    public function setCategoryName($categoryName) {
        $this->category_name = $categoryName;

        return $this;
    }

    /**
     * Get category_name
     *
     * @return string 
     */
    public function getCategoryName() {
        return $this->category_name;
    }

    /**
     * Add items
     *
     * @param \StockManagerBundle\Entity\Item $items
     * @return Category
     */
    public function addItem(\StockManagerBundle\Entity\Item $items) {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \StockManagerBundle\Entity\Item $items
     */
    public function removeItem(\StockManagerBundle\Entity\Item $items) {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * @var string
     */
    private $category_code;

    /**
     * Set category_code
     *
     * @param string $categoryCode
     * @return Category
     */
    public function setCategoryCode($categoryCode) {
        $this->category_code = $categoryCode;

        return $this;
    }

    /**
     * Get category_code
     *
     * @return string 
     */
    public function getCategoryCode() {
        return $this->category_code;
    }

    /**
     * @var integer
     */
    private $category_id;

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId() {
        return $this->category_id;
    }

    public static function loadvalidatorMetaData(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('category_code', new Length(4));
    }

}
