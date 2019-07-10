<?php
	
	namespace App\Controller;
	
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	
	/**
	 * Class DefaultController
	 *
	 * @package App\Controller
	 */
	class DefaultController extends AbstractController
	{
		/**
		 * @Route("/", name="app_home")
		 * @return Response
		 */
		public function index()
		{
			return $this->render('default/index.html.twig', [
				'controller_name' => 'DefaultController',
			]);
		}
		
	}
