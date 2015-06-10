<?php

namespace StockManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLog
 */
class UserLog
{
    /**
     * @var integer
     */
    private $log_id;

    /**
     * @var integer
     */
    private $user_id;

    /**
     * @var string
     */
    private $action;

    /**
     * @var integer
     */
    private $action_id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \StockManagerBundle\Entity\User
     */
    private $user;


    /**
     * Get log_id
     *
     * @return integer 
     */
    public function getLogId()
    {
        return $this->log_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return UserLog
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return UserLog
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set action_id
     *
     * @param integer $actionId
     * @return UserLog
     */
    public function setActionId($actionId)
    {
        $this->action_id = $actionId;

        return $this;
    }

    /**
     * Get action_id
     *
     * @return integer 
     */
    public function getActionId()
    {
        return $this->action_id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return UserLog
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \StockManagerBundle\Entity\User $user
     * @return UserLog
     */
    public function setUser(\StockManagerBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \StockManagerBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
