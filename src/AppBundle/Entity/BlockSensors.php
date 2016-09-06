<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlockSensors
 *
 * @ORM\Table(name="Block_Sensors", indexes={@ORM\Index(name="id_block", columns={"id_block"}), @ORM\Index(name="id_sensor", columns={"id_sensor"})})
 * @ORM\Entity
 */
class BlockSensors
{
    /**
     * @var float
     *
     * @ORM\Column(name="up_danger_limit", type="float", precision=10, scale=0, nullable=false)
     */
    private $upDangerLimit;

    /**
     * @var float
     *
     * @ORM\Column(name="up_risk_limit", type="float", precision=10, scale=0, nullable=false)
     */
    private $upRiskLimit;

    /**
     * @var float
     *
     * @ORM\Column(name="down_risk_limit", type="float", precision=10, scale=0, nullable=false)
     */
    private $downRiskLimit;

    /**
     * @var float
     *
     * @ORM\Column(name="down_danger_limit", type="float", precision=10, scale=0, nullable=false)
     */
    private $downDangerLimit;

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
     * @var \AppBundle\Entity\Blocks
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Blocks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_block", referencedColumnName="id")
     * })
     */
    private $idBlock;

    /**
     * @var \AppBundle\Entity\Sensors
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sensors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sensor", referencedColumnName="id_sensor")
     * })
     */
    private $idSensor;



    /**
     * Set upDangerLimit
     *
     * @param float $upDangerLimit
     *
     * @return BlockSensors
     */
    public function setUpDangerLimit($upDangerLimit)
    {
        $this->upDangerLimit = $upDangerLimit;

        return $this;
    }

    /**
     * Get upDangerLimit
     *
     * @return float
     */
    public function getUpDangerLimit()
    {
        return $this->upDangerLimit;
    }

    /**
     * Set upRiskLimit
     *
     * @param float $upRiskLimit
     *
     * @return BlockSensors
     */
    public function setUpRiskLimit($upRiskLimit)
    {
        $this->upRiskLimit = $upRiskLimit;

        return $this;
    }

    /**
     * Get upRiskLimit
     *
     * @return float
     */
    public function getUpRiskLimit()
    {
        return $this->upRiskLimit;
    }

    /**
     * Set downRiskLimit
     *
     * @param float $downRiskLimit
     *
     * @return BlockSensors
     */
    public function setDownRiskLimit($downRiskLimit)
    {
        $this->downRiskLimit = $downRiskLimit;

        return $this;
    }

    /**
     * Get downRiskLimit
     *
     * @return float
     */
    public function getDownRiskLimit()
    {
        return $this->downRiskLimit;
    }

    /**
     * Set downDangerLimit
     *
     * @param float $downDangerLimit
     *
     * @return BlockSensors
     */
    public function setDownDangerLimit($downDangerLimit)
    {
        $this->downDangerLimit = $downDangerLimit;

        return $this;
    }

    /**
     * Get downDangerLimit
     *
     * @return float
     */
    public function getDownDangerLimit()
    {
        return $this->downDangerLimit;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return BlockSensors
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

    /**
     * Set idBlock
     *
     * @param \AppBundle\Entity\Blocks $idBlock
     *
     * @return BlockSensors
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
     * Set idSensor
     *
     * @param \AppBundle\Entity\Sensors $idSensor
     *
     * @return BlockSensors
     */
    public function setIdSensor(\AppBundle\Entity\Sensors $idSensor = null)
    {
        $this->idSensor = $idSensor;

        return $this;
    }

    /**
     * Get idSensor
     *
     * @return \AppBundle\Entity\Sensors
     */
    public function getIdSensor()
    {
        return $this->idSensor;
    }
}
