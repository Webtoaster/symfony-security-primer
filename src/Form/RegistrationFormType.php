<?php
	
	namespace App\Form;
	
	use App\Entity\Person;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
	use Symfony\Component\Form\Extension\Core\Type\TelType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Validator\Constraints\Email;
	use Symfony\Component\Validator\Constraints\Length;
	use Symfony\Component\Validator\Constraints\NotBlank;
	use Symfony\Component\Validator\Constraints\Regex;
	
	class RegistrationFormType extends AbstractType
	{
		
		/**
		 * @param   FormBuilderInterface   $builder
		 * @param   array                  $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options)
		{
			$builder
				->add('nameFirst', TextType::class, [
						'label'          => 'First Name',
						'label_attr'     => [],
						'label_format'   => NULL,
						'trim'           => TRUE,
						'disabled'       => FALSE,
						'required'       => TRUE,
						'empty_data'     => '',
						'error_bubbling' => FALSE,
						'error_mapping'  => [],
						'help'           => 'Required Field',
						'help_html'      => FALSE,
						'mapped'         => TRUE,
						'attr'           => ['class' => NULL,],
					]
				)
				->add('nameMiddle', TextType::class, [
						'label'          => 'Middle Name',
						'label_attr'     => [],
						'label_format'   => NULL,
						'trim'           => TRUE,
						'disabled'       => FALSE,
						'required'       => FALSE,
						'empty_data'     => '',
						'error_bubbling' => FALSE,
						'error_mapping'  => [],
						'help'           => NULL,
						'help_attr'      => [],
						'help_html'      => FALSE,
						'mapped'         => TRUE,
						'attr'           => ['class' => NULL,],
					]
				)
				->add('nameLast', TextType::class, [
						'label'          => 'Last Name',
						'label_attr'     => [],
						'label_format'   => NULL,
						'trim'           => TRUE,
						'disabled'       => FALSE,
						'required'       => TRUE,
						'empty_data'     => '',
						'error_bubbling' => FALSE,
						'error_mapping'  => [],
						'help'           => 'Required Field',
						'help_attr'      => [],
						'help_html'      => FALSE,
						'mapped'         => TRUE,
						'attr'           => ['class' => NULL,],
					]
				)
				->add('phoneHome', TelType::class, [
						'label'          => 'Home Phone',
						'label_attr'     => [],
						'label_format'   => NULL,
						'trim'           => TRUE,
						'disabled'       => FALSE,
						'required'       => FALSE,
						'empty_data'     => '',
						'error_bubbling' => FALSE,
						'error_mapping'  => [],
						'help'           => 'At least one is required.  (format ###-###-####)',
						'help_attr'      => [],
						'help_html'      => FALSE,
						'mapped'         => TRUE,
						'attr'           => ['class' => NULL,],
					]
				)
				->add('phoneMobile', TelType::class, [
						'label'          => 'Mobile Phone',
						'label_attr'     => [],
						'label_format'   => NULL,
						'trim'           => TRUE,
						'disabled'       => FALSE,
						'required'       => FALSE,
						'empty_data'     => '',
						'error_bubbling' => FALSE,
						'error_mapping'  => [],
						'help'           => 'At least one is required.  (format ###-###-####)',
						'help_attr'      => [],
						'help_html'      => FALSE,
						'mapped'         => TRUE,
						'attr'           => ['class' => NULL,],
					]
				)
				->add('phoneWork', TelType::class, [
						'label'          => 'Work Phone',
						'label_attr'     => [],
						'label_format'   => NULL,
						'trim'           => TRUE,
						'disabled'       => FALSE,
						'required'       => FALSE,
						'empty_data'     => '',
						'error_bubbling' => FALSE,
						'error_mapping'  => [],
						'help'           => 'At least one is required.  (format ###-###-####)',
						'help_attr'      => [],
						'help_html'      => FALSE,
						'mapped'         => TRUE,
						'attr'           => ['class' => NULL,],
					]
				)
				->add('email', EmailType::class, [
						'label'        => 'Email Address',
						'label_attr'   => [],
						'label_format' => NULL,
						'trim'         => TRUE,
						'disabled'     => FALSE,
						'required'     => TRUE,
						'empty_data'   => '',
						//			'error_bubbling' => FALSE,
						//			'error_mapping'  => [],
						'help'         => 'Your Email Address is your Login ID/User Name.',
						'help_attr'    => [],
						'help_html'    => FALSE,
						'mapped'       => TRUE,
						'constraints'  => [
							new Email([
								'message' => 'Please enter a valid email address.',
							]),
						],
						'attr'         => ['class' => NULL,],
					]
				
				)
				->add('plainPassword', RepeatedType::class, [
						'type'            => PasswordType::class,
						'invalid_message' => 'Your password does not match the confirmation.',
						'mapped'          => FALSE,
						'options'         => ['attr' => ['class' => 'password-field']],
						'required'        => TRUE,
						'constraints'     => [
							new NotBlank([
									'message' => 'Please enter a password',
								]
							),
							new Length([
									'min'        => 6,
									'minMessage' => 'Your password should be at least {{ limit }} characters',
									'max'        => 4096,
								]
							),
							new Regex([
									'pattern' => '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/s',
									'match'   => TRUE,
									'message' => 'Please enter a valid password.  See the requirements below.',
								]
							),
						],
						'first_options'   => [
							'label'     => 'Password',
							'help'      => 'Password must contain 1 number (0-9).<br/>
										Password must contain 1 uppercase letter.<br/>
										Password must contain 1 lowercase letter.<br/>
										Password must contain 1 non-alpha numeric character.<br/>
										Password must be between 6-16 characters without spaces.<br/>',
							'help_html' => TRUE,
							'attr'      => ['class' => NULL,],
						],
						'second_options'  => [
							'label' => 'Confirm Password',
							'help'  => 'Please enter your Password again.',
							'attr'  => ['class' => NULL,],
						],
					]
				);
		}
		
		/**
		 * @param   OptionsResolver   $resolver
		 *
		 * @return null
		 */
		public function configureOptions(OptionsResolver $resolver)
		{
			$resolver->setDefaults([
				'data_class' => Person::class,
			]);
		}
	}
