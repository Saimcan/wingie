<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TaskController.php',
        ]);
    }

    #[Route('/task/receive', name: 'app_task_receive')]
    public function receiveTasks(ManagerRegistry $doctrine, KernelInterface $kernel)
    {
//        $taskRepositoryInstance = new TaskRepository($doctrine);
//        $taskServiceInstance = new TaskService($taskRepositoryInstance);
//        $taskServiceInstance->receiveTasks();

//        $consoleApplication = new Application($kernel);
//        $consoleApplication->setAutoExit(false);
//        $input = new ArrayInput([
//            'command' => 'app:task-receive'
//        ]);
//        $output = new BufferedOutput();
//        $consoleApplication->run($input, $output);
//        $content = $output->fetch();
    }
}
