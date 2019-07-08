<?php
	
	namespace App\Form\Model;
	
	use Symfony\Component\Validator\Constraints as Assert;
	
	/**
	 * Class SignupTermsOfServiceFormModel
	 *
	 * @package App\Form\Model
	 */
	class SignupTermsOfServiceFormModel
	{
		/**
		 * @Assert\IsTrue(message="Please review and if you accept the Terms Of Service, please check the Accept Terms Box.")
		 */
		public $agreeTerms;
	}
