<?php
	
	/** @noinspection ClassNameCollisionInspection */
	
	namespace App\Entity;
	
	use DateTime;
	use DateTimeInterface;
	use Doctrine\ORM\Mapping as ORM;
	use Exception;
	use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Validator\Constraints as Assert;
	
	/**
	 * @package App\Entity
	 *
	 * Class Person
	 *
	 * @ORM\Table(
	 *     name="person",
	 *     indexes={
	 *          @ORM\Index(name="idx_person_name_first",                columns={"name_first"}),
	 *          @ORM\Index(name="idx_person_name_last",                 columns={"name_last"}),
	 *          @ORM\Index(name="idx_person_phone_mobile",              columns={"phone_mobile"}),
	 *          @ORM\Index(name="idx_person_phone_work",                columns={"phone_work"}),
	 *          @ORM\Index(name="idx_person_phone_home",                columns={"phone_home"}),
	 *          @ORM\Index(name="idx_person_email",                     columns={"email"}),
	 *          @ORM\Index(name="idx_person_password_recovery_key",     columns={"password_recovery_key"}),
	 *          @ORM\Index(name="idx_person_verification_key",          columns={"verification_key"}),
	 *          @ORM\Index(name="idx_person_created_at",                columns={"created_at"})
	 *          }
	 * )
	 *
	 * @ORM\Entity(
	 *     repositoryClass="App\Repository\PersonRepository",
	 * )
	 *
	 * @ORM\HasLifecycleCallbacks()
	 *
	 * @UniqueEntity(fields={"email"}, message="There is already an account with this Email Address.")
	 *
	 */
	class Person implements UserInterface
	{
		
		/**
		 * Person constructor.
		 * Herein, use this for managing the created_at and updated_at fields in the table.
		 *
		 * @throws Exception
		 */
		public function __construct()
		{
			/**
			 * Handle the dates fields
			 */
			$now = new DateTime();
			
			if ($this->getCreatedAt() === NULL) {
				$this->setCreatedAt($now);
			}
			
			$this->createdAt = $now;
			
			/**
			 * Concatenate and Insert the names submitted if the display_name is not assigned.
			 */
			if ($this->nameDisplay === NULL) {
				$this->setNameDisplay(
					implode(' ',
						array_filter([
							trim($this->nameFirst),
							trim($this->nameMiddle),
							trim($this->nameLast),
							trim($this->nameSuffix),
						])
					)
				);
			}
		}
		
		/*              PRIMARY KEY FIELD            */
		/*              PRIMARY KEY FIELD            */
		/*              PRIMARY KEY FIELD            */
		/*              PRIMARY KEY FIELD            */
		/**
		 * @var int
		 *
		 * @ORM\Column(
		 *     name="id",
		 *     type="integer",
		 *     nullable=false,
		 *     options={"unsigned"=true,"comment"="primary key for person"}
		 * )
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="IDENTITY")
		 */
		private $id;
		
		/*              NAME FIELDS            */
		/*              NAME FIELDS            */
		/*              NAME FIELDS            */
		/*              NAME FIELDS            */
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="name_display",
		 *     type="string",
		 *     length=108,
		 *     nullable=true,
		 *     options={"default"="NULL","comment"="display name"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[a-zA-Z0-9\s.\-_,]+$/g",
		 *     match=false,
		 *     message="Only enter letters, numbers and spaces in Display Name."
		 * )
		 */
		private $nameDisplay = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="name_first",
		 *     type="string",
		 *     length=32,
		 *     nullable=false,
		 *     options={"comment"="first name"}
		 * )
		 *
		 * @Assert\NotBlank(
		 *     message="You must enter a First Name.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotNull(
		 *     message="You must enter a First Name.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Length(
		 *     min = 1,
		 *     max = 50,
		 *     minMessage = "The First Name must be at least {{ limit }} characters in Length.",
		 *     maxMessage = "The First Name must be no longer than {{ limit }} characters in Length.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[a-zA-Z\-]+$/g",
		 *     match=false,
		 *     message="Please enter only Letters in the First Name.",
		 *     groups={"registration"}
		 * )
		 */
		private $nameFirst;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="name_middle",
		 *     type="string",
		 *     length=32,
		 *     nullable=true,
		 *     options={"default"="NULL","comment"="middle name"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[a-zA-Z\-]+$/g",
		 *     match=false,
		 *     message="Please enter only Letters in the Middle Name.",
		 *     groups={"registration"}
		 * )
		 *
		 */
		private $nameMiddle = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *      name="name_last",
		 *      type="string",
		 *      length=32,
		 *      nullable=false,
		 *      options={"comment"="last name"}
		 * )
		 *
		 * @Assert\NotBlank(
		 *     message="You must enter a Last Name.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotNull(
		 *     message="You must enter a Last Name.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Length(
		 *     min = 2,
		 *     max = 50,
		 *     minMessage = "The Last Name must be at least {{ limit }} characters in Length.",
		 *     maxMessage = "The Last Name must be no longer than {{ limit }} characters in Length.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[a-zA-Z\-]+$/g",
		 *     match=false,
		 *     message="Please enter only Letters in the Last Name.",
		 *     groups={"registration"}
		 * )
		 */
		private $nameLast;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="name_suffix",
		 *     type="string",
		 *     length=12,
		 *     nullable=true,
		 *     options={"default"="NULL","comment"="suffix"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[a-zA-Z\-]+$/g",
		 *     match=false,
		 *     message="Please enter only Letters in the Suffix.",
		 *     groups={"registration"}
		 * )
		 */
		private $nameSuffix = NULL;
		
		/*              COMMUNICATION FIELDS            */
		/*              COMMUNICATION FIELDS            */
		/*              COMMUNICATION FIELDS            */
		/*              COMMUNICATION FIELDS            */
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="phone_home",
		 *     type="string",
		 *     length=12,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9\-\(\)\/\+\s]*$/s",
		 *     match=false,
		 *     message="Please enter only a phone numbers in Home Phone.",
		 *     groups={"registration"}
		 * )
		 */
		private $phoneHome = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="phone_mobile",
		 *     type="string",
		 *     length=12,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9\-\(\)\/\+\s]*$/s",
		 *     match=false,
		 *     message="Please enter only a phone numbers in Mobile Phone.",
		 *     groups={"registration"}
		 * )
		 */
		private $phoneMobile = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="phone_fax",
		 *     type="string",
		 *     length=12,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9\-\(\)\/\+\s]*$/s",
		 *     match=false,
		 *     message="Please enter only a phone numbers in Fax Number.",
		 *     groups={"registration"}
		 * )
		 */
		private $phoneFax = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="phone_work",
		 *     type="string",
		 *     length=12,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9\-\(\)\/\+\s]*$/s",
		 *     match=false,
		 *     message="Please enter only a phone numbers in Home Phone.",
		 *     groups={"registration"}
		 * )
		 */
		private $phoneWork = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="phone_work_extension",
		 *     type="string",
		 *     length=6,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9\-\(\)\/\+\s]*$/s",
		 *     match=false,
		 *     message="Please enter numbers in the Extension.",
		 *     groups={"registration"}
		 * )
		 */
		private $phoneWorkExtension = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="email",
		 *     type="string",
		 *     length=180,
		 *     nullable=false,
		 *     unique=true
		 * )
		 *
		 * @Assert\Email(
		 *     message="The Email Addressis not a valid.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotBlank(
		 *     message="The Email Address cannot be empty or blank.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotNull(
		 *     message="The Email Address cannot be empty or blank.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Unique(
		 *     message="There is already an account with this Email Address.",
		 *     groups={"registration"}
		 * )
		 */
		private $email;
		
		/*              MAILING ADDRESS FIELDS            */
		/*              MAILING ADDRESS FIELDS            */
		/*              MAILING ADDRESS FIELDS            */
		/*              MAILING ADDRESS FIELDS            */
		
		/**
		 * @var string
		 *
		 * @ORM\Column(
		 *     name="mailing_address_line1",
		 *     type="string",
		 *     length=128,
		 *     nullable=false,
		 *     options={"fixed"=true,"comment"="mailing address line 1"}
		 * )
		 *
		 * @Assert\NotBlank(
		 *     message="Line 1 of your Mailing Address is Required.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotNull(
		 *     message="Line 1 of your Mailing Address is Required.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Length(
		 *     min="8",
		 *     max="128",
		 *     minMessage="Line 1 of your Mailing Address is too short. (Minimum of {{ limit }} characters)",
		 *     maxMessage="Line 1 of your Mailing Address is too long. (Maximum of {{ limit }} characters)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^\d+\s[a-zA-Z0-9\s\.]+/s",
		 *     match=false,
		 *     message="Please enter only a propper Address in Line 1 of the Mailing Address. (i.e. ##### Street Name Dr.)",
		 *     groups={"registration"}
		 * )
		 */
		private $mailingAddressLine1;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="mailing_address_line2",
		 *     type="string",
		 *     length=128,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true,"comment"="mailing address line 1"}
		 * )
		 *
		 * @Assert\Length(
		 *     max="128",
		 *     maxMessage="Line 2 of your Mailing Address is too long. (Maximum of {{ Limit }} characters)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9a-zA-Z\s\.\#]+/s",
		 *     match=false,
		 *     message="Please enter only a propper Address in Line 2 of the Mailing Address.",
		 *     groups={"registration"}
		 * )
		 */
		private $mailingAddressLine2 = NULL;
		
		/**
		 * @var string
		 *
		 * @ORM\Column(
		 *     name="mailing_address_city",
		 *     type="string",
		 *     length=128,
		 *     nullable=false,
		 *     options={"fixed"=true,"comment"="mailing address city"}
		 * )
		 *
		 * @Assert\NotBlank(
		 *     message="Please enter a Mailing City.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotNull(
		 *     message="Please enter a Mailing City.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Length(
		 *     min="2",
		 *     max="128",
		 *     minMessage="The City of the Mailing Address is too short. (Minimum of {{ Limit }} characters)",
		 *     maxMessage="The City of the Mailing Address is too long. (Maximum of {{ Limit }} characters)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9a-zA-Z\s\.\#]+/s",
		 *     match=false,
		 *     message="Please enter only letters, numbers and spaces the Mailing City.",
		 *     groups={"registration"}
		 * )
		 */
		private $mailingAddressCity;
		
		/**
		 * @var string
		 *
		 * @ORM\Column(
		 *     name="mailing_address_state",
		 *     type="string",
		 *     length=2,
		 *     nullable=false,
		 *     options={"fixed"=true,"comment"="mailing address state"}
		 * )
		 *
		 * @Assert\Length(
		 *     max="2",
		 *     maxMessage="Please select a Mailing Address State.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[a-zA-Z]{2}/s",
		 *     match=false,
		 *     message="Please select a Mailing Address State.",
		 *     groups={"registration"}
		 * )
		 */
		private $mailingAddressState = 'TX';
		
		/**
		 * @var string
		 *
		 * @ORM\Column(
		 *     name="mailing_address_zip_code",
		 *     type="string",
		 *     length=16,
		 *     nullable=false,
		 *     options={"fixed"=true,"comment"="mailing address zip code"}
		 * )
		 *
		 * @Assert\NotBlank(
		 *     message="Please enter a Mailing Zip/Postal Code consisting of 5 or 9 digit format. (12345 or 12345-6789)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotNull(
		 *     message="Please enter a Mailing Zip/Postal Code consisting of 5 or 9 digit format. (12345 or 12345-6789)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9]{5}(-[0-9]{4})?$/s",
		 *     match=false,
		 *     message="Please enter a Mailing Zip/Postal Code consisting of 5 or 9 digit format. (12345 or 12345-6789)",
		 *     groups={"registration"}
		 * )
		 *
		 */
		private $mailingAddressZipCode;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="mailing_address_country",
		 *     type="string",
		 *     length=2,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true,"comment"="mailing address country code"}
		 * )
		 *
		 * @Assert\Country(
		 *     message="Please enter a correct Mailing County Code consisting of Two Letters. (i.e. US or MX)",
		 *     groups={"registration"}
		 * )
		 */
		private $mailingAddressCountry = 'US';
		
		/*              PHYSICAL ADDRESS FIELDS            */
		/*              PHYSICAL ADDRESS FIELDS            */
		/*              PHYSICAL ADDRESS FIELDS            */
		/*              PHYSICAL ADDRESS FIELDS            */
		
		/**
		 * @var string
		 *
		 * @ORM\Column(
		 *     name="physical_address_line1",
		 *     type="string",
		 *     length=128,
		 *     nullable=false,
		 *     options={"fixed"=true,"comment"="physical address line 1"}
		 * )
		 *
		 * @Assert\NotBlank(
		 *     message="Line 1 of your Physical Address is Required.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotNull(
		 *     message="Line 1 of your Physical Address is Required.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Length(
		 *     min="8",
		 *     max="128",
		 *     minMessage="Line 1 of your Physical Address is too short. (Minimum of {{ limit }} characters)",
		 *     maxMessage="Line 1 of your Physical Address is too long. (Maximum of {{ limit }} characters)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^\d+\s[a-zA-Z0-9\s\.]+/s",
		 *     match=false,
		 *     message="Please enter only a propper Address in Line 1 of the Physical Address. (i.e. ##### Street Name Dr.)",
		 *     groups={"registration"}
		 * )
		 */
		private $physicalAddressLine1;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="physical_address_line2",
		 *     type="string",
		 *     length=128,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true,"comment"="physical address line 1"}
		 * )
		 *
		 * @Assert\Length(
		 *     max="128",
		 *     maxMessage="Line 2 of your Physical Address is too long. (Maximum of {{ Limit }} characters)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9a-zA-Z\s\.\#]+/s",
		 *     match=false,
		 *     message="Please enter only a propper Address in Line 2 of the Physical Address.",
		 *     groups={"registration"}
		 * )
		 */
		private $physicalAddressLine2 = NULL;
		
		/**
		 * @var string
		 *
		 * @ORM\Column(
		 *     name="physical_address_city",
		 *     type="string",
		 *     length=128,
		 *     nullable=false,
		 *     options={"fixed"=true,"comment"="physical address city"}
		 * )
		 *
		 * @Assert\NotBlank(
		 *     message="Please enter a Physical City.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotNull(
		 *     message="Please enter a Physical City.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Length(
		 *     min="2",
		 *     max="128",
		 *     minMessage="The City of the Physical Address is too short. (Minimum of {{ Limit }} characters)",
		 *     maxMessage="The City of the Physical Address is too long. (Maximum of {{ Limit }} characters)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9a-zA-Z\s\.\#]+/s",
		 *     match=false,
		 *     message="Please enter only letters, numbers and spaces the Physical City.",
		 *     groups={"registration"}
		 * )
		 */
		private $physicalAddressCity;
		
		/**
		 * @var string
		 *
		 * @ORM\Column(
		 *     name="physical_address_state",
		 *     type="string",
		 *     length=2,
		 *     nullable=false,
		 *     options={"fixed"=true,"comment"="physical address state"}
		 * )
		 *
		 * @Assert\Length(
		 *     max="2",
		 *     maxMessage="Please select a Physical Address State.",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[a-zA-Z]{2}/s",
		 *     match=false,
		 *     message="Please select a Physical Address State.",
		 *     groups={"registration"}
		 * )
		 */
		private $physicalAddressState = 'TX';
		
		/**
		 * @var string
		 *
		 * @ORM\Column(
		 *     name="physical_address_zip_code",
		 *     type="string",
		 *     length=16,
		 *     nullable=false,
		 *     options={"fixed"=true,"comment"="physical address zip code"}
		 * )
		 *
		 * @Assert\NotBlank(
		 *     message="Please enter a Physical Zip/Postal Code consisting of 5 or 9 digit format. (12345 or 12345-6789)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\NotNull(
		 *     message="Please enter a Physical Zip/Postal Code consisting of 5 or 9 digit format. (12345 or 12345-6789)",
		 *     groups={"registration"}
		 * )
		 *
		 * @Assert\Regex(
		 *     pattern="/^[0-9]{5}(-[0-9]{4})?$/s",
		 *     match=false,
		 *     message="Please enter a Physical Zip/Postal Code consisting of 5 or 9 digit format. (12345 or 12345-6789)",
		 *     groups={"registration"}
		 * )
		 *
		 */
		private $physicalAddressZipCode;
		
		/*               SECURITY FIELDS            */
		/*               SECURITY FIELDS            */
		/*               SECURITY FIELDS            */
		/*               SECURITY FIELDS            */
		/**
		 * The Password field is Nullable because this table can hold mere contact information based on
		 * its purpose is to carry information about persons.
		 *
		 * Be sure to use FORM LEVEL validation for this field with a Form Class implementation of
		 * of validation or via Form Model Assertion or Ultimately a Password Validation Callback.
		 *
		 * @var string
		 *
		 * @ORM\Column(
		 *     name="password",
		 *     type="string",
		 *     length=255,
		 *     nullable=true
		 * )
		 */
		private $password = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="password_recovery_key",
		 *     type="string",
		 *     length=32,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true,"comment"="Key to be included in the verification email"},
		 * )
		 */
		private $passwordRecoveryKey = NULL;
		
		/**
		 * @var DateTime|null
		 *
		 * @ORM\Column(
		 *     name="password_recovery_date",
		 *     type="datetime",
		 *     nullable=true,
		 *     options={"default"="NULL","comment"="Date password recovery was made."}
		 * )
		 */
		private $passwordRecoveryDate = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="password_recovery_ip_address",
		 *     type="string",
		 *     length=39,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true,"comment"="IP Address where the password request was made."}
		 * )
		 */
		private $passwordRecoveryIpAddress = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="ip_address",
		 *     type="string",
		 *     length=39,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true,"comment"="ip address where the Person was submitted from."}
		 * )
		 */
		private $ipAddress = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="roles",
		 *     type="json",
		 *     length=0,
		 *     nullable=true,
		 *     options={"default"="NULL"}
		 * )
		 */
		private $roles = [];
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="verification_key",
		 *     type="string",
		 *     length=32,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true,"comment"="Key to be included in the verification email"}
		 * )
		 */
		private $verificationKey = NULL;
		
		/**
		 * @var DateTime|null
		 *
		 * @ORM\Column(
		 *     name="verification_date",
		 *     type="datetime",
		 *     nullable=true,
		 *     options={"default"="NULL","comment"="Date and time verification of email address was performed."}
		 * )
		 */
		private $verificationDate = NULL;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(
		 *     name="verification_ip_address",
		 *     type="string",
		 *     length=39,
		 *     nullable=true,
		 *     options={"default"="NULL","fixed"=true,"comment"="IP Address where the verification was made from."}
		 * )
		 */
		private $verificationIpAddress = NULL;
		
		/**
		 * @var DateTime|null
		 *
		 * @ORM\Column(
		 *     name="updated_at",
		 *     type="datetime",
		 *     nullable=true,
		 *     options={"default"="NULL","comment"="ts when updated"}
		 * )
		 */
		private $updatedAt = NULL;
		
		/**
		 * @var DateTime|null
		 *
		 * @ORM\Column(
		 *     name="created_at",
		 *     type="datetime",
		 *     nullable=true,
		 *     options={"default"="NULL","comment"="ts when inserted"}
		 * )
		 */
		private $createdAt = NULL;
		
		/**
		 * @var bool
		 *
		 * @ORM\Column(
		 *     name="has_started_registration",
		 *     type="boolean",
		 *     nullable=false,
		 *     options={"comment"="Has this person started registration"}
		 * )
		 */
		private $hasStartedRegistration = 0;
		
		/**
		 * @var bool
		 *
		 * @ORM\Column(
		 *     name="is_active",
		 *     type="boolean",
		 *     nullable=false,
		 *     options={"comment"="is record active"}
		 * )
		 */
		private $isActive = 0;
		
		/**
		 * @var bool
		 *
		 * @ORM\Column(
		 *     name="is_verified",
		 *     type="boolean",
		 *     nullable=false,
		 *     options={"comment"="is email address verified"}
		 * )
		 */
		private $isVerified = 0;
		
		/**
		 * @var bool
		 *
		 * @ORM\Column(
		 *     name="is_registered",
		 *     type="boolean",
		 *     nullable=false,
		 *     options={"comment"="is record registered"}
		 * )
		 */
		private $isRegistered = 0;
		
		/**
		 * @var DateTime|null
		 *
		 * @ORM\Column(
		 *     name="agreed_to_terms_at",
		 *     type="datetime",
		 *     nullable=true,
		 *     options={"default"="NULL","comment"="ts when tos was agreed to"}
		 * )
		 */
		private $agreedToTermsAt = NULL;
		
		/**
		 * @var int
		 *
		 * @ORM\Column(
		 *     name="terms_id",
		 *     type="integer",
		 *     nullable=true,
		 *     options={"unsigned"=true,"comment"="Future Forein Key field to more complex legal framework."}
		 * )
		 */
		private $termsId = 1;
		
		/*                GETTERS AND SETTERS            */
		/*                GETTERS AND SETTERS            */
		/*                GETTERS AND SETTERS            */
		/*                GETTERS AND SETTERS            */
		
		/**
		 * @return DateTime|null
		 */
		public function getAgreedToTermsAt(): ?DateTime
		{
			return $this->agreedToTermsAt;
		}
		
		/**
		 * @param   DateTime|null   $agreedToTermsAt
		 *
		 * @return Person
		 */
		public function setAgreedToTermsAt(?DateTime $agreedToTermsAt): self
		{
			$this->agreedToTermsAt = $agreedToTermsAt;
			
			return $this;
		}
		
		/**
		 * @return int
		 */
		public function getTermsId(): int
		{
			return $this->termsId;
		}
		
		/**
		 * @param   int   $termsId
		 *
		 * @return Person
		 */
		public function setTermsId(int $termsId): self
		{
			$this->termsId = $termsId;
			
			return $this;
		}
		
		/**
		 * @return int|null
		 */
		public function getId(): ?int
		{
			return $this->id;
		}
		
		/**
		 * @return string|null
		 */
		public function getEmail(): ?string
		{
			return $this->email;
		}
		
		/**
		 * @param   string   $email
		 *
		 * @return Person
		 */
		public function setEmail(string $email): self
		{
			$this->email = $email;
			
			return $this;
		}
		
		/**
		 * A visual identifier that represents this user.
		 *
		 * @see UserInterface
		 */
		public function getUsername(): string
		{
			return (string)$this->email;
		}
		
		/**
		 * @return array
		 * @see UserInterface
		 */
		public function getRoles(): array
		{
			/*
			 * Added the typecasting to tell PHPStorm to that it will not produce a possible fatal error
			 */
			$roles = (array)$this->roles;
			
			/**
			 * Make sure every user has a ROLE_USER entry in the system.
			 */
			$roles[] = 'ROLE_USER';
			
			return array_unique($roles);
		}
		
		/**
		 * @param   array   $roles
		 *
		 * @return Person
		 */
		public function setRoles(array $roles): self
		{
			$this->roles = $roles;
			
			return $this;
		}
		
		/**
		 * Merge the existing roles and the new roles in an array, then assign
		 * the unique members back into $this->roles
		 *
		 * @param   array   $newRoles
		 *
		 * @return Person
		 */
		public function addRoles(array $newRoles): self
		{
			$merged      = array_merge($newRoles, $this->roles);
			$this->roles = array_unique($merged);
			
			return $this;
		}
		
		/**
		 * @return string
		 * @see UserInterface
		 */
		public function getPassword(): string
		{
			return $this->password;
		}
		
		/**
		 * @param   string   $password
		 *
		 * @return Person
		 */
		public function setPassword(string $password): self
		{
			$this->password = $password;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 * @see UserInterface
		 */
		public function getSalt(): ?string
		{
			// not needed when using the "bcrypt" algorithm in security.yaml
			return NULL;
		}
		
		/**
		 * @return string|null
		 * @see UserInterface
		 */
		public function eraseCredentials(): ?string
		{
			/*
			 * If you store any temporary, sensitive data on the user, clear it here
			 * $this->plainPassword = null;
			 */
			
			return NULL;
		}
		
		/**
		 * @return string|null
		 */
		public function getNameDisplay(): ?string
		{
			return $this->nameDisplay;
		}
		
		/**
		 * @param   string|null   $nameDisplay
		 *
		 * @return Person
		 */
		public function setNameDisplay(string $nameDisplay): self
		{
			$this->nameDisplay = $nameDisplay;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getNameFirst(): ?string
		{
			return $this->nameFirst;
		}
		
		/**
		 * @param   string   $nameFirst
		 *
		 * @return Person
		 */
		public function setNameFirst(string $nameFirst): self
		{
			$this->nameFirst = $nameFirst;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getNameMiddle(): ?string
		{
			return $this->nameMiddle;
		}
		
		/**
		 * @param   string|null   $nameMiddle
		 *
		 * @return Person
		 */
		public function setNameMiddle(?string $nameMiddle): self
		{
			$this->nameMiddle = $nameMiddle;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getNameLast(): ?string
		{
			return $this->nameLast;
		}
		
		/**
		 * @param   string   $nameLast
		 *
		 * @return Person
		 */
		public function setNameLast(string $nameLast): self
		{
			$this->nameLast = $nameLast;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getNameSuffix(): ?string
		{
			return $this->nameSuffix;
		}
		
		/**
		 * @param   string|null   $nameSuffix
		 *
		 * @return Person
		 */
		public function setNameSuffix(?string $nameSuffix): self
		{
			$this->nameSuffix = $nameSuffix;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhoneHome(): ?string
		{
			return $this->phoneHome;
		}
		
		/**
		 * @param   string|null   $phoneHome
		 *
		 * @return Person
		 */
		public function setPhoneHome(?string $phoneHome): self
		{
			$this->phoneHome = $phoneHome;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhoneMobile(): ?string
		{
			return $this->phoneMobile;
		}
		
		/**
		 * @param   string|null   $phoneMobile
		 *
		 * @return Person
		 */
		public function setPhoneMobile(?string $phoneMobile): self
		{
			$this->phoneMobile = $phoneMobile;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhoneFax(): ?string
		{
			return $this->phoneFax;
		}
		
		/**
		 * @param   string|null   $phoneFax
		 *
		 * @return Person
		 */
		public function setPhoneFax(?string $phoneFax): self
		{
			$this->phoneFax = $phoneFax;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhoneWork(): ?string
		{
			return $this->phoneWork;
		}
		
		/**
		 * @param   string|null   $phoneWork
		 *
		 * @return Person
		 */
		public function setPhoneWork(?string $phoneWork): self
		{
			$this->phoneWork = $phoneWork;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhoneWorkExtension(): ?string
		{
			return $this->phoneWorkExtension;
		}
		
		/**
		 * @param   string|null   $phoneWorkExtension
		 *
		 * @return Person
		 */
		public function setPhoneWorkExtension(?string $phoneWorkExtension): self
		{
			$this->phoneWorkExtension = $phoneWorkExtension;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getMailingAddressLine1(): ?string
		{
			return $this->mailingAddressLine1;
		}
		
		/**
		 * @param   string|null   $mailingAddressLine1
		 *
		 * @return Person
		 */
		public function setMailingAddressLine1(?string $mailingAddressLine1): self
		{
			$this->mailingAddressLine1 = $mailingAddressLine1;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getMailingAddressLine2(): ?string
		{
			return $this->mailingAddressLine2;
		}
		
		/**
		 * @param   string|null   $mailingAddressLine2
		 *
		 * @return Person
		 */
		public function setMailingAddressLine2(?string $mailingAddressLine2): self
		{
			$this->mailingAddressLine2 = $mailingAddressLine2;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getMailingAddressCity(): ?string
		{
			return $this->mailingAddressCity;
		}
		
		/**
		 * @param   string|null   $mailingAddressCity
		 *
		 * @return Person
		 */
		public function setMailingAddressCity(?string $mailingAddressCity): self
		{
			$this->mailingAddressCity = $mailingAddressCity;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getMailingAddressState(): ?string
		{
			return $this->mailingAddressState;
		}
		
		/**
		 * @param   string|null   $mailingAddressState
		 *
		 * @return Person
		 */
		public function setMailingAddressState(?string $mailingAddressState): self
		{
			$this->mailingAddressState = $mailingAddressState;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getMailingAddressZipCode(): ?string
		{
			return $this->mailingAddressZipCode;
		}
		
		/**
		 * @param   string|null   $mailingAddressZipCode
		 *
		 * @return Person
		 */
		public function setMailingAddressZipCode(?string $mailingAddressZipCode): self
		{
			$this->mailingAddressZipCode = $mailingAddressZipCode;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getMailingAddressCountry(): ?string
		{
			return $this->mailingAddressCountry;
		}
		
		/**
		 * @param   string|null   $mailingAddressCountry
		 *
		 * @return Person
		 */
		public function setMailingAddressCountry(?string $mailingAddressCountry): self
		{
			$this->mailingAddressCountry = $mailingAddressCountry;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhysicalAddressLine1(): ?string
		{
			return $this->physicalAddressLine1;
		}
		
		/**
		 * @param   string|null   $physicalAddressLine1
		 *
		 * @return Person
		 */
		public function setPhysicalAddressLine1(?string $physicalAddressLine1): self
		{
			$this->physicalAddressLine1 = $physicalAddressLine1;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhysicalAddressLine2(): ?string
		{
			return $this->physicalAddressLine2;
		}
		
		/**
		 * @param   string|null   $physicalAddressLine2
		 *
		 * @return Person
		 */
		public function setPhysicalAddressLine2(?string $physicalAddressLine2): self
		{
			$this->physicalAddressLine2 = $physicalAddressLine2;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhysicalAddressCity(): ?string
		{
			return $this->physicalAddressCity;
		}
		
		/**
		 * @param   string|null   $physicalAddressCity
		 *
		 * @return Person
		 */
		public function setPhysicalAddressCity(?string $physicalAddressCity): self
		{
			$this->physicalAddressCity = $physicalAddressCity;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhysicalAddressState(): ?string
		{
			return $this->physicalAddressState;
		}
		
		/**
		 * @param   string|null   $physicalAddressState
		 *
		 * @return Person
		 */
		public function setPhysicalAddressState(?string $physicalAddressState): self
		{
			$this->physicalAddressState = $physicalAddressState;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPhysicalAddressZipCode(): ?string
		{
			return $this->physicalAddressZipCode;
		}
		
		/**
		 * @param   string|null   $physicalAddressZipCode
		 *
		 * @return Person
		 */
		public function setPhysicalAddressZipCode(?string $physicalAddressZipCode): self
		{
			$this->physicalAddressZipCode = $physicalAddressZipCode;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getIpAddress(): ?string
		{
			return $this->ipAddress;
		}
		
		/**
		 * @param   string|null   $ipAddress
		 *
		 * @return Person
		 */
		public function setIpAddress(?string $ipAddress): self
		{
			$this->ipAddress = $ipAddress;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getVerificationKey(): ?string
		{
			return $this->verificationKey;
		}
		
		/**
		 * @param   string|null   $verificationKey
		 *
		 * @return Person
		 */
		public function setVerificationKey(?string $verificationKey): self
		{
			$this->verificationKey = $verificationKey;
			
			return $this;
		}
		
		/**
		 * @return DateTimeInterface|null
		 */
		public function getVerificationDate(): ?DateTimeInterface
		{
			return $this->verificationDate;
		}
		
		/**
		 * @param   DateTimeInterface|null   $verificationDate
		 *
		 * @return Person
		 */
		public function setVerificationDate(?DateTimeInterface $verificationDate): self
		{
			$this->verificationDate = $verificationDate;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getVerificationIpAddress(): ?string
		{
			return $this->verificationIpAddress;
		}
		
		/**
		 * @param   string|null   $verificationIpAddress
		 *
		 * @return Person
		 */
		public function setVerificationIpAddress(?string $verificationIpAddress): self
		{
			$this->verificationIpAddress = $verificationIpAddress;
			
			return $this;
		}
		
		/**
		 * @return DateTimeInterface|null
		 */
		public function getUpdatedAt(): ?DateTimeInterface
		{
			return $this->updatedAt;
		}
		
		/**
		 * @param   DateTimeInterface|null   $updatedAt
		 *
		 * @return Person
		 */
		public function setUpdatedAt(?DateTimeInterface $updatedAt): self
		{
			$this->updatedAt = $updatedAt;
			
			return $this;
		}
		
		/**
		 * @return DateTimeInterface|null
		 */
		public function getCreatedAt(): ?DateTimeInterface
		{
			return $this->createdAt;
		}
		
		/**
		 * @param   DateTimeInterface|null   $createdAt
		 *
		 * @return Person
		 */
		public function setCreatedAt(?DateTimeInterface $createdAt): self
		{
			$this->createdAt = $createdAt;
			
			return $this;
		}
		
		/**
		 * @return bool|null
		 */
		public function getIsActive(): ?bool
		{
			return $this->isActive;
		}
		
		/**
		 * @param   bool   $isActive
		 *
		 * @return Person
		 */
		public function setIsActive(bool $isActive): self
		{
			$this->isActive = $isActive;
			
			return $this;
		}
		
		/**
		 * @return bool|null
		 */
		public function getIsVerified(): ?bool
		{
			return $this->isVerified;
		}
		
		/**
		 * @param   bool   $isVerified
		 *
		 * @return Person
		 */
		public function setIsVerified(bool $isVerified): self
		{
			$this->isVerified = $isVerified;
			
			return $this;
		}
		
		/**
		 * @return bool|null
		 */
		public function getIsRegistered(): ?bool
		{
			return $this->isRegistered;
		}
		
		/**
		 * @param   bool   $isRegistered
		 *
		 * @return Person
		 */
		public function setIsRegistered(bool $isRegistered): self
		{
			$this->isRegistered = $isRegistered;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPasswordRecoveryKey(): ?string
		{
			return $this->passwordRecoveryKey;
		}
		
		/**
		 * @param   string|null   $passwordRecoveryKey
		 *
		 * @return Person
		 */
		public function setPasswordRecoveryKey(?string $passwordRecoveryKey): self
		{
			$this->passwordRecoveryKey = $passwordRecoveryKey;
			
			return $this;
		}
		
		/**
		 * @return DateTimeInterface|null
		 */
		public function getPasswordRecoveryDate(): ?DateTimeInterface
		{
			return $this->passwordRecoveryDate;
		}
		
		/**
		 * @param   DateTimeInterface|null   $passwordRecoveryDate
		 *
		 * @return Person
		 */
		public function setPasswordRecoveryDate(?DateTimeInterface $passwordRecoveryDate): self
		{
			$this->passwordRecoveryDate = $passwordRecoveryDate;
			
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getPasswordRecoveryIpAddress(): ?string
		{
			return $this->passwordRecoveryIpAddress;
		}
		
		/**
		 * @param   string|null   $passwordRecoveryIpAddress
		 *
		 * @return Person
		 */
		public function setPasswordRecoveryIpAddress(?string $passwordRecoveryIpAddress): self
		{
			$this->passwordRecoveryIpAddress = $passwordRecoveryIpAddress;
			
			return $this;
		}
		
		/**
		 * @return bool|null
		 */
		public function getHasStartedRegistration(): ?bool
		{
			return $this->hasStartedRegistration;
		}
		
		/**
		 * @param   bool   $hasStartedRegistration
		 *
		 * @return Person
		 */
		public function setHasStartedRegistration(bool $hasStartedRegistration): self
		{
			$this->hasStartedRegistration = $hasStartedRegistration;
			
			return $this;
		}


//		/**
//		 * @Assert\Callback
//		 */
//		public function validate(ExecutionContextInterface $context, $payload)
//		{
		/** @noinspection SpellCheckingInspection */
//			if (stripos($this->getTitle(), 'the borg') !== false) {
//				$context->buildViolation('Um.. the Bork kinda makes us nervous')
//					->atPath('title')
//					->addViolation();
//			}
//		}
	
	}
