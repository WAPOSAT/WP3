<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SentEmails
 *
 * @ORM\Table(name="sent_emails", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class SentEmails
{
    /**
     * @var string
     *
     * @ORM\Column(name="email_recipient", type="string", length=50, nullable=false)
     */
    private $emailRecipient;

    /**
     * @var boolean
     *
     * @ORM\Column(name="received", type="boolean", nullable=false)
     */
    private $received;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="register_date", type="datetime", nullable=false)
     */
    private $registerDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_sent_email", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSentEmail;

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
     * Set emailRecipient
     *
     * @param string $emailRecipient
     *
     * @return SentEmails
     */
    public function setEmailRecipient($emailRecipient)
    {
        $this->emailRecipient = $emailRecipient;
    
        return $this;
    }

    /**
     * Get emailRecipient
     *
     * @return string
     */
    public function getEmailRecipient()
    {
        return $this->emailRecipient;
    }

    /**
     * Set received
     *
     * @param boolean $received
     *
     * @return SentEmails
     */
    public function setReceived($received)
    {
        $this->received = $received;
    
        return $this;
    }

    /**
     * Get received
     *
     * @return boolean
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return SentEmails
     */
    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;
    
        return $this;
    }

    /**
     * Get registerDate
     *
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * Get idSentEmail
     *
     * @return integer
     */
    public function getIdSentEmail()
    {
        return $this->idSentEmail;
    }

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\Users $idUser
     *
     * @return SentEmails
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
