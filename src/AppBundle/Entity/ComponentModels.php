<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ComponentModels
 *
 * @ORM\Table(name="component_models")
 * @ORM\Entity
 */
class ComponentModels
{
    /**
     * @var integer
     *
     * @ORM\Column(name="component_code", type="integer", nullable=false)
     */
    private $componentCode;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_component_model", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idComponentModel;



    /**
     * Set componentCode
     *
     * @param integer $componentCode
     *
     * @return ComponentModels
     */
    public function setComponentCode($componentCode)
    {
        $this->componentCode = $componentCode;
    
        return $this;
    }

    /**
     * Get componentCode
     *
     * @return integer
     */
    public function getComponentCode()
    {
        return $this->componentCode;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ComponentModels
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get idComponentModel
     *
     * @return integer
     */
    public function getIdComponentModel()
    {
        return $this->idComponentModel;
    }
}
