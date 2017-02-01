<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlocksFeatures
 *
 * @ORM\Table(name="blocks_features", indexes={@ORM\Index(name="id_block", columns={"id_block"}), @ORM\Index(name="id_feature", columns={"id_feature"})})
 * @ORM\Entity
 */
class BlocksFeatures
{
    /**
     * @var integer
     *
     * @ORM\Column(name="owner", type="integer", nullable=false)
     */
    private $owner;

    /**
     * @var integer
     *
     * @ORM\Column(name="admin", type="integer", nullable=false)
     */
    private $admin;

    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=false)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_block_feature", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBlockFeature;

    /**
     * @var \AppBundle\Entity\Features
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Features")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_feature", referencedColumnName="id")
     * })
     */
    private $idFeature;

    /**
     * @var \AppBundle\Entity\Blocks
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Blocks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_block", referencedColumnName="id")
     * })
     */
    private $idBlock;



    /**
     * Set owner
     *
     * @param integer $owner
     *
     * @return BlocksFeatures
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return integer
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set admin
     *
     * @param integer $admin
     *
     * @return BlocksFeatures
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    
        return $this;
    }

    /**
     * Get admin
     *
     * @return integer
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set user
     *
     * @param integer $user
     *
     * @return BlocksFeatures
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return BlocksFeatures
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
     * @return BlocksFeatures
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
     * Get idBlockFeature
     *
     * @return integer
     */
    public function getIdBlockFeature()
    {
        return $this->idBlockFeature;
    }

    /**
     * Set idFeature
     *
     * @param \AppBundle\Entity\Features $idFeature
     *
     * @return BlocksFeatures
     */
    public function setIdFeature(\AppBundle\Entity\Features $idFeature = null)
    {
        $this->idFeature = $idFeature;
    
        return $this;
    }

    /**
     * Get idFeature
     *
     * @return \AppBundle\Entity\Features
     */
    public function getIdFeature()
    {
        return $this->idFeature;
    }

    /**
     * Set idBlock
     *
     * @param \AppBundle\Entity\Blocks $idBlock
     *
     * @return BlocksFeatures
     */
    public function setIdBlock(\AppBundle\Entity\Blocks $idBlock = null)
    {
        $this->idBlock = $idBlock;
    
        return $this;
    }

    /**
     * Get idBlock
     *
     * @return \AppBundle\Entity\Blocks
     */
    public function getIdBlock()
    {
        return $this->idBlock;
    }
}
