<?php

namespace Daemon\SimplifyBundle\Entity;

use Daemon\SimplifyBundle\Component\Tools;
use Daemon\SimplifyBundle\Interfaces\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractEntity
 */
abstract class SimplifyEntity implements EntityInterface
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @var \DateTime
     */
    protected $updated_at;


    /**
     * @var string
     */
    protected $type;

    public function __construct() {
        $className = Tools::renameCamelcaseToUnderscore((get_class($this)));
        if (strpos($className, 'entity')) {
            $className = str_replace('entity', '', $className);
        }
        $this->type = $className;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the entity type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets created_at
     *
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Sets updated_at
     *
     * @param \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updated_at = $updatedAt;
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Formats date as String
     *
     * @param \DateTime $dateTime
     * @return string
     */
    public function dateTimeToString(\DateTime $dateTime, $format = null) {
        if (isset($format)) {
            return $dateTime->format($format);
        }
        return $dateTime->format('d-m-Y - H:i:s');
    }

    /**
     * R
     */
    public function toString()
    {
        $returnString = get_class($this) . 'ID: ' . $this->id;
        if (isset($this->name)) {
            $returnString .= ' Name: ' . $this->name;
        }
        if (isset ($this->title)) {
            $returnString .= ' Title: ' . $this->title;
        }
        $returnString .= ' Date created: ' . $this->dateTimeToString($this->created_at);
    }
}
