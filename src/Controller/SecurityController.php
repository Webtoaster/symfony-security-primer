<?php /** @noinspection ThrowRawExceptionInspection */
	
	namespace App\Controller;
	
	use Exception;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
	
	class SecurityController extends AbstractController
	{
		/**
		 * @Route("/security", name="security")
		 */
		public function index()
		{
			return $this->render('security/index.html.twig', [
				'controller_name' => 'SecurityController',
			]);
		}
		
		/**
		 * @Route("/login", name="app_login")
		 *
		 * @param   AuthenticationUtils   $authenticationUtils
		 *
		 * @return Response
		 */
		public function login(AuthenticationUtils $authenticationUtils): Response
		{
			/**
			 * Get last authentication error if one exists from the Auth Utils class.
			 */
			$error = $authenticationUtils->getLastAuthenticationError();
			
			/**
			 * Get the last email which this Person submitted to attempt to authenticate.
			 */
			$lastEmail = $authenticationUtils->getLastUsername();
			
			return $this->render('security/login.html.twig', [
				'last_email' => $lastEmail,
				'error'      => $error,
			]);
		}
		
		/**
		 * @Route("/logout", name="app_logout", methods={"GET"})
		 * @throws Exception
		 */
		public function logout()
		{
			throw new Exception('Don\'t forget to activate logout in security.yaml');
		}
		
		/**
		 * @Route("/change-password", name="app_change_password")
		 */
		public function change_password()
		{
		
		
		
		
		
		
		
		}
		
		/**
		 * @Route("/recover-password", name="app_recover_password")
		 */
		public function recover_password()
		{
		}
		
		/**
		 * @Route("/landing", name="app_post_login_landing")
		 */
		public function post_login_landing()
		{
			return $this->render('security/post_login_landing.html.twig', [
			]);
		}
		
	}
