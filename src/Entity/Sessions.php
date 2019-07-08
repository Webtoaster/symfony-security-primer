<?php
	
	namespace App\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	
	/**
	 * Sessions
	 *
	 * @ORM\Table(name="sessions")
	 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
	 */
	class Sessions
	{
		/**
		 * @var string|null $sessId
		 *
		 * @ORM\Column(name="sess_id", type="string", length=128, nullable=false)
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="IDENTITY")
		 */
		private $sessId;
		
		/**
		 * @var string|null
		 *
		 * @ORM\Column(name="sess_data", type="blob", length=65535, nullable=false)
		 */
		private $sessData;
		
		/**
		 * @var int|null
		 *
		 * @ORM\Column(name="sess_time", type="integer", nullable=false, options={"unsigned"=true})
		 */
		private $sessTime;
		
		/**
		 * @var int|null
		 *
		 * @ORM\Column(name="sess_lifetime", type="integer", nullable=false)
		 */
		private $sessLifetime;
		
		/**
		 * @return string|null
		 */
		public function getSessId(): ?string
		{
			return $this->sessId;
		}
		
		/**
		 * @return string
		 */
		public function getSessData()
		{
			return $this->sessData;
		}
		
		/**
		 * @param   array   $sessData
		 *
		 * @return Sessions
		 */
		public function setSessData(array $sessData): self
		{
			$this->sessData = $sessData;
			
			return $this;
		}
		
		/**
		 * @return int|null
		 */
		public function getSessTime(): ?int
		{
			return $this->sessTime;
		}
		
		/**
		 * @param   int   $sessTime
		 *
		 * @return Sessions
		 */
		public function setSessTime(int $sessTime): self
		{
			$this->sessTime = $sessTime;
			
			return $this;
		}
		
		/**
		 * @return int|null
		 */
		public function getSessLifetime(): ?int
		{
			return $this->sessLifetime;
		}
		
		/**
		 * @param   int   $sessLifetime
		 *
		 * @return Sessions
		 */
		public function setSessLifetime(int $sessLifetime): self
		{
			$this->sessLifetime = $sessLifetime;
			
			return $this;
		}
		
	}
