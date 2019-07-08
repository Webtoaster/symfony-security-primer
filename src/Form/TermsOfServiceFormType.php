<?php
	
	namespace App\Form;
	
	use App\Form\Model\SignupTermsOfServiceFormModel;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Validator\Constraints\IsTrue;
	
	/**
	 * Class TermsOfServiceFormType
	 *
	 * @package App\Form
	 */
	class TermsOfServiceFormType extends AbstractType
	{
		
		/**
		 * @param   FormBuilderInterface   $builder
		 * @param   array                  $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options)
		{
			$builder
				->add('agreedToTermsAt', CheckboxType::class, [
						'mapped'      => FALSE,
						'value'       => TRUE,
						'constraints' => [
							new IsTrue([
								'message' => 'To proceed, you have to agree to the Terms of Service.',
							]),
						],
					]
				);
		}
		
		public function configureOptions(OptionsResolver $resolver)
		{
			$resolver->setDefaults(['data_class' => SignupTermsOfServiceFormModel::class,]);
		}
	}
