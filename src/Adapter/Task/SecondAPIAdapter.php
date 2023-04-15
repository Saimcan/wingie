<?php

class SecondAPIAdapter extends BaseDataAdapter implements APIAdapterInterface
{
    public const URL = "https://www.mocky.io/v2/5d47f235330000623fa3ebf7";

    private array $data;

    public function __construct(array $response)
    {
        $this->data = $response;
    }

    public function getData(): array
    {
        $result = [];

        foreach ($this->data as $item) {
            $key = key($item);
            $value = $item[$key];
            $id = explode(' ', $key);
            $id = (int)end($id);

            $result[] = [
                'id' => $id,
                'level' => $value['level'],
                'estimated_duration' => $value['estimated_duration']
            ];
        }

        return $result;
    }
}
