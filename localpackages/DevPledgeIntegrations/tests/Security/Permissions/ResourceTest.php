<?php

namespace Tests\Security\Permissions;

use DevPledge\Integrations\Security\Permissions\Action;
use DevPledge\Integrations\Security\Permissions\Resource;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{

    public function testConstruct()
    {
        $r = new Resource();

        $this->assertEquals([], $r->getActions());
        $this->assertEquals(null, $r->getName());
    }

    public function testNameGettersSetters()
    {
        $r = new Resource();

        $r->setName('some-name');

        $this->assertEquals('some-name', $r->getName());
    }

    public function testActionGettersSetters()
    {
        $r = new Resource();

        $this->assertEquals([], $r->getActions());

        $r->addAction((new Action())->setName('a1'));
        $this->assertCount(1, $r->getActions());

        $r->addAction((new Action())->setName('a2'));
        $this->assertCount(2, $r->getActions());

        $r->addAction((new Action())->setName('a3'));
        $this->assertCount(3, $r->getActions());

        $this->assertEquals('a1', $r->getActions()[0]->getName());
        $this->assertEquals('a2', $r->getActions()[1]->getName());
        $this->assertEquals('a3', $r->getActions()[2]->getName());
    }

}