<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Measurement
 *
 * @ORM\Table(name="measurement", indexes={@ORM\Index(name="id_sensor", columns={"id_sensor"})})
 * @ORM\Entity
 */
class Measurement
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=false)
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_measurement", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMeasurement;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Measurement
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return Measurement
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get idMeasurement
     *
     * @return integer
     */
    public function getIdMeasurement()
    {
        return $this->idMeasurement;
    }

    /**
     * Set idSensor
     *
     * @param \AppBundle\Entity\Sensors $idSensor
     *
     * @return Measurement
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
