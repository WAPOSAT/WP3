<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MonitoringEvents
 *
 * @ORM\Table(name="Monitoring_Events", indexes={@ORM\Index(name="id_block_sensor", columns={"id_block_sensor"}), @ORM\Index(name="id_event_type", columns={"id_event_type"}), @ORM\Index(name="id_measurement", columns={"id_measurement"})})
 * @ORM\Entity
 */
class MonitoringEvents
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_monitoring_event", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMonitoringEvent;

    /**
     * @var \AppBundle\Entity\Measurement
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Measurement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_measurement", referencedColumnName="id_measurement")
     * })
     */
    private $idMeasurement;

    /**
     * @var \AppBundle\Entity\EventType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EventType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_event_type", referencedColumnName="id_event_type")
     * })
     */
    private $idEventType;

    /**
     * @var \AppBundle\Entity\BlockSensors
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BlockSensors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_block_sensor", referencedColumnName="id")
     * })
     */
    private $idBlockSensor;



    /**
     * Get idMonitoringEvent
     *
     * @return integer
     */
    public function getIdMonitoringEvent()
    {
        return $this->idMonitoringEvent;
    }

    /**
     * Set idMeasurement
     *
     * @param \AppBundle\Entity\Measurement $idMeasurement
     *
     * @return MonitoringEvents
     */
    public function setIdMeasurement(\AppBundle\Entity\Measurement $idMeasurement = null)
    {
        $this->idMeasurement = $idMeasurement;

        return $this;
    }

    /**
     * Get idMeasurement
     *
     * @return \AppBundle\Entity\Measurement
     */
    public function getIdMeasurement()
    {
        return $this->idMeasurement;
    }

    /**
     * Set idEventType
     *
     * @param \AppBundle\Entity\EventType $idEventType
     *
     * @return MonitoringEvents
     */
    public function setIdEventType(\AppBundle\Entity\EventType $idEventType = null)
    {
        $this->idEventType = $idEventType;

        return $this;
    }

    /**
     * Get idEventType
     *
     * @return \AppBundle\Entity\EventType
     */
    public function getIdEventType()
    {
        return $this->idEventType;
    }

    /**
     * Set idBlockSensor
     *
     * @param \AppBundle\Entity\BlockSensors $idBlockSensor
     *
     * @return MonitoringEvents
     */
    public function setIdBlockSensor(\AppBundle\Entity\BlockSensors $idBlockSensor = null)
    {
        $this->idBlockSensor = $idBlockSensor;

        return $this;
    }

    /**
     * Get idBlockSensor
     *
     * @return \AppBundle\Entity\BlockSensors
     */
    public function getIdBlockSensor()
    {
        return $this->idBlockSensor;
    }
}
