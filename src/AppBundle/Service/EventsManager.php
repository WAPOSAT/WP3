<?php 

	namespace AppBundle\Service;

	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\Query;
	use AppBundle\Entity\MonitoringEvents;
	use AppBundle\Entity\NotificationsAlert;
	use Symfony\Component\HttpFoundation\Response;

	/**
	* Allows to you to generate and send any email that you need in the application
	*/
	class EventsManager
	{

		private $entityManager;

		public function __construct(EntityManager $entityManager)
		{
			$this->entityManager = $entityManager;
		}

		public function fireNotifierEvents($measurement, $minTime4Not)
		{
			//Get all the blocks where this sensor belongs
			$em = $this->entityManager;
			$dql = "SELECT bs FROM AppBundle:BlockSensors bs WHERE bs.idSensor = ".$measurement->getIdSensor()->getIdSensor();
			$b_sensors = $em->createQuery($dql)->getResult();

			//Container for notifications
			$notifications = array();

			foreach ($b_sensors as  $bs) 
			{
				//Get last Event produced for sensor that makes measurement in one specific block_sensor
				$dql = "SELECT e FROM AppBundle:MonitoringEvents e JOIN e.idMeasurement m WHERE m.idSensor = '".$measurement->getIdSensor()->getIdSensor()."' AND e.idBlockSensor = '".$bs->getId()."' ORDER BY e.idMonitoringEvent DESC";
				$lastMeasureEvent = $em->createQuery($dql)->setMaxResults(1)->getResult();

				$minutes = 0;
				if($lastMeasureEvent == null)
				{
					$minutes = $minTime4Not+1;
				}
				else 
				{
					$lastMeasureEvent = $lastMeasureEvent[0];

					//Minutes since the last event
					$diff = date_diff($measurement->getDate(), $lastMeasureEvent->getIdMeasurement()->getDate());
					$minutes = $diff->days * 24 * 60;
					$minutes += $diff->h * 60;
					$minutes += $diff->i;
					$minutes += ($diff->s)/60;
				}
				

				//Send all not notified 
				if ($minutes > $minTime4Not) 
				{
					$dql = "SELECT n FROM AppBundle:NotificationsAlert n JOIN n.idMonitoringEvent e JOIN e.idMeasurement m WHERE m.idSensor = '".$bs->getIdSensor()->getIdSensor()."' AND e.idBlockSensor = '".$bs->getId()."' AND n.byEmail = '0'";	
					$pastNotPerBlockSensor = $em->createQuery($dql)->getResult();

					foreach ($pastNotPerBlockSensor as $not) 
					{
						$not->setByEmail(1);
						$notifications[] = $not;
					}

					$em->flush();
				}

				//Define type of alert
				$alertType = "";
				if ($bs->getUpDangerLimit() < $measurement->getValue()) 
				{	
					$alertType = "danger";

				} else if($bs->getUpRiskLimit()< $measurement->getValue())
				{
					$alertType = "risk";
				}

				//Exist Event
				if($alertType != "")
				{
					//Send or not by email
					$sendEmail=0;
					if ($minutes > $minTime4Not) $sendEmail = 1;
		
					//Get Event type
					$dql = "SELECT et FROM AppBundle:EventType et WHERE et.alertType = '".$alertType."'";
					$eventType = $em->createQuery($dql)->getSingleResult();

					//Create event
					$event = new MonitoringEvents();
					$event->setIdMeasurement($measurement);
					$event->setIdBlockSensor($bs);
					$event->setIdEventType($eventType);
					$em->persist($event);

					//Get all users from this block
					$dql = "SELECT ub FROM AppBundle:UsersBlocks ub WHERE ub.idBlock = ".$bs->getIdBlock()->getId();
					$user_block = $em->createQuery($dql)->getResult();

					//Create a notification for each user of this block
					foreach ($user_block as $ub) 
					{
						$notf = new NotificationsAlert();

						$notf->setShowed(0);
						$notf->setViewed(0);
						$notf->setIdMonitoringEvent($event);
						$notf->setIdUser($ub->getIdUser());
						$notf->setByEmail($sendEmail);
						if($sendEmail) $notifications[] = $notf;
						$em->persist($notf);

					}

					$em->flush();

				}

			}

			return $notifications;

		}
	}

?>