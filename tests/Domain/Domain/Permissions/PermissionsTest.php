<?php


namespace Tests\Domain\Domain\Permissions;


use DevPledge\Integrations\Security\Permissions\Action;
use DevPledge\Integrations\Security\Permissions\Permissions;
use DevPledge\Integrations\Security\Permissions\Resource;
use DevPledge\Integrations\Security\Permissions\Restriction;
use PHPUnit\Framework\TestCase;

class PermissionsTest extends TestCase
{

    public function testConstruct()
    {
        $p = new Permissions();

        $this->assertEquals([], $p->getResources());
    }

    public function testJsonSerialize()
    {
        $p = new Permissions();
        $p
            ->addResource((new Resource())->setName('r1')
                ->addAction((new Action())->setName('a1')
                    ->addRestriction((new Restriction())->setName('r1')
                        ->addValue(1)))
                ->addAction((new Action())->setName('a2')
                    ->addRestriction((new Restriction())->setName('r2')
                        ->addValue(2))
                    ->addRestriction((new Restriction())->setName('r3')
                        ->addValue(3)
                        ->addValue(4))))
            ->addResource((new Resource())->setName('r2')
                ->addAction((new Action())->setName('a3')
                    ->addRestriction((new Restriction())->setName('r4')
                        ->addValue(1)))
                ->addAction((new Action())->setName('a4')));

        $jsonString = json_encode($p);
        $expectedJsonString = '{
            "r1": {
                "a1": {
                    "r1": [1]
                },
                "a2": {
                    "r2": [2],
                    "r3": [3, 4]
                }
             },
            "r2": {
                "a3": {
                    "r4": [1]
                },
                "a4": {}
             }
        }';
        $this->assertJsonStringEqualsJsonString($expectedJsonString, $jsonString);
    }

}