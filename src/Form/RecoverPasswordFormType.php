<?php
	
	namespace App\Form;
	
	use App\Form\Model\PasswordRecoveryFormModel;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Validator\Constraints\Email;
	
	class RecoverPasswordFormType extends AbstractType
	{
		
		/**
		 * @param   FormBuilderInterface   $builder
		 * @param   array                  $options
		 *
		 * @return FormBuilderInterface|null
		 */
		public function buildForm(FormBuilderInterface $builder, array $options): ?FormBuilderInterface
		{
			$builder
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
				
				);
			
			return $builder;
		}
		
		/**
		 * @param   OptionsResolver   $resolver
		 *
		 * @return void
		 */
		public function configureOptions(OptionsResolver $resolver): void
		{
			$resolver->setDefaults([
				'data_class' => PasswordRecoveryFormModel::class,
			]);
		}
	}
