<?php 

	namespace AppBundle\Controller;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;


	/**
	* 
	*/
	class ViewController extends Controller
	{
		/**
		 * @Route("/alertas", name="alert")
		 * @Route("/scada", name="scada" )
		 */
		public function indexAction()
		{
			/*$templating = $this->container->get('templating');
			$html = $templating->render('wapo/index.html.twig');
			return new Response($html);*/

			//return $this->render('wapo/index.html.twig');


			$request = Request::createFromGlobals();
			$path = $request->getPathInfo();
			$var = 1;
			if ($path == "/alertas") 
			{
				$var = 1;
			} else 
			{
				$var = 2;
			}
			
			return $this->render('index.html.twig', array("seleccion"=>$var, "path"=>$path));
		}

		/**
		 * @Route("/about")
		 */

		public function aboutAction()
		{
			return $this->render('wapo/about.html.twig');
		}

		/**
		 * @Route("/contact")
		 */

		public function contactAction()
		{
			return $this->render('wapo/contact.html.twig');
		}

		/**
		 * @Route("/freestations")
		 */

		public function freestationsAction()
		{
			return $this->render('wapo/freestations.html.twig');
		}

	}
 ?>