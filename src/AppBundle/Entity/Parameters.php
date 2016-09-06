<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parameters
 *
 * @ORM\Table(name="Parameters")
 * @ORM\Entity
 */
class Parameters
{
    /**
     * @var string
     *
     * @ORM\Column(name="parameter_codename", type="string", length=6, nullable=false)
     */
    private $parameterCodename;

    /**
     * @var string
     *
     * @ORM\Column(name="parameter_name", type="string", length=100, nullable=false)
     */
    private $parameterName;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_parameter", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idParameter;



    /**
     * Set parameterCodename
     *
     * @param string $parameterCodename
     *
     * @return Parameters
     */
    public function setParameterCodename($parameterCodename)
    {
        $this->parameterCodename = $parameterCodename;

        return $this;
    }

    /**
     * Get parameterCodename
     *
     * @return string
     */
    public function getParameterCodename()
    {
        return $this->parameterCodename;
    }

    /**
     * Set parameterName
     *
     * @param string $parameterName
     *
     * @return Parameters
     */
    public function setParameterName($parameterName)
    {
        $this->parameterName = $parameterName;

        return $this;
    }

    /**
     * Get parameterName
     *
     * @return string
     */
    public function getParameterName()
    {
        return $this->parameterName;
    }

    /**
     * Get idParameter
     *
     * @return integer
     */
    public function getIdParameter()
    {
        return $this->idParameter;
    }
}
