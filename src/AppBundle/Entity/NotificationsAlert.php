<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationsAlert
 *
 * @ORM\Table(name="Notifications_Alert", indexes={@ORM\Index(name="id_monitoring_event", columns={"id_monitoring_event"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class NotificationsAlert
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="showed", type="boolean", nullable=false)
     */
    private $showed = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="viewed", type="boolean", nullable=false)
     */
    private $viewed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="id_notification_alert", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNotificationAlert;

    /**
     * @var \AppBundle\Entity\MonitoringEvents
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MonitoringEvents")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_monitoring_event", referencedColumnName="id_monitoring_event")
     * })
     */
    private $idMonitoringEvent;

    /**
     * @var \AppBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;



    /**
     * Set showed
     *
     * @param boolean $showed
     *
     * @return NotificationsAlert
     */
    public function setShowed($showed)
    {
        $this->showed = $showed;

        return $this;
    }

    /**
     * Get showed
     *
     * @return boolean
     */
    public function getShowed()
    {
        return $this->showed;
    }

    /**
     * Set viewed
     *
     * @param boolean $viewed
     *
     * @return NotificationsAlert
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;

        return $this;
    }

    /**
     * Get viewed
     *
     * @return boolean
     */
    public function getViewed()
    {
        return $this->viewed;
    }

    /**
     * Get idNotificationAlert
     *
     * @return integer
     */
    public function getIdNotificationAlert()
    {
        return $this->idNotificationAlert;
    }

    /**
     * Set idMonitoringEvent
     *
     * @param \AppBundle\Entity\MonitoringEvents $idMonitoringEvent
     *
     * @return NotificationsAlert
     */
    public function setIdMonitoringEvent(\AppBundle\Entity\MonitoringEvents $idMonitoringEvent = null)
    {
        $this->idMonitoringEvent = $idMonitoringEvent;

        return $this;
    }

    /**
     * Get idMonitoringEvent
     *
     * @return \AppBundle\Entity\MonitoringEvents
     */
    public function getIdMonitoringEvent()
    {
        return $this->idMonitoringEvent;
    }

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\Users $idUser
     *
     * @return NotificationsAlert
     */
    public function setIdUser(\AppBundle\Entity\Users $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \AppBundle\Entity\Users
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
