<?php

namespace Tests\Security\Permissions;

use DevPledge\Integrations\Security\Permissions\Action;
use DevPledge\Integrations\Security\Permissions\Restriction;
use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{

    public function testConstruct()
    {
        $r = new Action();

        $this->assertEquals([], $r->getRestrictions());
        $this->assertEquals(null, $r->getName());
    }

    public function testNameGettersSetters()
    {
        $r = new Action();

        $r->setName('some-name');

        $this->assertEquals('some-name', $r->getName());
    }

    public function testRestrictionGettersSetters()
    {
        $r = new Action();

        $r->setRestrictions([
            (new Restriction())->setName('r1')->addValue(1),
            (new Restriction())->setName('r2')->addValue(2),
        ]);

        $this->assertCount(2, $r->getRestrictions());
        $this->assertEquals('r1', $r->getRestrictions()[0]->getName());
        $this->assertEquals('r2', $r->getRestrictions()[1]->getName());

        $r->addRestriction((new Restriction())->setName('r3'));
        $this->assertCount(3, $r->getRestrictions());
        $this->assertEquals('r1', $r->getRestrictions()[0]->getName());
        $this->assertEquals('r2', $r->getRestrictions()[1]->getName());
        $this->assertEquals('r3', $r->getRestrictions()[2]->getName());

        $fourth = (new Restriction())->setName('r4');
        $r->setRestrictions([$fourth]);

        $this->assertEquals([$fourth], $r->getRestrictions());
    }
}
