<?php
	
	namespace App\Form\Model;
	
	use Symfony\Component\Validator\Constraints as Assert;
	
	class AddressPhysicalFormModel
	{
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
		public $physicalAddressLine1;
		
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
		public $physicalAddressLine2 = NULL;
		
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
		public $physicalAddressCity;
		
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
		public $physicalAddressState = 'TX';
		
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
		public $physicalAddressZipCode;
		
	}
