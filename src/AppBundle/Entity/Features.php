<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Features
 *
 * @ORM\Table(name="Features")
 * @ORM\Entity
 */
class Features
{
    /**
     * @var string
     *
     * @ORM\Column(name="feature_name", type="string", length=50, nullable=false)
     */
    private $featureName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate = 'CURRENT_TIMESTAMP';

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set featureName
     *
     * @param string $featureName
     *
     * @return Features
     */
    public function setFeatureName($featureName)
    {
        $this->featureName = $featureName;

        return $this;
    }

    /**
     * Get featureName
     *
     * @return string
     */
    public function getFeatureName()
    {
        return $this->featureName;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Features
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Features
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
