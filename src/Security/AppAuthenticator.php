<?php
	
	namespace App\Security;
	
	use App\Entity\Person;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
	use Symfony\Component\Routing\RouterInterface;
	use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
	use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
	use Symfony\Component\Security\Core\Security;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Security\Core\User\UserProviderInterface;
	use Symfony\Component\Security\Csrf\CsrfToken;
	use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
	use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
	use Symfony\Component\Security\Http\Util\TargetPathTrait;
	
	/**
	 * Class AppAuthenticator
	 *
	 * @package App\Security
	 */
	class AppAuthenticator extends AbstractFormLoginAuthenticator
	{
		use TargetPathTrait;
		
		/**
		 * @var EntityManagerInterface
		 */
		private $entityManager;
		/**
		 * @var UrlGeneratorInterface
		 */
		private $urlGenerator;
		/**
		 * @var CsrfTokenManagerInterface
		 */
		private $csrfTokenManager;
		/**
		 * @var UserPasswordEncoderInterface
		 */
		private $passwordEncoder;
		
		/**
		 * @var RouterInterface
		 */
		private $router;
		
		/**
		 * AppAuthenticator constructor.
		 *
		 * @param   EntityManagerInterface         $entityManager
		 * @param   UrlGeneratorInterface          $urlGenerator
		 * @param   RouterInterface                $router
		 * @param   CsrfTokenManagerInterface      $csrfTokenManager
		 * @param   UserPasswordEncoderInterface   $passwordEncoder
		 */
		public function __construct(
			EntityManagerInterface $entityManager,
			UrlGeneratorInterface $urlGenerator,
			CsrfTokenManagerInterface $csrfTokenManager,
			UserPasswordEncoderInterface $passwordEncoder)
		{
			$this->entityManager    = $entityManager;
			$this->csrfTokenManager = $csrfTokenManager;
			$this->passwordEncoder  = $passwordEncoder;
			$this->urlGenerator     = $urlGenerator;
		}
		
		/**
		 * @param   Request   $request
		 *
		 * @return bool
		 */
		public function supports(Request $request): bool
		{
			return 'login' === $request->attributes->get('_route')
				&& $request->isMethod('POST');

//			return $request->attributes->get('_route') === 'login'
//				&& $request->isMethod('POST');

//			return 'app_login' === $request->attributes->get('_route')
//				&& $request->isMethod('POST');
		}
		
		/**
		 * @param   Request   $request
		 *
		 * @return array|mixed
		 */
		public function getCredentials(Request $request): Array
		{
			$credentials = [
				'email'      => $request->request->get('login_email'),
				'password'   => $request->request->get('login_password'),
				'csrf_token' => $request->request->get('_csrf_token'),
			];
			
			$request->getSession()->set(Security::LAST_USERNAME, $credentials['email']);
			
			return $credentials;
		}
		
		/**
		 * @param   mixed                   $credentials
		 * @param   UserProviderInterface   $userProvider
		 *
		 * @return Person|object|UserInterface|null
		 */
		public function getUser($credentials, UserProviderInterface $userProvider)
		{
			$token = new CsrfToken('authenticate', $credentials['csrf_token']);
			
			if (!$this->csrfTokenManager->isTokenValid($token)) {
				throw new InvalidCsrfTokenException('Your session expired.  Please try to login again.');
			}
			
			$user = $this->entityManager->getRepository(Person::class)
				->findOneBy([
					'email' => $credentials['email'],
				]);
			
			if (!$user) {
				// fail authentication with a custom error
				throw new CustomUserMessageAuthenticationException('Email could not be found.');
			}
			
			return $user;
		}
		
		/**
		 * @param   mixed           $credentials
		 * @param   UserInterface   $user
		 *
		 * @return bool
		 */
		public function checkCredentials($credentials, UserInterface $user): bool
		{
			return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
		}
		
		/**
		 * @param   Request          $request
		 * @param   TokenInterface   $token
		 * @param   string           $providerKey
		 *
		 * @return RedirectResponse|Response|null
		 */
		public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
		{
			if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
				return new RedirectResponse($targetPath);
			}
			
			// TODO  Make this go to the Dashboard eventually.
			return new RedirectResponse($this->urlGenerator->generate('app_home'));
			//  todo clean this line up since it is unreachable.   throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
		}
		
		/**
		 * @return string
		 */
		public function getLoginUrl(): string
		{
			return $this->urlGenerator->generate('app_login');
		}
	}
