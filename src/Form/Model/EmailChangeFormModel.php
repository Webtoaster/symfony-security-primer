<?php
	
	namespace App\Form\Model;
	
	use Symfony\Component\Validator\Constraints as Assert;
	
	class EmailChangeFormModel
	{
		
		/**
		 * @var $email string
		 * @Assert\All({
		 *      @Assert\Email(
		 *          message="This is not a valid email address."
		 *      ),
		 *      @Assert\NotBlank(
		 *          message="The Email Address cannot be empty or blank."
		 *      ),
		 *      @Assert\Email(
		 *          message="Please enter a valid Email Address."
		 *      )
		 * })
		 */
		public $emailCurrent;
		
		/**
		 * @var $email string
		 * @Assert\All({
		 *      @Assert\Email(
		 *          message="This is not a valid email address."
		 *      ),
		 *      @Assert\NotBlank(
		 *          message="The Email Address cannot be empty or blank."
		 *      ),
		 *      @Assert\Email(
		 *          message="Please enter a valid Email Address."
		 *      )
		 * })
		 */
		public $emailNew;
		
	}
