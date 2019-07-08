<?php
	
	namespace App\Form;
	
	use App\Entity\Person;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	
	class PersonFormType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options)
		{
			$builder
				->add('nameDisplay')
				->add('nameFirst')
				->add('nameMiddle')
				->add('nameLast')
				->add('nameSuffix')
				->add('phoneHome')
				->add('phoneMobile')
				->add('phoneFax')
				->add('phoneWork')
				->add('phoneWorkExtension')
				->add('email')
				->add('mailingAddressLine1')
				->add('mailingAddressLine2')
				->add('mailingAddressCity')
				->add('mailingAddressState')
				->add('mailingAddressZipCode')
				->add('mailingAddressCountry')
				->add('physicalAddressLine1')
				->add('physicalAddressLine2')
				->add('physicalAddressCity')
				->add('physicalAddressState')
				->add('physicalAddressZipCode')
				->add('ipAddress')
				->add('roles')
				->add('password')
				->add('verificationKey')
				->add('verificationDate')
				->add('verificationIpAddress')
				->add('updatedAt')
				->add('createdAt')
				->add('isActive');
		}
		
		public function configureOptions(OptionsResolver $resolver)
		{
			$resolver->setDefaults([
				'data_class' => Person::class,
			]);
		}
	}
