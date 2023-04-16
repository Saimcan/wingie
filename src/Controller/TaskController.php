<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Repository\TaskRepository;
use App\Service\DeveloperService;
use App\Service\TaskService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $taskRepositoryInstance = new TaskRepository($doctrine);

        $tasksAssigned = false;
        if(0 == count($taskRepositoryInstance->findBy(['assignedToDeveloper' => null]))){
            $tasksAssigned = true;
        }

        return $this->render('task.html.twig', [
            'isTasksAssigned' => $tasksAssigned
        ]);
    }

    #[Route('/task/assign', name: 'app_task_assign_to_developers')]
    public function assignTasksToDevelopers(ManagerRegistry $doctrine): Response
    {
        $taskRepositoryInstance = new TaskRepository($doctrine);
        $taskServiceInstance = new TaskService($taskRepositoryInstance);

        $arrayOfDevelopers = $doctrine->getRepository(Developer::class)->findAll();
        if(0 == count($arrayOfDevelopers)){
            $developerServiceInstance = new DeveloperService();
            $developerServiceInstance->generateDevelopers();
            $arrayOfDevelopers = $doctrine->getRepository(Developer::class)->findAll();
        }

        $taskData = $taskServiceInstance->assignTasksToDevelopers(45, $arrayOfDevelopers);

        return $this->render('task.html.twig', [
            'totalWeek' => count($taskData),
            'taskData' => $taskData,
            'isTasksAssigned' => true
        ]);
    }
}
