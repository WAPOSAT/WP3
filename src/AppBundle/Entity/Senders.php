<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Senders
 *
 * @ORM\Table(name="Senders")
 * @ORM\Entity
 */
class Senders
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_sender_type", type="integer", nullable=false)
     */
    private $idSenderType;

    /**
     * @var string
     *
     * @ORM\Column(name="mac", type="string", length=30, nullable=false)
     */
    private $mac;

    /**
     * @var string
     *
     * @ORM\Column(name="tmp", type="string", length=30, nullable=false)
     */
    private $tmp;

    /**
     * @var string
     *
     * @ORM\Column(name="ptmp", type="string", length=30, nullable=false)
     */
    private $ptmp;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

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
     * @ORM\Column(name="id_sender", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSender;



    /**
     * Set idSenderType
     *
     * @param integer $idSenderType
     *
     * @return Senders
     */
    public function setIdSenderType($idSenderType)
    {
        $this->idSenderType = $idSenderType;

        return $this;
    }

    /**
     * Get idSenderType
     *
     * @return integer
     */
    public function getIdSenderType()
    {
        return $this->idSenderType;
    }

    /**
     * Set mac
     *
     * @param string $mac
     *
     * @return Senders
     */
    public function setMac($mac)
    {
        $this->mac = $mac;

        return $this;
    }

    /**
     * Get mac
     *
     * @return string
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * Set tmp
     *
     * @param string $tmp
     *
     * @return Senders
     */
    public function setTmp($tmp)
    {
        $this->tmp = $tmp;

        return $this;
    }

    /**
     * Get tmp
     *
     * @return string
     */
    public function getTmp()
    {
        return $this->tmp;
    }

    /**
     * Set ptmp
     *
     * @param string $ptmp
     *
     * @return Senders
     */
    public function setPtmp($ptmp)
    {
        $this->ptmp = $ptmp;

        return $this;
    }

    /**
     * Get ptmp
     *
     * @return string
     */
    public function getPtmp()
    {
        return $this->ptmp;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Senders
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Senders
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
     * @return Senders
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
     * Get idSender
     *
     * @return integer
     */
    public function getIdSender()
    {
        return $this->idSender;
    }

}
