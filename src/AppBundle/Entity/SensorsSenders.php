<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SensorsSenders
 *
 * @ORM\Table(name="Sensors_Senders", indexes={@ORM\Index(name="id_sensor", columns={"id_sensor"}), @ORM\Index(name="id_sender", columns={"id_sender"})})
 * @ORM\Entity
 */
class SensorsSenders
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_sensor_sender", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSensorSender;

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
     * @var \AppBundle\Entity\Senders
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Senders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sender", referencedColumnName="id_sender")
     * })
     */
    private $idSender;



    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return SensorsSenders
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
     * Get idSensorSender
     *
     * @return integer
     */
    public function getIdSensorSender()
    {
        return $this->idSensorSender;
    }

    /**
     * Set idSensor
     *
     * @param \AppBundle\Entity\Sensors $idSensor
     *
     * @return SensorsSenders
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

    /**
     * Set idSender
     *
     * @param \AppBundle\Entity\Senders $idSender
     *
     * @return SensorsSenders
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
