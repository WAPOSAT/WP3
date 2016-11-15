<?php 

	namespace AppBundle\Service;
	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\Query;

	/**
	* Allows to you to generate and send any email that you need in the application
	*/
	class MailerManager
	{

		private $entityManager;
		private $mailer;
		private $twig;

		public function __construct(EntityManager $entityManager, $mailer, /*\Twig_Environment*/ $twig)
		{
			$this->entityManager = $entityManager;
			$this->mailer = $mailer;
			$this->twig = $twig;
		}


		private $scheduled;
		private $template;
		private $message;

		public function sendNewNotifications($notifications=null, $byEmail = 1, $bySms = 0 )
		{
			//classify by user
			$users_2_not = array();
			$not_per_user = array(array());

			$this->orderNotifications($notifications, $users_2_not, $not_per_user);

			for ($i=0; $i < count($users_2_not); $i++) 
			{ 
				$this->sendEmail($not_per_user[$i], $users_2_not[$i]->getEmail(), 'SE HA DETECTADO UNA ALERTA!!!', "event");
			}

		}

		private function orderNotifications($notifications, &$users_2_not, &$not_per_user)
		{
			if(count($notifications) != 0)
			{
				$users_2_not[] = $notifications[0]->getIdUser();
						
				for ($i=0; $i < count($notifications); $i++) 
				{ 	
					$j=0;
					$saved = 0;
					$times = count($users_2_not); 
					$user_not = $notifications[$i]->getIdUser();
					
					while ($j<$times) 
					{
						if($users_2_not[$j] == $user_not)
						{
							$not_per_user[$j][] = $notifications[$i];
							$saved = 1;
							break;
						}
						$j++;
					}
	
					if ($saved == 0) 
					{
						$users_2_not[$j] = $user_not;
						$not_per_user[$j][] = $notifications[$i];
					}
	
				}
			}
		}

		/***algoritmo de busqueda

			(objeto) user <- idUser <- Scheduled
			(array objetos) bloques_monitoreo <- user
			(array objetos) eventos <- bloque de monitoreo

		***/

		/*public function generateMessage(UserInterface $programmedScheduled)
		{
			
			# Find adress information of the user to send
			
			//Find User
			$user = $this->getDoctrine()->getRepository('UserBundle:Users')->findOneBy(array('uid'=>$id_usuario));

			$bloqueMonitoreo = $this->getDoctrine()->getRepository('UserBundle:Regattendance')->find(array('idUser' => $user->getId()));
			
			for ($i=0; $i < count($bloqueMonitoreo); $i++) 
			{ 
				$em = $this->getDoctrine()->getManager();
        		$query = $em->createQuery('SELECT r FROM UserBundle:Regattendance r ORDER BY r.id DESC');
        		$register = $query->getResult();
			}

			
			$events = $this->getDoctrine()->getRepository('UserBundle:Events')->find(array('id'));




			$this->message = \Swift_Message::newInstance()
			        ->setSubject($programmedScheduled->getSubject())
			        ->setFrom('reporte@waposat.com')
			        ->setTo($user->getEmail())
			        ->setBody(
			            $this->renderView(
			                'UserBundle:Emails:alert.html.twig',
			                array('type' => $type)
			            ),
			            'text/html'
			        )
			;

			return;

		}

		public function send($value='')
		{
				
			$this->get('mailer')->send($message);

			return;
		}*/

		public function sendEmail($info=null, $u_email = 'beenelvi.godoy@gmail.com', $subject="Mailing Error", $format='error')
		{
			$message = \Swift_Message::newInstance()
		        ->setSubject($subject)
		        ->setFrom('juan.basilio@waposat.com')
		        ->setTo($u_email)
		        ->setBody(
		            $this->twig->render(
		                'Email/'.$format.'.html.twig',
		                array('info' => $info)
		            ),
		            'text/html'
		        )
		    ;
		    
		    $this->mailer->send($message);
		    return 0;
		    //return $this->twig->render('Email/'.$format.'.html.twig', array('info' => $info));
		}
	}

?>