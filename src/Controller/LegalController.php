<?php
	
	namespace App\Controller;
	
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	
	/**
	 * Class LegalController
	 *
	 * @Route("/legal")
	 * @package App\Controller
	 */
	class LegalController extends AbstractController
	{
		/**
		 * @Route("/terms_of_service", name="legal_terms_of_service")
		 * @return Response
		 */
		public function terms_of_service(): Response
		{
			return $this->render('legal/terms_of_service.html.twig', [
				'controller_name' => 'LegalController',
			]);
		}
		
		/**
		 * @Route("/terms_of_use", name="legal_terms_of_use")
		 * @return Response
		 */
		public function terms_of_use(): Response
		{
			return $this->render('legal/terms_of_use.html.twig', [
				'controller_name' => 'LegalController',
			]);
		}
		
		/**
		 * @Route("/privacy_policy", name="legal_privacy_policy")
		 * @return Response
		 */
		public function privacy_policy(): Response
		{
			return $this->render('legal/privacy_policy.html.twig', [
				'controller_name' => 'LegalController',
			]);
		}
		
	}
