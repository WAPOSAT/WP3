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
				$this->sendEmail($not_per_user[$i], $users_2_not[$i]->getEmail(), 'CUIDADO!. SE HA DETECTADO UNA ALERTA.', 'event');
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

		public function sendEmail($info=null, $u_email = 'beenelvi.godoy@gmail.com', $subject="Mailing Error", $format='error')
		{
			$message = \Swift_Message::newInstance()
		        ->setSubject($subject)
		        ->setFrom('jhosept@waposat.com')
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
