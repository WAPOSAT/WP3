<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blocks
 *
 * @ORM\Table(name="blocks", indexes={@ORM\Index(name="id_block_type", columns={"id_block_type"})})
 * @ORM\Entity
 */
class Blocks
{
    /**
     * @var string
     *
     * @ORM\Column(name="block_codename", type="string", length=50, nullable=false)
     */
    private $blockCodename;

    /**
     * @var string
     *
     * @ORM\Column(name="block_name", type="string", length=100, nullable=false)
     */
    private $blockName;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_parent_block", type="integer", nullable=true)
     */
    private $idParentBlock;

    /**
     * @var integer
     *
     * @ORM\Column(name="canvas_order", type="integer", nullable=false)
     */
    private $canvasOrder;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="description", type="integer", nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="ubigeo", type="integer", nullable=false)
     */
    private $ubigeo;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=30, nullable=false)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="refresh", type="integer", nullable=false)
     */
    private $refresh;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate = 'CURRENT_TIMESTAMP';

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
     * @var \AppBundle\Entity\BlockType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BlockType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_block_type", referencedColumnName="id_block_type")
     * })
     */
    private $idBlockType;



    /**
     * Set blockCodename
     *
     * @param string $blockCodename
     *
     * @return Blocks
     */
    public function setBlockCodename($blockCodename)
    {
        $this->blockCodename = $blockCodename;
    
        return $this;
    }

    /**
     * Get blockCodename
     *
     * @return string
     */
    public function getBlockCodename()
    {
        return $this->blockCodename;
    }

    /**
     * Set blockName
     *
     * @param string $blockName
     *
     * @return Blocks
     */
    public function setBlockName($blockName)
    {
        $this->blockName = $blockName;
    
        return $this;
    }

    /**
     * Get blockName
     *
     * @return string
     */
    public function getBlockName()
    {
        return $this->blockName;
    }

    /**
     * Set idParentBlock
     *
     * @param integer $idParentBlock
     *
     * @return Blocks
     */
    public function setIdParentBlock($idParentBlock)
    {
        $this->idParentBlock = $idParentBlock;
    
        return $this;
    }

    /**
     * Get idParentBlock
     *
     * @return integer
     */
    public function getIdParentBlock()
    {
        return $this->idParentBlock;
    }

    /**
     * Set canvasOrder
     *
     * @param integer $canvasOrder
     *
     * @return Blocks
     */
    public function setCanvasOrder($canvasOrder)
    {
        $this->canvasOrder = $canvasOrder;
    
        return $this;
    }

    /**
     * Get canvasOrder
     *
     * @return integer
     */
    public function getCanvasOrder()
    {
        return $this->canvasOrder;
    }

    /**
     * Set longitude
     *
     * @param integer $longitude
     *
     * @return Blocks
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return integer
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param integer $latitude
     *
     * @return Blocks
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return integer
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set description
     *
     * @param integer $description
     *
     * @return Blocks
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return integer
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ubigeo
     *
     * @param integer $ubigeo
     *
     * @return Blocks
     */
    public function setUbigeo($ubigeo)
    {
        $this->ubigeo = $ubigeo;
    
        return $this;
    }

    /**
     * Get ubigeo
     *
     * @return integer
     */
    public function getUbigeo()
    {
        return $this->ubigeo;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Blocks
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set refresh
     *
     * @param integer $refresh
     *
     * @return Blocks
     */
    public function setRefresh($refresh)
    {
        $this->refresh = $refresh;
    
        return $this;
    }

    /**
     * Get refresh
     *
     * @return integer
     */
    public function getRefresh()
    {
        return $this->refresh;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Blocks
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Blocks
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
     * Set idBlockType
     *
     * @param \AppBundle\Entity\BlockType $idBlockType
     *
     * @return Blocks
     */
    public function setIdBlockType(\AppBundle\Entity\BlockType $idBlockType = null)
    {
        $this->idBlockType = $idBlockType;
    
        return $this;
    }

    /**
     * Get idBlockType
     *
     * @return \AppBundle\Entity\BlockType
     */
    public function getIdBlockType()
    {
        return $this->idBlockType;
    }
}
