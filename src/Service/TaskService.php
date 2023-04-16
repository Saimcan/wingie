<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Component\HttpClient\NativeHttpClient;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;

    }

    public function insertData(\APIAdapterInterface $adapter): void
    {
        $data = $adapter->getData();
        if($this->taskRepository->findOneBy([], ['id' => 'desc'])){
            $latestTaskId = $this->taskRepository->findOneBy([], ['id' => 'desc'])->getTaskId() + 1;
        }else{
            $latestTaskId = 1;
        }

        foreach ($data as $item)
        {
            $entity = new Task();
            $entity->setTaskId($latestTaskId + $item['id']);
            $entity->setLevel($item['level']);
            $entity->setEstimatedDuration($item['estimated_duration']);

            $this->taskRepository->save($entity, true);
        }
    }

    public function receiveTasks(): void
    {
        //A factory approach can be applied later on.
        $client = new NativeHttpClient();
        $response = $client->request(
            'GET',
            \FirstAPIAdapter::URL
        );
        $resultData = $response->toArray();
        $firstApiAdapter = new \FirstAPIAdapter($resultData);

        $client = new NativeHttpClient();
        $response = $client->request(
            'GET',
            \SecondApiAdapter::URL
        );
        $resultData = $response->toArray();
        $secondApiAdapter = new \SecondAPIAdapter($resultData);

        $this->insertData($firstApiAdapter);
        $this->insertData($secondApiAdapter);
    }

    public function assignTasksToDevelopers(int $totalHours, array $arrayOfDevelopers): array
    {
        $taskModel = new Task();
        $developerTasksWeekly = [];
        $weekCount = 0;

        while (count($this->taskRepository->findBy(['assignedToDeveloper' => null])) > 0)
        {
            $weekCount++;
            $arrayOfDevelopers = $taskModel->calculateTotalDeveloperHours($totalHours, $arrayOfDevelopers);

            foreach ($arrayOfDevelopers as $developer)
            {
                //get tasks according to seniority level
                $taskList = $this->taskRepository->findBy([
                    'assignedToDeveloper' => null,
                    'level' => $developer->getLevel()
                ], [
                    'estimatedDuration' => 'ASC'
                ]);

                //check if excess jobs needs to get applied for non-working developer
                if(0 == count($taskList) && $developer->getTaskWeightInHours() > 0)
                {
                    $developerLevel = $developer->getLevel();
                    while ($developerLevel > 0){
                        $developerLevel--;
                        $taskList = $this->taskRepository->findBy([
                            'assignedToDeveloper' => null,
                            'level' => $developerLevel
                        ], [
                            'estimatedDuration' => 'ASC'
                        ]);

                        if(count($taskList) > 0){break;}
                    }
                }

                //assign tasks to the developers equal to their level
                foreach ($taskList as $task)
                {
                    if($developer->getTaskWeightInHours() > 0 &&
                        $developer->getTaskWeightInHours() > $task->getEstimatedDuration())
                    {
                        $developerTasksWeekly[$weekCount][$developer->getId()][] = $task;
                        $task->setAssignedToDeveloper($developer);
                        $developer->setTaskWeightInHours($developer->getTaskWeightInHours() - $task->getEstimatedDuration());
                    }
                    else{break;}

                    //flushing here, might get refactored later to reduce workload onto database.
                    $this->taskRepository->save($task, true);
                }
            }
        }

        return $developerTasksWeekly;
    }
}
