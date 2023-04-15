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
}
