<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlockType
 *
 * @ORM\Table(name="block_type")
 * @ORM\Entity
 */
class BlockType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="block_type", type="integer", nullable=false)
     */
    private $blockType;

    /**
     * @var string
     *
     * @ORM\Column(name="type_name", type="string", length=50, nullable=false)
     */
    private $typeName;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_block_type", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBlockType;



    /**
     * Set blockType
     *
     * @param integer $blockType
     *
     * @return BlockType
     */
    public function setBlockType($blockType)
    {
        $this->blockType = $blockType;
    
        return $this;
    }

    /**
     * Get blockType
     *
     * @return integer
     */
    public function getBlockType()
    {
        return $this->blockType;
    }

    /**
     * Set typeName
     *
     * @param string $typeName
     *
     * @return BlockType
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
    
        return $this;
    }

    /**
     * Get typeName
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Get idBlockType
     *
     * @return integer
     */
    public function getIdBlockType()
    {
        return $this->idBlockType;
    }
}
