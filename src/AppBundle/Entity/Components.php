<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Components
 *
 * @ORM\Table(name="components", indexes={@ORM\Index(name="id_component_model", columns={"id_component_model"}), @ORM\Index(name="id_sender", columns={"id_sender"})})
 * @ORM\Entity
 */
class Components
{
    /**
     * @var integer
     *
     * @ORM\Column(name="serie", type="integer", nullable=false)
     */
    private $serie;

    /**
     * @var string
     *
     * @ORM\Column(name="codename", type="string", length=50, nullable=false)
     */
    private $codename;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="connection_date", type="datetime", nullable=false)
     */
    private $connectionDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_component", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idComponent;

    /**
     * @var \AppBundle\Entity\ComponentModels
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ComponentModels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_component_model", referencedColumnName="id_component_model")
     * })
     */
    private $idComponentModel;

    /**
     * @var \AppBundle\Entity\Senders
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Senders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sender", referencedColumnName="id_sender")
     * })
     */
    private $idSender;



    /**
     * Set serie
     *
     * @param integer $serie
     *
     * @return Components
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    
        return $this;
    }

    /**
     * Get serie
     *
     * @return integer
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set codename
     *
     * @param string $codename
     *
     * @return Components
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
     * Set connectionDate
     *
     * @param \DateTime $connectionDate
     *
     * @return Components
     */
    public function setConnectionDate($connectionDate)
    {
        $this->connectionDate = $connectionDate;
    
        return $this;
    }

    /**
     * Get connectionDate
     *
     * @return \DateTime
     */
    public function getConnectionDate()
    {
        return $this->connectionDate;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Components
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
     * Get idComponent
     *
     * @return integer
     */
    public function getIdComponent()
    {
        return $this->idComponent;
    }

    /**
     * Set idComponentModel
     *
     * @param \AppBundle\Entity\ComponentModels $idComponentModel
     *
     * @return Components
     */
    public function setIdComponentModel(\AppBundle\Entity\ComponentModels $idComponentModel = null)
    {
        $this->idComponentModel = $idComponentModel;
    
        return $this;
    }

    /**
     * Get idComponentModel
     *
     * @return \AppBundle\Entity\ComponentModels
     */
    public function getIdComponentModel()
    {
        return $this->idComponentModel;
    }

    /**
     * Set idSender
     *
     * @param \AppBundle\Entity\Senders $idSender
     *
     * @return Components
     */
    public function setIdSender(\AppBundle\Entity\Senders $idSender = null)
    {
        $this->idSender = $idSender;
    
        return $this;
    }

    /**
     * Get idSender
     *
     * @return \AppBundle\Entity\Senders
     */
    public function getIdSender()
    {
        return $this->idSender;
    }
}
