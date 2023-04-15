<?php

class FirstAPIAdapter extends BaseDataAdapter implements APIAdapterInterface
{
    public const URL = "https://www.mocky.io/v2/5d47f24c330000623fa3ebfa";

    private array $data;

    public function __construct(array $response)
    {
        $this->data = $response;
    }

    public function getData(): array
    {
        $result = [];

        foreach ($this->data as $item) {
            $explode = explode(' ', $item['id']);
            $id = (int)end($explode);

            $result[] = [
                'id' => $id,
                'level' => $item['zorluk'],
                'estimated_duration' => $item['sure'],
            ];
        }

        return $result;
    }
}
