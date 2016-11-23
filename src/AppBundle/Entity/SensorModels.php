<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SensorModels
 *
 * @ORM\Table(name="Sensor_Models", indexes={@ORM\Index(name="id_parameter", columns={"id_parameter"}), @ORM\Index(name="id_measurement_unit", columns={"id_measurement_unit"})})
 * @ORM\Entity
 */
class SensorModels
{
    /**
     * @var integer
     *
     * @ORM\Column(name="max_limit", type="integer", nullable=false)
     */
    private $maxLimit;

    /**
     * @var integer
     *
     * @ORM\Column(name="min_limit", type="integer", nullable=false)
     */
    private $minLimit;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_sensor_model", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSensorModel;

    /**
     * @var \AppBundle\Entity\Parameters
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Parameters")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_parameter", referencedColumnName="id_parameter")
     * })
     */
    private $idParameter;

    /**
     * @var \AppBundle\Entity\MeasurementsUnits
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MeasurementsUnits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_measurement_unit", referencedColumnName="id_measurement_unit")
     * })
     */
    private $idMeasurementUnit;



    /**
     * Set maxLimit
     *
     * @param integer $maxLimit
     *
     * @return SensorModels
     */
    public function setMaxLimit($maxLimit)
    {
        $this->maxLimit = $maxLimit;

        return $this;
    }

    /**
     * Get maxLimit
     *
     * @return integer
     */
    public function getMaxLimit()
    {
        return $this->maxLimit;
    }

    /**
     * Set minLimit
     *
     * @param integer $minLimit
     *
     * @return SensorModels
     */
    public function setMinLimit($minLimit)
    {
        $this->minLimit = $minLimit;

        return $this;
    }

    /**
     * Get minLimit
     *
     * @return integer
     */
    public function getMinLimit()
    {
        return $this->minLimit;
    }

    /**
     * Get idSensorModel
     *
     * @return integer
     */
    public function getIdSensorModel()
    {
        return $this->idSensorModel;
    }

    /**
     * Set idParameter
     *
     * @param \AppBundle\Entity\Parameters $idParameter
     *
     * @return SensorModels
     */
    public function setIdParameter(\AppBundle\Entity\Parameters $idParameter = null)
    {
        $this->idParameter = $idParameter;

        return $this;
    }

    /**
     * Get idParameter
     *
     * @return \AppBundle\Entity\Parameters
     */
    public function getIdParameter()
    {
        return $this->idParameter;
    }

    /**
     * Set idMeasurementUnit
     *
     * @param \AppBundle\Entity\MeasurementsUnits $idMeasurementUnit
     *
     * @return SensorModels
     */
    public function setIdMeasurementUnit(\AppBundle\Entity\MeasurementsUnits $idMeasurementUnit = null)
    {
        $this->idMeasurementUnit = $idMeasurementUnit;

        return $this;
    }

    /**
     * Get idMeasurementUnit
     *
     * @return \AppBundle\Entity\MeasurementsUnits
     */
    public function getIdMeasurementUnit()
    {
        return $this->idMeasurementUnit;
    }
}
