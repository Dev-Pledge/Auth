<?php


namespace Tests\Domain\Domain\Permissions;


use DevPledge\Integrations\Security\Permissions\Restriction;
use PHPUnit\Framework\TestCase;

class RestrictionTest extends TestCase
{

    public function testConstruct()
    {
        $r = new Restriction();

        $this->assertEquals([], $r->getValues());
        $this->assertEquals(null, $r->getName());
    }

    public function testNameGettersSetters()
    {
        $r = new Restriction();

        $r->setName('some-name');

        $this->assertEquals('some-name', $r->getName());
    }

    public function testValueGettersSetters()
    {
        $r = new Restriction();

        $r->setValues([1]);
        $this->assertEquals([1], $r->getValues());

        $r->setValues([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $r->getValues());

        $r->setValues([1, 3]);
        $this->assertEquals([1, 3], $r->getValues());

        $r->addValue(2);
        $this->assertEquals([1, 3, 2], $r->getValues());

        $r->addValue(4);
        $this->assertEquals([1, 3, 2, 4], $r->getValues());

        $this->assertTrue($r->hasValue(4));
        $this->assertFalse($r->hasValue(5));
    }

}