<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeasurementsUnits
 *
 * @ORM\Table(name="Measurements_units")
 * @ORM\Entity
 */
class MeasurementsUnits
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, nullable=false)
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_measurement_unit", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMeasurementUnit;



    /**
     * Set code
     *
     * @param string $code
     *
     * @return MeasurementsUnits
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get idMeasurementUnit
     *
     * @return integer
     */
    public function getIdMeasurementUnit()
    {
        return $this->idMeasurementUnit;
    }
}
