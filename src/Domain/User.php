<?php

namespace DevPledge\Domain;

use DevPledge\Domain\ThirdPartyAuth\EmailPassword;

/**
 * Class User
 * @package DevPledge\Domain
 */
class User {

	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var string | null
	 */
	private $email;
	/**
	 * @var int | null
	 */
	private $gitHubId=1;
	/**
	 * @var string | null
	 */
	private $hashedPassword;
	/**
	 * @var bool
	 */
	private $developer;
	/**
	 * @var string
	 */
	private $firstName;
	/**
	 * @var string
	 */
	private $lastName;
	/**
	 * @var \stdClass
	 */
	private $data;
	/**
	 * @var \DateTime
	 */
	private $created;
	/**
	 * @var \DateTime
	 */
	private $modified;


	/**
	 * @param string $id
	 *
	 * @return User
	 */
	public function setId( string $id ): User {
		$this->id = $id;

		return $this;
	}

	/**
	 * @param string $email
	 *
	 * @return User
	 */
	public function setEmail( string $email ): User {
		$this->email = $email;

		return $this;
	}

	/**
	 * @param string $hashedPassword
	 *
	 * @return User
	 */
	public function setHashedPassword( string $hashedPassword ): User {
		$this->hashedPassword = $hashedPassword;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getId(): ?string {
		return $this->id;
	}

	/**
	 * @return null|string
	 */
	public function getEmail(): ?string {
		return $this->email;
	}

	/**
	 * @return EmailPassword
	 */
	public function getEmailPasswordAuth() {
		return new EmailPassword( $this->getEmail(), null, $this->getHashedPassword() );
	}

	/**
	 * @return null|string
	 */
	public function getHashedPassword(): ?string {
		return $this->hashedPassword;
	}

	/**
	 * @param bool $developer
	 *
	 * @return User
	 */
	public function setDeveloper( bool $developer ): User {
		$this->developer = $developer;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isDeveloper(): bool {
		return isset( $this->developer ) ? $this->developer : false;
	}

	/**
	 * @param string $firstName
	 *
	 * @return User
	 */
	public function setFirstName( string $firstName ): User {
		$this->firstName = $firstName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFirstName(): string {
		return $this->firstName;
	}

	/**
	 * @return string
	 */
	public function getLastName(): string {
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 *
	 * @return User
	 */
	public function setLastName( string $lastName ): User {
		$this->lastName = $lastName;

		return $this;
	}

	/**
	 * @return \stdClass
	 */
	public function getData(): \stdClass {
		return isset( $this->data ) ? $this->data : new \stdClass();
	}

	/**
	 * @param \stdClass $data
	 *
	 * @return User
	 */
	public function setData( \stdClass $data ): User {
		$this->data = $data;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreated(): \DateTime {
		return isset( $this->created ) ? $this->created : new \DateTime();
	}

	/**
	 * @param \DateTime $created
	 *
	 * @return User
	 */
	public function setCreated( \DateTime $created ): User {
		$this->created = $created;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getModified(): \DateTime {
		return isset( $this->modified ) ? $this->modified : new \DateTime();
	}

	/**
	 * @param \DateTime $modified
	 *
	 * @return User
	 */
	public function setModified( \DateTime $modified ): User {
		$this->modified = $modified;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getGitHubId(): ?int {
		return $this->gitHubId;
	}

	/**
	 * @param int|null $gitHubId
	 *
	 * @return User
	 */
	public function setGitHubId( ?int $gitHubId ): User {
		$this->gitHubId = $gitHubId;

		return $this;
	}

}