<?php
	
	namespace App\Repository;
	
	use App\Entity\Person;
	use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
	use Doctrine\DBAL\DBALException;
	use Symfony\Bridge\Doctrine\RegistryInterface;
	
	/**
	 * Class PersonRepository
	 *
	 * @package App\Repository
	 */
	class PersonRepository extends ServiceEntityRepository
	{
		public function __construct(RegistryInterface $registry)
		{
			parent::__construct($registry, Person::class);
		}
		
		/**
		 * This will remove orphaned contacts which were not verified after XXX amount of time.
		 * The setting for the amount of time is set in the ENV settings.
		 *
		 * @author Tom Olson <olson@webtoaster.com>
		 *
		 */
		public function delete_orphaned_registrants()
		{
			$sql = '';
			// $sql .= 'SET time_zone = \''.$_ENV['MYSQL_TIME_ZONE'].'\';';
			$sql  .= ' DELETE FROM
						person
					WHERE
						person.has_started_registration = 1 AND
					    person.is_verified = 0 AND
					    person.created_at < CURRENT_TIMESTAMP - INTERVAL '.$_ENV['ELAPSED_TIME_ORPHANED_REGISTRANT'].' SECOND ';
			$conn = $this->getEntityManager()->getConnection();
			try {
				$conn->exec($sql);
			} catch (DBALException $e) {
//				TODO Implement Logging Feature Here.
			}
			return;
		}
		
		
		
		
		
		
		
		// /**
		//  * @return Person[] Returns an array of Person objects
		//  */
		/*
		public function findByExampleField($value)
		{
			return $this->createQueryBuilder('p')
				->andWhere('p.exampleField = :val')
				->setParameter('val', $value)
				->orderBy('p.id', 'ASC')
				->setMaxResults(10)
				->getQuery()
				->getResult()
			;
		}
		*/
		
		/*
		public function findOneBySomeField($value): ?Person
		{
			return $this->createQueryBuilder('p')
				->andWhere('p.exampleField = :val')
				->setParameter('val', $value)
				->getQuery()
				->getOneOrNullResult()
			;
		}
		*/
	}
