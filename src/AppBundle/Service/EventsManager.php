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
			//Get all the block whre this sensor belongs
			$em = $this->entityManager;
			$dql = "SELECT bs FROM AppBundle:BlockSensors bs WHERE bs.idSensor = ".$measurement->getIdSensor()->getIdSensor();
			$b_sensors = $em->createQuery($dql)->getResult();

			$notifications = array();
			$minutes = 0; $here = 0;

			foreach ($b_sensors as  $bs) 
			{
				$sendOldNot = 0;


				//Get last Event produced for sensor that makes measurement in one specific block_sensor
				$dql = "SELECT e FROM AppBundle:MonitoringEvents e JOIN e.idMeasurement m WHERE m.idSensor = '".$measurement->getIdSensor()->getIdSensor()."' AND e.idBlockSensor = '".$bs->getId()."' ORDER BY e.idMonitoringEvent DESC";
				$lastMeasureEvent = $em->createQuery($dql)->setMaxResults(1)->getResult()[0];

				$diff = date_diff($measurement->getDate(), $lastMeasureEvent->getIdMeasurement()->getDate());
				$minutes = $diff->days * 24 * 60;
				$minutes += $diff->h * 60;
				$minutes += $diff->i;

				if ($bs->getUpDangerLimit() < $measurement->getValue()) 
				{	
				//if event is of type danger

					$dql = "SELECT et FROM AppBundle:EventType et WHERE et.alertType = 'danger'";
					$eventType = $em->createQuery($dql)->getSingleResult();

					$event = new MonitoringEvents();
					$event->setIdMeasurement($measurement);
					$event->setIdBlockSensor($bs);
					$event->setIdEventType($eventType);
					$em->persist($event);

					$dql = "SELECT ub FROM AppBundle:UsersBlocks ub WHERE ub.idBlock = ".$bs->getIdBlock()->getId();
					$user_block = $em->createQuery($dql)->getResult();

					foreach ($user_block as $ub) 
					{
						$notf = new NotificationsAlert();

						$notf->setShowed(0);
						$notf->setViewed(0);
						$notf->setIdMonitoringEvent($event);
						$notf->setIdUser($ub->getIdUser());
						
						if ($minutes > $minTime4Not) 
						{	
							$notf->setByEmail(1);
							$notifications[] = $notf;
							$sendOldNot = 1;
						}
						else{
							$notf->setByEmail(0);
						}

						$em->persist($notf);

					}

					$em->flush();

				} else if($bs->getUpRiskLimit()< $measurement->getValue())
				{
				//if event is of type risk
					$dql = "SELECT et FROM AppBundle:EventType et WHERE et.alertType = 'risk'";
					$eventType = $em->createQuery($dql)->getSingleResult();

					$event = new MonitoringEvents();
					$event->setIdMeasurement($measurement);
					$event->setIdBlockSensor($bs);
					$event->setIdEventType($eventType);
					$em->persist($event);
					
					$dql = "SELECT ub FROM AppBundle:UsersBlocks ub WHERE ub.idBlock = ".$bs->getIdBlock()->getId();
					$user_block = $em->createQuery($dql)->getResult();

					foreach ($user_block as $ub) 
					{
						$notf = new NotificationsAlert();

						$notf->setShowed(0);
						$notf->setViewed(0);
						$notf->setIdMonitoringEvent($event);
						$notf->setIdUser($ub->getIdUser());

						if ($minutes > $minTime4Not) 
						{	
							$notf->setByEmail(1);
							$notifications[] = $notf;
							$sendOldNot = 1;
						}
						else
						{
							$notf->setByEmail(0);
						}


						$em->persist($notf);
						
					}

					$em->flush();
				}else
				{	
					$sendOldNot = 2;
				}

				if($sendOldNot == 1 || $sendOldNot == 2)
				{
					//Get no all previous not notified for the blockSensor
					$dql = "SELECT n FROM AppBundle:NotificationsAlert n JOIN n.idMonitoringEvent e JOIN e.idMeasurement m JOIN m.idSensor s WHERE s.idSensor = '".$bs->getIdSensor()->getIdSensor()."' AND n.byEmail = '0'";
					$pastNotPerBlockSensor = $em->createQuery($dql)->getResult();

					foreach ($pastNotPerBlockSensor as $not) 
					{
						$not->setByEmail(1);
					}

					$em->flush();

					$notifications = array_merge($notifications, $pastNotPerBlockSensor);

				}

			}

			return $notifications;

		}
	}

?>