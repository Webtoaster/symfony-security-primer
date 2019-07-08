<?php
	
	namespace App\Controller;
	
	use App\Entity\Person;
	use App\Form\RegistrationFormType;
	use App\Form\TermsOfServiceFormType;
	use App\Repository\PersonRepository;
	use App\Security\AppAuthenticator;
	use App\Security\DirectAuthenticator;
	use DateTime;
	use Exception;
	use Psr\Log\LoggerInterface as Logger;
	use Swift_Mailer;
	use Swift_Message;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
	
	//	use Monolog\Logger;
	
	
	/**
	 * @Route("/registration")
	 */
	class RegistrationController extends AbstractController
	{
		
		/**
		 * @var SessionInterface
		 */
		private $session;
		
		private $log;
		
		/**
		 * RegistrationController constructor.
		 *
		 * @param   SessionInterface   $session
		 * @param   Logger             $logger
		 */
		public function __construct(SessionInterface $session, Logger $logger)
		{
			$this->session = $session;
			
			$this->log = $logger;
		}
		
		/**
		 * @Route("/signup", name="app_register")
		 *
		 * @param   Request                        $request
		 * @param   UserPasswordEncoderInterface   $passwordEncoder
		 * @param   GuardAuthenticatorHandler      $guardHandler
		 * @param   AppAuthenticator               $authenticator
		 * @param   PersonRepository               $personRepository
		 *
		 * @throws Exception
		 * @return Response
		 */
		public function register(Request $request,
		                         UserPasswordEncoderInterface $passwordEncoder,
		                         GuardAuthenticatorHandler $guardHandler,
		                         AppAuthenticator $authenticator,
		                         PersonRepository $personRepository): Response
		{
			/*
			 * Remember, the object is User but the actual Entity is Person.
			 */
			$user = new Person();
			$form = $this->createForm(RegistrationFormType::class, $user);
			$form->handleRequest($request);
			
			if ($form->isSubmitted() && $form->isValid()) {
				/*
				 * Get and set the client IP Address for tracking
				 * user abuse.
				 */
				$ip = $request->getClientIp();
				$user->setIpAddress($ip);
				
				/*
				 * Perform Database Maintenance.
				 * Deletes orphaned registrations which do not verify their account
				 * within an hour of starting it.  Set the HasStartedRegistration
				 * flag === TRUE to show the registrations has started.
				 */
				$personRepository->delete_orphaned_registrants();
				$user->setHasStartedRegistration(TRUE);
				
				/*
				 * Concatenate and Insert the names submitted.
				 */
				$tempNameDisplay = implode(' ', array_filter([
					trim($form->get('nameFirst')->getData()),
					trim($form->get('nameMiddle')->getData()),
					trim($form->get('nameLast')->getData()),
				]));
				$user->setNameDisplay($tempNameDisplay);
				
				/*
				 * Set flags for self-registered account operations
				 */
				$user->setIsActive(FALSE);
				$user->setIsRegistered(FALSE);
				$user->setIsVerified(FALSE);
				
				/*
				 * Encode the password
				 */
				$user->setPassword(
					$passwordEncoder->encodePassword(
						$user,
						$form->get('plainPassword')->getData()
					)
				);
				
				/*
				 * Perform the insert of the information.
				 */
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist($user);
				$entityManager->flush();
				
				/*
				 * Get the inserted user's ID.
				 */
				$newPersonId = $user->getId();
				
				/*
				 * If you want to allow them to be logged in right after submitting an
				 * email address and a password, then set the environment variable == TRUE
				 */
				if ($_ENV['AUTO_LOGIN_NEW_USER'] === TRUE) {
					$guardHandler->authenticateUserAndHandleSuccess(
						$user,
						$request,
						$authenticator,
						'main'
					);
				}
				
				/*
				 * Set Session Vars
				 */
				$this->session->clear();
				$this->session->set('person_id', $newPersonId);
				
				$this->session->set('applicant_id', $newPersonId);
				$this->session->set('HasStartedRegistration', TRUE);
				$this->session->set('email', $form->get('email')->getData());
				
				/*
				 * Set the flash message for the next page.
				 */
				$this->addFlash('success', 'New User Created.<br/>There are a couple more steps!');
				
				/*
				 * Redirect to next step.
				 */
				
				return $this->redirectToRoute('app_register_part_2');
			}
			
			return $this->render('registration/registration_form_name_and_login.html.twig', [
				'form' => $form->createView(),
			]);
		}
		
		/**
		 * @Route("/terms_of_service", name="app_register_part_2", requirements={"page"="\d+"})
		 *
		 * @param   Request        $request
		 * @param   Swift_Mailer   $mailer
		 *
		 * @throws Exception
		 * @return Response
		 */
		public function register_part_2(Request $request, Swift_Mailer $mailer): Response
		{
			/**
			 * Make sure they are in new user registration mode.
			 */
			$person_id = 0;
			if (FALSE === $this->session->has('HasStartedRegistration') || FALSE === $this->session->has('applicant_id')) {
				/**
				 * Set the error flash message for the next page.
				 */
				$this->addFlash('error', 'Please start your registration from the beginning.');
				$this->redirectToRoute('app_register');
			} else {
				$person_id = $this->session->get('applicant_id');
			}
			
			/*
			 * Get the user passed in to the URl Parameter "person_id"
			 */
			$em     = $this->getDoctrine()->getManager();
			$person = $em->getRepository(Person::class)->find($person_id);
			
			/*
			 * If there is not a person id association with the value passed, then toss them back to registration.
			 * TODO Setup an exclusions table to prevent abuse.
			 */
			if (!$person) {
				$this->session->clear();
				$this->addFlash('error', 'There is not a user association with this user.');
				
				return $this->redirectToRoute('app_register');
			}
			
			/**
			 * If they have been verified, then send them to home page.
			 */
			if (TRUE === $person->getIsVerified()) {
				return $this->redirectToRoute('app_home');
			}
			
			/**
			 * Remember, the object is User but the actual Entity is Person.
			 */
			$form = $this->createForm(TermsOfServiceFormType::class);
			$form->handleRequest($request);
			
			if ($form->isSubmitted() && $form->isValid() && $form['agreedToTermsAt']->getData() === TRUE) {
				/**
				 *  Make a verification key with just MD5 for now and then insert it into the database.
				 */
				$verification_key = $this->makeVerificationKey($person->getEmail());
				$person->setVerificationKey($verification_key);
				
				/**
				 * Stuff it into an array and then stuff it into a session and pass it on into the email
				 * to be sent later.
				 */
				$url_key = $this->generateUrl('app_email_verification', ['key' => $verification_key,], 0);
				
				$person->setAgreedToTermsAt(new DateTime());
				$em->persist($person);
				$em->flush();
				
				/**
				 * Send Email Message
				 */
				$message = new Swift_Message();
				$message->setSubject($_ENV['VERIFICATION_EMAIL_SUBJECT'])
					->setSender($_ENV['FROM_EMAIL_ADDRESS'], $_ENV['FROM_EMAIL_NAME'])
					->setFrom([
						$_ENV['FROM_EMAIL_ADDRESS'] => $_ENV['FROM_EMAIL_NAME'],
					])
					->setTo([
						$person->getEmail() => $person->getNameDisplay(),
					])
					->setSender($_ENV['FROM_EMAIL_ADDRESS'], $_ENV['FROM_EMAIL_NAME'])
					->setBody(
						$this->renderView(
							'email/_message_email_verification.html.twig',
							[
								'first_name'       => $person->getNameFirst(),
								'to_display_name'  => $person->getNameDisplay(),
								'to_email_address' => $person->getEmail(),
								'url_key'          => $url_key,
							]
						), 'text/html', 'UTF-8'
					);
				$mailer->send($message);
				
				$this->addFlash('success', 'Email Message is Sent.');
				
				/**
				 * Return to the user the Email is Sent message.
				 */
				return $this->render('registration/email_verification_is_sent.html.twig', [
					'first_name'    => $person->getNameFirst(),
					'email_address' => $person->getEmail(),
				]);
			}
			
			return $this->render('registration/registration_form_terms_of_service.html.twig', [
				'form' => $form->createView(),
			]);
		}
		
		/**
		 * This is the URL in the verification email which the user receives.
		 *
		 * @Route("/email_verification/{key}", name="app_email_verification")
		 *
		 * @param   Request                     $request
		 * @param   GuardAuthenticatorHandler   $guardHandler
		 * @param   DirectAuthenticator         $authenticator
		 * @param   PersonRepository            $personRepository
		 *
		 * @throws Exception
		 * @return Response
		 */
		public function register_email_verification_via_link(Request $request,
		                                                     GuardAuthenticatorHandler $guardHandler,
		                                                     DirectAuthenticator $authenticator,
		                                                     PersonRepository $personRepository): Response
		{
			/**
			 * Perform Database Maintenance.
			 * Deletes orphaned registrations which do not verify their account
			 * within an hour of starting it.  Set the HasStartedRegistration
			 * flag === TRUE to show the registrations has started.
			 */
			$personRepository->delete_orphaned_registrants();
			
			//  TODO  Remove or Comment out this logger
			//$this->log->debug('Orphans deleted');
			
			/**
			 * Clear out whatever session vars they have in place.
			 */
			$this->session->clear();
			
			/**
			 * Get the URL Parameter for the key.
			 */
			$key = $request->attributes->get('key');
			
			/**
			 * Get the user passed in to the URl Parameter "person_id"
			 */
			$em     = $this->getDoctrine()->getManager();
			$person = $em->getRepository(Person::class)->findOneBy(['verificationKey' => $key]);
			
			/**
			 * If there is not a person id association with the value passed, then toss them back to registration.
			 * TODO Setup an exclusions table to prevent abuse.
			 */
			if (!$person) {
				$this->session->clear();
				$this->addFlash('error', 'The key is incorrect.  It does not exist in our
				database.  Please restart your signup.');
				
				return $this->redirectToRoute('app_register');
			}
			
			/**
			 * If this user has already verified this email address, Stop Now.
			 * Send give them the template that already shows them the verification is
			 * completed for this email address.
			 */
			if ($person->getIsVerified() === TRUE) {
				//  TODO  Remove or Comment out this logger
				$this->log->debug('isVerified is TRUE.');
				
				return $this->render('registration/email_verification_is_already_completed.html.twig');
			}
			
			/**
			 * Perform the updates where the user's email verification is performed.
			 * Get IP Address for the update to the database.
			 */
			$ip = $request->getClientIp();
			$this->session->set('person_id', $person->getId());
			$person->setVerificationDate(new DateTime());
			$person->setRoles(['ROLE_USER']);
			$person->setVerificationIpAddress($ip);
			$person->setIsActive(TRUE);
			$person->setIsRegistered(TRUE);
			$person->setIsVerified(TRUE);
			$em->persist($person);
			$em->flush();
			
			//  TODO  Remove or Comment out this logger
			//  $this->log->debug('Update is completed.  Sending to authenticator.');
			
			/**
			 * hand the request over to Guard Authenticator.
			 */
			return $guardHandler->authenticateUserAndHandleSuccess(
				$person,
				$request,
				$authenticator,
				'main'
			);
		}
		
		/**
		 * @Route("/email_verification_completed", name="app_email_verification_completed")
		 *
		 * @throws Exception
		 * @return Response
		 */
		public function register_email_verification_completed(): Response
		{
			return $this->render('registration/email_verification_is_successful.html.twig');
		}
		
		/**
		 * @Route("/email_resend", name="app_email_resend")
		 *
		 * @param   Request                        $request
		 * @param   UserPasswordEncoderInterface   $passwordEncoder
		 * @param   GuardAuthenticatorHandler      $guardHandler
		 * @param   AppAuthenticator               $authenticator
		 *
		 * @throws Exception
		 * @return Response
		 */
		public function register_email_resend(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator): Response
		{
			return $this->render('base.html.twig', [
				//	'form' => $form->createView(),
			]);
		}
		
		/**
		 *  Make a URL Key for the Email Verification.
		 *
		 * @param $email_address string
		 *
		 * @return string
		 */
		private function makeVerificationKey(string $email_address)
		{
			return md5($_ENV['APP_SECRET'].$email_address);
		}
		
	}
