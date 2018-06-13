<?php

namespace DevPledge\Application\Service;


use DevPledge\Application\Factory\UserFactory;
use DevPledge\Application\Repository\UserRepository;
use DevPledge\Domain\PreferredUserAuth\PreferredUserAuth;
use DevPledge\Uuid\Uuid;

class UserService {
	/**
	 * @var UserRepository $repo
	 */
	protected $repo;
	/**
	 * @var UserFactory $factory
	 */
	private $factory;

	public function __construct( UserRepository $repository, UserFactory $factory ) {

		$this->repo    = $repository;
		$this->factory = $factory;
	}

	/**
	 * @param string $username
	 * @param PreferredUserAuth $preferredUserAuth
	 *
	 * @return \DevPledge\Domain\User
	 * @throws \Exception
	 */
	public function create( string $username, PreferredUserAuth $preferredUserAuth ) {
		$uuid     = Uuid::make( 'user' )->toString();
		$initData = [ 'username' => $username, 'user_id' => $uuid ];
		$data     = array_merge( $initData, $preferredUserAuth->getAuthDataArray() );

		$user = $this->factory->create( $data );

		return $this->repo->create( $user );
	}
}