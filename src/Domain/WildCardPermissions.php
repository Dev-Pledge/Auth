<?php

namespace DevPledge\Domain;


use DevPledge\Integrations\Security\Permissions\Action;
use DevPledge\Integrations\Security\Permissions\Permissions;
use DevPledge\Integrations\Security\Permissions\Resource;

class WildCardPermissions {
	public function getPerms() {
		$perms = new Permissions();
		$perms
			->addResource( ( new Resource() )
				->setName( 'organisations' )
				->addAction( ( new Action() )
					->setName( 'create' ) )
				->addAction( ( new Action() )
					->setName( 'read' ) )
				->addAction( ( new Action() )
					->setName( 'update' ) )
				->addAction( ( new Action() )
					->setName( 'delete' ) ) )
			->addResource( ( new Resource() )
				->setName( 'members' )
				->addAction( ( new Action() )
					->setName( 'create' ) )
				->addAction( ( new Action() )
					->setName( 'read' ) )
				->addAction( ( new Action() )
					->setName( 'update' ) )
				->addAction( ( new Action() )
					->setName( 'delete' ) ) )
			->addResource( ( new Resource() )
				->setName( 'problem' )
				->addAction( ( new Action() )
					->setName( 'create' ) )
				->addAction( ( new Action() )
					->setName( 'read' ) )
				->addAction( ( new Action() )
					->setName( 'update' ) )
				->addAction( ( new Action() )
					->setName( 'delete' ) ) )
			->addResource( ( new Resource() )
				->setName( 'pledge' )
				->addAction( ( new Action() )
					->setName( 'create' ) )
				->addAction( ( new Action() )
					->setName( 'read' ) )
				->addAction( ( new Action() )
					->setName( 'update' ) )
				->addAction( ( new Action() )
					->setName( 'delete' ) ) );

		return $perms;
	}
}