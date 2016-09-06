<?php 

	namespace AppBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use AppBundle\Entity\Measurement;


	/**
	* 
	*/
	class MonitorController extends Controller
	{
		/**
		 * @Route("monitor/{encoded_stream}", name = "persistData" )
		 */
		public function PersistDataAction($encoded_stream = null)
		{
			$credentials = $data = array();
			$enc = $this->get("app.encoder");
			$enc->decodeSensorStream($encoded_stream, $credentials, $data);
			//return new Response(var_dump($data));

			$em = $this->getDoctrine()->getManager();
			$dql = "SELECT sd FROM AppBundle:Senders sd WHERE sd.tmp = '".$credentials["tmp"]."' AND sd.mac = '".$credentials["mac"]."'";
			$sender = $em->createQuery($dql)->getSingleResult();

			$time = new \DateTime();

			if ($sender)  
			{
				$notifications = array();
				foreach ($data as $id => $val) 
				{
					$dql = "SELECT s FROM AppBundle:Sensors s WHERE s.idSensor = ".$id;
					$sensor = $em->createQuery($dql)->getSingleResult();

					$measurement = new Measurement();
					$measurement->setIdSensor($sensor);
					$measurement->setValue($val);
					$measurement->setDate($time);
					$em->persist($measurement);
					$em->flush();
					
					$evm = $this->get('app.event_manager');
					$ntf = $evm->fireNotifierEvents($measurement);
					$notifications = array_merge($notifications, $ntf);
				}

				$ml = $this->get('app.mailer');
				$ml->sendNewNotifications($notifications);

				return new Response("<!DOCTYPE html>
				<html>
				<head>
					<title>Persisted data</title>
				</head>
				<body>
					The credential are validated, the data was persisted.
				</body>
				</html>");

			} else 
			{
				return new Response("<!DOCTYPE html>
				<html>
				<head>
					<title>Error Page</title>
				</head>
				<body>
					Invalid credentials.
				</body>
				</html>");
			}
		}	

		/**
		 * @Route("monitor/validate/{encoded_credentials}", name = "generateCredentials" )
		 */
		public function ValidateCredentialsAction($encoded_credentials)
		{
			$credentials = array();
			$enc = $this->get('app.encoder');
			$enc->decodeCredentials($encoded_credentials, $credentials);

			$em = $this->getDoctrine()->getManager();
			$dql = "SELECT sd FROM AppBundle:Senders sd WHERE sd.mac = '".$credentials["mac"]."'";
			$sender = $em->createQuery($dql)->getSingleResult();

			if ($sender) 
			{
				if ($sender->getTmp() != $credentials['tmp'] && ($credentials['attempts']>2 || $sender->getPtmp() != $credentials['tmp'])) 
				{
					return new Response("Received ".$encoded_credentials.". Invalid Credentials");
					
				} else 
				{
					$ntk = (int)microtime(true);
					$sender->setPtmp($sender->getTmp());
					$sender->setTmp($ntk);
					$em->flush(); 

					return new Response("Valid credentials. Now query to persist data with %".$ntk."%");
				}
			}
			else return new Response("Invalid Credentials");
		}
	}

 ?>