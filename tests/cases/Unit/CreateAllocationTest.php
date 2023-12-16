<?php

use App\Domain\Assignment\AssignmentFacade;
use App\Domain\Mail\MailManager;
use App\Domain\Project\ProjectFacade;
use App\Domain\User\UserFacade;
use App\Model\Database\Entity\Assignment;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\AssignmentRepository;
use App\Model\Security\Passwords;
use Nette\Database\Explorer;
use Tester\Assert;

$container = require __DIR__ . '/../../bootstrap.php';


class CreateAllocationTest extends Tester\TestCase
{

    public function __construct()
    {
    }

    public function setUp()
    {
        parent::setUp();

        /*$this->explorer = Mockery::mock(\Nette\Database\Explorer::class)->makePartial();
        $this->transaction = Mockery::mock(App\Tools\Transaction::class)->makePartial();
        $this->superiorUserRepository = Mockery::mock(\App\Model\User\Superior\SuperiorUserRepository::class, array($this->explorer))->makePartial();
        $this->projectUserRepository = Mockery::mock(\App\Model\Project\ProjectUser\ProjectUserRepository::class, array($this->explorer))->makePartial();
        $this->allocationRepository = Mockery::mock(\App\Model\Project\ProjectUserAllocation\ProjectUserAllocationRepository::class, array($this->explorer))->makePartial();
        $this->projectRepository = Mockery::mock(\App\Model\Project\ProjectRepository::class, array($this->explorer))->makePartial();
    */
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testValid()
    {
        //$allocationFacade = new ProjectUserAllocationFacade($this->projectUserRepository, $this->allocationRepository, $this->projectRepository, $this->superiorUserRepository, $this->transaction);
        //
        $entityManager = Mockery::mock(EntityManager::class)->makePartial();
        $explorer = Mockery::mock(Explorer::class)->makePartial();

        $assignmentRepositoryMock = Mockery::mock(AssignmentRepository::class)->makePartial();
        $assignment = new Assignment();
        $assignment->setDescription("aaaa");
        $assignment->setName("bbbbb");

        $entityManager->shouldReceive("getAssignmentRepository->findOneBy")
            ->with(Mockery::any())
            ->times(1)
            ->andReturn($assignment)
        ;

        $mailManager = Mockery::mock(MailManager::class)->makePartial();
        $passwords = new Passwords();

        $projectFacade = Mockery::mock(ProjectFacade::class)->makePartial();

        $assignmentFacade = new AssignmentFacade(new UserFacade($entityManager, $mailManager, $passwords), $entityManager, $projectFacade);
        Assert::same("bbbbb", $assignmentFacade->get(4)->getName());

    }


}

# Spuštění testovacích metod
(new CreateAllocationTest())->run();
