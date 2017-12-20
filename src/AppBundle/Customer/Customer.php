<?php
namespace AppBundle\Customer;

use FOS\UserBundle\Model\User as BaseUser;
/**
 * Customer
 */
class Customer extends BaseUser
{
    const PROFILE_ID_TEACHER = 1;
    const PROFILE_ID_STUDENT = 2;
    
    /**
     * @var string
     */
    protected $id;
    /**
     * User constructor.
     * @param $id
     */
    
    /**
     * @var integer
     */
    protected $profile_id;
    
    public function __construct()
    {
        $this->id = $this->id ? $this->id : uniqid();
        $this->profile_id = self::PROFILE_ID_TEACHER;
        parent::__construct();
    }
    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get profile_id
     *
     * @return integer
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }
    
    /**
     * Set profile_id
     *
     * @return Customer
     */
    public function setProfileId($profileId)
    {
        $this->profile_id = $profileId;
        return $this;
    }
}