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

		public function fireNotifierEvents($measurements)
		{
			$em = $this->entityManager;

			$dql = "SELECT bs FROM AppBundle:BlockSensors bs WHERE bs.idSensor = ".$measurements->getIdSensor()->getIdSensor();
			$b_sensors = $em->createQuery($dql)->getResult();

			$notifications = array();

			foreach ($b_sensors as  $bs) 
			{
				if ($bs->getUpDangerLimit() < $measurements->getValue()) 
				{
					$dql = "SELECT et FROM AppBundle:EventType et WHERE et.alertType = 'danger'";
					$eventType = $em->createQuery($dql)->getSingleResult();

					$event = new MonitoringEvents();
					$event->setIdMeasurement($measurements);
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
						$notifications[] = $notf;
						//$a=$notf;
						$em->persist($notf);
						//return $a;
					}

					$em->flush();

				} else if($bs->getUpRiskLimit()< $measurements->getValue())
				{
					$dql = "SELECT et FROM AppBundle:EventType et WHERE et.alertType = 'risk'";
					$eventType = $em->createQuery($dql)->getSingleResult();

					$event = new MonitoringEvents();
					$event->setIdMeasurement($measurements);
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
						$em->persist($notf);
						$notifications[] = $notf;
					}

					$em->flush();
				}
				
			}

			return $notifications;

		}
	}

?>