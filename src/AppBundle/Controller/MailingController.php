<?php 
	
	namespace AppBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
	use Symfony\Component\HttpFoundation\Response;

	/**
	* 
	*/
	class MailingController extends Controller
	{

		/**
		 * @Route("/mailing/{codeSchedule}/{schedule}", name="mailing" )
		 */
		public function ScheduledEmailAction ($codeSchedule, $schedule)
		{

			//query code and scheduled in database/table of schedules
			$Schedule = $this->getDoctrine()->getRepository('AppBundle:ScheduledReports')->findOneBy(array('idScheduledReport'=>$codeSchedule, 'schedule' => $schedule, 'active' => 1));

			$mm = $this->get('app.mailer');

			//Validate then send email or report error to admin
			if ($Schedule) 
			{
				$time = new \DateTime();
				$time2 = new \DateTime();
				$time2 = $time2->sub(new \DateInterval('P7D'));
				$user = $Schedule->getIdUser();

				$em = $this->getDoctrine()->getManager();

				$lD = $this->get('app.dataloader');
				$stations = $lD->getBlocks($user->getId(), 3);

				$risk = $danger = 0;

				foreach ($stations as $station) 
				{
					$dql = "SELECT e FROM AppBundle:MonitoringEvents e JOIN e.idMeasurement m JOIN e.idBlockSensor Bs WHERE DATE_DIFF(CURRENT_TIMESTAMP(), m.date) < 50 AND Bs.idBlock = ".$station->getId();
					$query = $em->createQuery($dql);
					$events = $query->getResult();
					$dAndR = $lD->countDangerAndRisks($events);
					
					$risk += $dAndR['risk'];
					$danger += $dAndR['danger'];

					$dql = "SELECT p FROM AppBundle:Blocks p WHERE p.id = ".$station->getIdParentBlock();
					$query = $em->createQuery($dql);
					$process = $query->getSingleResult();

					$EventsPerStation[] = array('station'=>$station, 'process'=>$process, 'numEvents'=>count($events), 'risk'=>$dAndR['risk'], 'danger'=>$dAndR['danger']);
				}

				$data = array("user"=>$user, "from"=>$time2, "to"=>$time, "numDanger"=>$danger, "numRisk"=>$risk, "stationsEvents"=>$EventsPerStation);

				$mm->sendEmail($data, $user->getEmail(),"Reporte Semanal", $Schedule->getTemplate());

		    	return new Response('<html><body>Email to '.$user->getEmail().' sent!</body></html>', Response::HTTP_OK);

			} else 
			{

				# Email Report to admin
				$mm->sendEmail("Someone(what) is trying to send an email report with Schedule Id:".$codeSchedule.", and Schedule:".$schedule.". Please check this Schedule.");

				return new Response('<html><body>Email FAIL to send!</body></html>', Response::HTTP_OK);

			}
		}
	}

?>