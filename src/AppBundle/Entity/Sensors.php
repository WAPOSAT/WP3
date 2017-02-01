<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sensors
 *
 * @ORM\Table(name="sensors", indexes={@ORM\Index(name="id_sensor_model", columns={"id_sensor_model"})})
 * @ORM\Entity
 */
class Sensors
{
    /**
     * @var string
     *
     * @ORM\Column(name="codename", type="string", length=50, nullable=false)
     */
    private $codename;

    /**
     * @var float
     *
     * @ORM\Column(name="serie", type="float", precision=10, scale=0, nullable=false)
     */
    private $serie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_connection", type="datetime", nullable=false)
     */
    private $dateConnection = 'CURRENT_TIMESTAMP';

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="id_sensor", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSensor;

    /**
     * @var \AppBundle\Entity\SensorModels
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SensorModels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sensor_model", referencedColumnName="id_sensor_model")
     * })
     */
    private $idSensorModel;



    /**
     * Set codename
     *
     * @param string $codename
     *
     * @return Sensors
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
     * Set serie
     *
     * @param float $serie
     *
     * @return Sensors
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    
        return $this;
    }

    /**
     * Get serie
     *
     * @return float
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set dateConnection
     *
     * @param \DateTime $dateConnection
     *
     * @return Sensors
     */
    public function setDateConnection($dateConnection)
    {
        $this->dateConnection = $dateConnection;
    
        return $this;
    }

    /**
     * Get dateConnection
     *
     * @return \DateTime
     */
    public function getDateConnection()
    {
        return $this->dateConnection;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Sensors
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
     * Get idSensor
     *
     * @return integer
     */
    public function getIdSensor()
    {
        return $this->idSensor;
    }

    /**
     * Set idSensorModel
     *
     * @param \AppBundle\Entity\SensorModels $idSensorModel
     *
     * @return Sensors
     */
    public function setIdSensorModel(\AppBundle\Entity\SensorModels $idSensorModel = null)
    {
        $this->idSensorModel = $idSensorModel;
    
        return $this;
    }

    /**
     * Get idSensorModel
     *
     * @return \AppBundle\Entity\SensorModels
     */
    public function getIdSensorModel()
    {
        return $this->idSensorModel;
    }
}
