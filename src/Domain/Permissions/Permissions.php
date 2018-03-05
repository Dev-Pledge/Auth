<?php


namespace DevPledge\Domain\Permissions;


class Permissions
{

    /**
     * @var Resource[]
     */
    private $resources;

    /**
     * Permissions constructor.
     */
    public function __construct()
    {
        $this->resources = [];
    }

    /**
     * @param Resource[] $resources
     * @return Permissions
     */
    public function setResources(array $resources): Permissions
    {
        $this->resources = $resources;
        return $this;
    }

    /**
     * @param Resource $resource
     * @return Permissions
     */
    public function addResource(Resource $resource): Permissions
    {
        $this->resources[] = $resource;
        return $this;
    }

    /**
     * @return Resource[]
     */
    public function getResources(): array
    {
        return $this->resources;
    }

}