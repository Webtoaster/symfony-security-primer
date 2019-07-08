<?php
	
	namespace App\Controller;
	
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	
	/**
	 * Class AdminController
	 * @Route("/admin")
	 * @IsGranted("ROLE_ADMIN")
	 *
	 * @package App\Controller
	 */
	class AdminController extends AbstractController
	{
		/**
		 * @Route("/admin", name="admin")
		 *
		 * @return Response
		 */
		public function index(): Response
		{
			return $this->render('admin/index.html.twig', [
				'controller_name' => 'AdminController',
			]);
		}
		
		/**
		 * @Route("/control_panel", name="control_panel")
		 * @IsGranted("ROLE_ADMIN")
		 *
		 * @return Response
		 */
		public function control_panel(): Response
		{
			/*
			 * See redundant in the dictionary
			 */
			$this->denyAccessUnlessGranted('ROLE_ADMIN', 'Attempted Breech.', 'User tried to access a page without having ROLE_ADMIN');
		}
		
	}
