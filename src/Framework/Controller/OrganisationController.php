<?php

namespace DevPledge\Framework\Controller;


use DevPledge\Application\Commands\CreateOrganisationCommand;
use DevPledge\Application\Services\OrganisationService;
use DevPledge\Domain\User;
use DevPledge\Framework\ControllerDependencies\OrganisationControllerDependency;
use DevPledge\Integrations\Command\Dispatch;
use DevPledge\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;

class OrganisationController
{

    /**
     * @var OrganisationService
     */
    private $organisationService;

    /**
     * OrganisationController constructor.
     * @param OrganisationService $organisationService
     */
    public function __construct(OrganisationService $organisationService)
    {
	    /**
	     * The 'injection' into the controller construct comes from
	     * @var $dependecyInjector OrganisationControllerDependency
	     * you can make as many as you want and stick them in ControllerDependencies Dir  -
	     * these dirs are set in Extrapolations in the index.php
	     */

	    /**
	     * You could just do if we aren't using OrganisationServices Class ancestors through the construct!!!
	     */
	    $this->organisationService = OrganisationService::getService();

	    /**
	     * but this works too!
	     */
        $this->organisationService = $organisationService;
    }

    /**
     * @param Request $req
     * @param Response $res
     * @return Response
     */
    public function getOrganisation(Request $req, Response $res)
    {
        $organisationId = $req->getParam('id');
        if ($organisationId === null) {
            return $res->withJson([
                'Missing ID'
            ], 400);
        }

        $organisation = $this->organisationService->read($organisationId);
        if ($organisation === null) {
            return $res->withJson([
                'Organisation not found'
            ], 404);
        }

        return $res->withJson($organisation);
    }

	/**
	 * @param Request $req
	 * @param Response $res
	 *
	 * @return static
	 * @throws \Exception
	 */
    public function getOrganisations(Request $req, Response $res)
    {
        $filters = $req->getParams([
            'id',
            'firstName',
            'lastName',
            'email',
        ]);

        $organisations = $this->organisationService->readAll($filters);

        return $res->withJson($organisations);
    }

	/**
	 * @param Request $req
	 * @param Response $res
	 *
	 * @return static
	 * @throws \Exception
	 */
    public function patchOrganisation(Request $req, Response $res)
    {
        $organisationId = $req->getParam('id');
        if ($organisationId === null) {
            return $res->withJson([
                'Missing ID'
            ], 400);
        }

        $organisation = $this->organisationService->read($organisationId);
        if ($organisation === null) {
            return $res->withJson([
                'OrganisationController not found'
            ], 404);
        }

        $body = $req->getParsedBody();

        // todo : set organisation values from body

        $organisation = $this->organisationService->update($organisation);

        return $res->withJson($organisation);
    }

    /**
     * @param Request $req
     * @param Response $res
     *
     * @return Response
     */
    public function postOrganisation(Request $req, Response $res)
    {
        $body = $req->getParsedBody();
        $userId = $body['user_id'] ?? null;
        if ($userId === null) {
            return $res->withJson([
                'Missing user_id'
            ], 400);
        }

        $name = $body['name'] ?? null;
        if ($name === null) {
            return $res->withJson([
                'Missing name'
            ], 400);
        }

        $userUuid = new Uuid($userId);
        $user = new User(); // TODO: Get user from $userUuid

        // See CommandHandler\CreateOrganisationHandler
        $command = new CreateOrganisationCommand($user, $name);
        $organisation = Dispatch::command($command);

        return $res->withJson($organisation);
    }

}