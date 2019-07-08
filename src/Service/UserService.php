<?php
	
	namespace App\Service;
	
	use Symfony\Component\Security\Core\Security;
	use Symfony\Component\Security\Core\User\UserInterface;
	
	class UserService
	{
		private $security;
		
		public function __construct(Security $security)
		{
			// Avoid calling getUser() in the constructor: auth may not
			// be complete yet. Instead, store the entire Security object.
			$this->security = $security;
		}
		
		/**
		 * @return UserInterface|null
		 */
		public function getUserInformation(): ?UserInterface
		{
			return $this->security->getUser();
			//  return $user;
		}
	}
