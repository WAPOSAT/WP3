<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventType
 *
 * @ORM\Table(name="Event_Type")
 * @ORM\Entity
 */
class EventType
{
    /**
     * @var string
     *
     * @ORM\Column(name="event_name", type="string", length=50, nullable=false)
     */
    private $eventName;

    /**
     * @var string
     *
     * @ORM\Column(name="alert_type", type="string", length=50, nullable=false)
     */
    private $alertType;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_event_type", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEventType;



    /**
     * Set eventName
     *
     * @param string $eventName
     *
     * @return EventType
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;

        return $this;
    }

    /**
     * Get eventName
     *
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * Set alertType
     *
     * @param string $alertType
     *
     * @return EventType
     */
    public function setAlertType($alertType)
    {
        $this->alertType = $alertType;

        return $this;
    }

    /**
     * Get alertType
     *
     * @return string
     */
    public function getAlertType()
    {
        return $this->alertType;
    }

    /**
     * Get idEventType
     *
     * @return integer
     */
    public function getIdEventType()
    {
        return $this->idEventType;
    }
}
