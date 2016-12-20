<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportsSubmitted
 *
 * @ORM\Table(name="reports_submitted", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_scheduled_report", columns={"id_scheduled_report"}), @ORM\Index(name="id_sent_email", columns={"id_sent_email"})})
 * @ORM\Entity
 */
class ReportsSubmitted
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="since_date", type="datetime", nullable=false)
     */
    private $sinceDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="until_date", type="datetime", nullable=false)
     */
    private $untilDate;

    /**
     * @var string
     *
     * @ORM\Column(name="message_body", type="text", length=65535, nullable=false)
     */
    private $messageBody;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_report_submitted", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReportSubmitted;

    /**
     * @var \AppBundle\Entity\ScheduledReports
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ScheduledReports")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_scheduled_report", referencedColumnName="id_scheduled_report")
     * })
     */
    private $idScheduledReport;

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
     * @var \AppBundle\Entity\SentEmails
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SentEmails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sent_email", referencedColumnName="id_sent_email")
     * })
     */
    private $idSentEmail;



    /**
     * Set sinceDate
     *
     * @param \DateTime $sinceDate
     *
     * @return ReportsSubmitted
     */
    public function setSinceDate($sinceDate)
    {
        $this->sinceDate = $sinceDate;
    
        return $this;
    }

    /**
     * Get sinceDate
     *
     * @return \DateTime
     */
    public function getSinceDate()
    {
        return $this->sinceDate;
    }

    /**
     * Set untilDate
     *
     * @param \DateTime $untilDate
     *
     * @return ReportsSubmitted
     */
    public function setUntilDate($untilDate)
    {
        $this->untilDate = $untilDate;
    
        return $this;
    }

    /**
     * Get untilDate
     *
     * @return \DateTime
     */
    public function getUntilDate()
    {
        return $this->untilDate;
    }

    /**
     * Set messageBody
     *
     * @param string $messageBody
     *
     * @return ReportsSubmitted
     */
    public function setMessageBody($messageBody)
    {
        $this->messageBody = $messageBody;
    
        return $this;
    }

    /**
     * Get messageBody
     *
     * @return string
     */
    public function getMessageBody()
    {
        return $this->messageBody;
    }

    /**
     * Get idReportSubmitted
     *
     * @return integer
     */
    public function getIdReportSubmitted()
    {
        return $this->idReportSubmitted;
    }

    /**
     * Set idScheduledReport
     *
     * @param \AppBundle\Entity\ScheduledReports $idScheduledReport
     *
     * @return ReportsSubmitted
     */
    public function setIdScheduledReport(\AppBundle\Entity\ScheduledReports $idScheduledReport = null)
    {
        $this->idScheduledReport = $idScheduledReport;
    
        return $this;
    }

    /**
     * Get idScheduledReport
     *
     * @return \AppBundle\Entity\ScheduledReports
     */
    public function getIdScheduledReport()
    {
        return $this->idScheduledReport;
    }

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\Users $idUser
     *
     * @return ReportsSubmitted
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

    /**
     * Set idSentEmail
     *
     * @param \AppBundle\Entity\SentEmails $idSentEmail
     *
     * @return ReportsSubmitted
     */
    public function setIdSentEmail(\AppBundle\Entity\SentEmails $idSentEmail = null)
    {
        $this->idSentEmail = $idSentEmail;
    
        return $this;
    }

    /**
     * Get idSentEmail
     *
     * @return \AppBundle\Entity\SentEmails
     */
    public function getIdSentEmail()
    {
        return $this->idSentEmail;
    }
}
