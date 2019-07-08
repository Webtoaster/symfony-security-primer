<?php
	
	namespace App\Form\Model;
	
	use Symfony\Component\Validator\Constraints as Assert;
	
	class PasswordChangeFormModel
	{
		/**
		 * @var string $oldPassword
		 */
		public $oldPassword;
		
		/**
		 * @var string $plainPassword
		 *
		 * @Assert\All(
		 *     @Assert\NotNull(),
		 *     @Assert\NotBlank(),
		 *     @Assert\Length(),
		 *     @Assert\Regex(
		 *
		 *
		 *
		 *      )
		 *
		 * )
		 */
		public $plainPassword;
		
	}
