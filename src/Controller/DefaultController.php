<?php
	
	namespace App\Controller;
	
	use App\Repository\PersonRepository;
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
		
		/**
		 * @Route("/test", name="app_test")
		 * @param   PersonRepository   $personRepository
		 *
		 * @return Response
		 */
		public function test(PersonRepository $personRepository)
		{
			$personRepository->delete_orphaned_registrants();
			
			return $this->render('default/index.html.twig', [
				'controller_name' => 'DefaultController',
			]);
		}
		
	}
