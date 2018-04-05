<?php


namespace DevPledge\Application\Repository;


use DevPledge\Application\Factory\OrganisationFactory;
use DevPledge\Application\Mapper\Mapper;
use DevPledge\Domain\Organisation;
use DevPledge\Framework\Adapter\Adapter;

class OrganisationRepository
{

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @var Mapper
     */
    private $mapper;

    /**
     * @var OrganisationFactory
     */
    private $factory;

    /**
     * OrganisationRepository constructor.
     * @param Adapter $adapter
     * @param Mapper $mapper
     * @param OrganisationFactory $factory
     */
    public function __construct(Adapter $adapter, Mapper $mapper, OrganisationFactory $factory)
    {
        $this->adapter = $adapter;
        $this->mapper = $mapper;
        $this->factory = $factory;
    }

    /**
     * @param Organisation $organisation
     * @return Organisation
     * @throws \Exception
     */
    public function create(Organisation $organisation): Organisation
    {
        $data = $this->mapper->toMap($organisation);
        $id = $this->adapter->create('organisation', $data);
        return $this->read($id);
    }

    /**
     * @param Organisation $organisation
     * @return Organisation
     * @throws \Exception
     */
    public function update(Organisation $organisation): Organisation
    {
        $data = $this->mapper->toMap($organisation);
        unset($data->id);
        $id = $this->adapter->update('organisation', $organisation->getId(), $data);
        return $this->read($id);
    }

    /**
     * @param string $id
     * @return Organisation
     */
    public function read(string $id): Organisation
    {
        $data = $this->adapter->read('organisation', $id);
        return $this->factory->create($data);
    }

}