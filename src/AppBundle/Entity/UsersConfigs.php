<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersConfigs
 *
 * @ORM\Table(name="Users_Configs", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_block", columns={"id_block"}), @ORM\Index(name="id_feature", columns={"id_feature"})})
 * @ORM\Entity
 */
class UsersConfigs
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user_config", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUserConfig;

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
     * @var \AppBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;



    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return UsersConfigs
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return UsersConfigs
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
     * Get idUserConfig
     *
     * @return integer
     */
    public function getIdUserConfig()
    {
        return $this->idUserConfig;
    }

    /**
     * Set idFeature
     *
     * @param \AppBundle\Entity\Features $idFeature
     *
     * @return UsersConfigs
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
     * @return UsersConfigs
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

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\Users $idUser
     *
     * @return UsersConfigs
     */
    public function setIdUser(\AppBundle\Entity\Users $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \AppBundle\Entity\Users
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
