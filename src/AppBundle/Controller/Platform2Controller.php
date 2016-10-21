<?php 

	namespace AppBundle\Controller;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Serializer\Encoder\JsonEncoder;
	//use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
	use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
	use Symfony\Component\Serializer\Serializer;

	/**
	* 
	*/
	class Platform2Controller extends Controller
	{
			
		/**
		 * @Route("/v2/dashboard", name="dashboard2")
		 */
		public function dashboardAction()
		{
			
			//Verify is user is logged
			if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
			{
        		throw $this->createAccessDeniedException();
    		}
    		$user = $this->getUser();
			
    		$em = $this->getDoctrine()->getManager();

			$dql = "SELECT up FROM AppBundle:UsersBlocks up JOIN up.idBlock b JOIN b.idBlockType t WHERE (up.idUser = ".$user->getId()." AND t.blockType = 1)";
    		$query = $em->createQuery($dql);
    		$u_plants = $query->getResult();

    		$StaticInfo = [];

    		$PlantBlock = array();

    		$lD = $this->get('app.dataloader');
    		$lD->setupUser($user);
    		$lD->retrieveProcessData();

    		foreach ($u_plants as $plant) 
    		{
    			$PlantBlock[] = $lD->LoadAction($plant->getIdBlock()->getId(), $user->getId());
    		}

    		if (count($u_plants)==1) 
    		{
    			$StaticInfo = $PlantBlock[0];
    		} else 
    		{
    			//Nothing for now
    		}

    		return new Response(json_encode($StaticInfo));

		}


		/**
		 * @Route("/v2/dashboard/process/{idProcess}", name="processBlock2")
		 */
		public function processBlockAction($idProcess)
		{
			//Verify is user is logged
			if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
			{
        		throw $this->createAccessDeniedException();
    		}
    		$user = $this->getUser();
			
			
			$lD = $this->get('app.dataloader');
			$lD->setupUser($user);
			$lD->retrieveSensorData(1, 0, 1, 0, 0, 0);
			$lD->retrieveStationData(1,1,1,0);
			$lD->retrieveProcessData(1);

			$Process = $lD->LoadAction($idProcess, 0);

			/*$encoders = array(new JsonEncoder());
			$normalizers = array(new ObjectNormalizer());

			$serializer = new Serializer($normalizers, $encoders);

			$jsonContent = $serializer->serialize($processBlock, 'json');*/
    		return new Response(json_encode($Process));
			
		}

		/**
		 * @Route("/v2/dashboard/update/process/{idProcess}", name="processBlockUpdate2")
		 */
		public function processBlockUpdateAction($idProcess)
		{
			//Verify is user is logged
			if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
			{
        		throw $this->createAccessDeniedException();
    		}
    		$user = $this->getUser();

			$lD = $this->get('app.dataloader');
			$lD->setupUser($user);
			$lD->retrieveSensorData(0, 0, 1, 0, 0, 0);
			$lD->retrieveStationData(1,1,1,0);
			$lD->retrieveProcessData(1);

			$Process = $lD->LoadAction($idProcess, 0);


    		return new Response(json_encode($Process));
			
		}

		/**
		 * @Route("/v2/dashboard/station/{idStation}/sensor/{idSensor}/long/{long}", name="sensorData2")
		 */
		public function sensorDataAction($idStation, $idSensor, $long)
		{
			//Verify is user is logged
			if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
			{
        		throw $this->createAccessDeniedException();
    		}
    		$user = $this->getUser();
			
			
			$lD = $this->get('app.dataloader');
			$lD->setupUser($user);
			$lD->retrieveSensorData(1, 1, 1, $long);
			$lD->retrieveStationData();
			$lD->retrieveProcessData();

			$Station = $lD->SensorDataAction($idSensor, $idStation);

    		return new Response(json_encode($Station));
			
		}

		/**
		 * @Route("/v2/dashboard/station/{idStation}/sensor/{idSensor}/lastid/{lastId}", name="sensorDataUpdate2")
		 */
		public function sensorDataUpdateAction($idSensor, $idStation, $lastId)
		{
			//Verify is user is logged
			if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
			{
        		throw $this->createAccessDeniedException();
    		}
    		$user = $this->getUser();
			
			$lD = $this->get('app.dataloader');
			$lD->setupUser($user);
    		$lD->retrieveSensorData(1, 0, 0, 0, 1, $lastId);
			$lD->retrieveStationData();
			$lD->retrieveProcessData();

			$Station = $lD->SensorDataAction($idSensor, $idStation);

    		return new Response(json_encode($Station));
			
		}

		/**
		 * @Route("/v2/dashboard/alerts/", name="alertData2")
		 */
		public function AlertAction()
		{
			//Verify is user is logged
			if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
			{
        		throw $this->createAccessDeniedException();
    		}
    		$user = $this->getUser();
			
			$lD = $this->get('app.dataloader');
			$lD->setupUser($user);
			$Station = $lD->AlertDataAction(/*, $idUser*/);

    		return new Response(json_encode($Station));
			
		}

		/**
		 * @Route("/v2/dashboard/alerts/update", name="alertDataUpdate2")
		 */
		public function AlertUpdateAction()
		{
			//Verify is user is logged
			if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
			{
        		throw $this->createAccessDeniedException();
    		}
    		$user = $this->getUser();
			
			
			$lD = $this->get('app.dataloader');
			$lD->setupUser($user);
			$Station = $lD->AlertDataAction(1/*, $idUser*/);

    		return new Response(json_encode($Station));
			
		}

	}

 ?>