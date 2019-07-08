<?php
	
	namespace App\DataFixtures;
	
	use App\Entity\Person;
	use DateTime;
	use Doctrine\Bundle\FixturesBundle\Fixture;
	use Doctrine\Common\Persistence\ObjectManager;
	use Exception;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	
	class PersonFixtures extends Fixture
	{
		
		private $encoder;
		
		public function __construct(UserPasswordEncoderInterface $encoder)
		{
			$this->encoder = $encoder;
		}
		
		/**
		 * @param   ObjectManager   $manager
		 *
		 * @throws Exception
		 */
		public function load(ObjectManager $manager)
		{
			$person = new Person();
			
			$person->setEmail($_ENV['EMAIL']);
			$person->setPassword($this->encoder->encodePassword(
				$person, $_ENV['PASSWORD']
			));
			
			$person->setNameFirst($_ENV['NAME_FIRST']);
			$person->setNameMiddle($_ENV['NAME_MIDDLE']);
			$person->setNameLast($_ENV['NAME_LAST']);
			$person->setNameDisplay($_ENV['NAME_DISPLAY']);
			
			$person->setMailingAddressLine1('1600 Pennsylvania Avenue');
			$person->setMailingAddressCity('Washington');
			$person->setMailingAddressState('DC');
			$person->setMailingAddressZipCode('22001');
			$person->setMailingAddressCountry('US');
			
			$person->setPhysicalAddressLine1('1600 Pennsylvania Avenue');
			$person->setPhysicalAddressCity('Washington');
			$person->setPhysicalAddressState('DC');
			$person->setPhysicalAddressZipCode('22001');
			
			$person->setPhoneHome($_ENV['PHONE_HOME']);
			$person->setPhoneMobile($_ENV['PHONE_MOBILE']);
			$person->setPhoneWork($_ENV['PHONE_WORK']);

			$person->setVerificationKey(MD5(microtime()));
			$person->setVerificationDate(new DateTime());
			$person->setVerificationIpAddress('127.0.0.1');
			$person->setIpAddress('127.0.0.1');
			
			$person->setTermsId(1);
			$person->setAgreedToTermsAt(new DateTime());

			$person->setIsActive(TRUE);
			$person->setIsVerified(TRUE);
			$person->setIsRegistered(TRUE);
			$person->setHasStartedRegistration(TRUE);
			
			$person->setRoles([
				'ROLE_SUPER_ADMIN'
				
				]);
			
			
			$manager->persist($person);
			$manager->flush();
		}
	}
