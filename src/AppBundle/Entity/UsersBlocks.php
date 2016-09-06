<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersBlocks
 *
 * @ORM\Table(name="Users_Blocks", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_block", columns={"id_block"})})
 * @ORM\Entity
 */
class UsersBlocks
{
    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=20, nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="codename", type="string", length=50, nullable=false)
     */
    private $codename;

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
     * @ORM\Column(name="id_user_block", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUserBlock;

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
     * @var \AppBundle\Entity\Blocks
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Blocks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_block", referencedColumnName="id")
     * })
     */
    private $idBlock;



    /**
     * Set role
     *
     * @param string $role
     *
     * @return UsersBlocks
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set codename
     *
     * @param string $codename
     *
     * @return UsersBlocks
     */
    public function setCodename($codename)
    {
        $this->codename = $codename;

        return $this;
    }

    /**
     * Get codename
     *
     * @return string
     */
    public function getCodename()
    {
        return $this->codename;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return UsersBlocks
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
     * @return UsersBlocks
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
     * Get idUserBlock
     *
     * @return integer
     */
    public function getIdUserBlock()
    {
        return $this->idUserBlock;
    }

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\Users $idUser
     *
     * @return UsersBlocks
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

    /**
     * Set idBlock
     *
     * @param \AppBundle\Entity\Blocks $idBlock
     *
     * @return UsersBlocks
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
