<?php 

	namespace AppBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Component\HttpFoundation\Request;

	class SecurityController extends Controller
	{
		/**
		 * @Route("/", name="root")
		 * @Route("/login", name="login")
		 */
	    public function loginAction(Request $request)
	    {

	    	$success = "HI WELCOME TO WAPOSAT ATTENDANCE SYSTEM";
			$authenticationUtils = $this->get('security.authentication_utils');

		    // get the login error if there is one
		    $error = $authenticationUtils->getLastAuthenticationError();

		    // last username entered by the user
		    $lastUsername = $authenticationUtils->getLastUsername();

		    $request->getSession()->getFlashBag()->add('success', 'Welcome to the Death Star, have a magical day!');

		    return $this->render(
		        'security/login.html.twig',
		        array(
		            // last username entered by the user
		            'last_username' => $lastUsername,
		            'error'         => $error,
		            'success' 		=> $success,
		        )
		    );
	    }

	}

 ?>