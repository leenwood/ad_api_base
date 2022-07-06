<?php

namespace App\Exception;

class jsonException
{

    /**
     * return array with message about error id
     * @param int $id
     * @return array
     */
    public function nullOrWrongIdAd(int $id): array
    {
        $body = [
            'result' => 'error',
            'message' => sprintf("Not found ad with id: %s", $id),
            'date' => date('d-m-Y'),
            'inputValue' => ['id' => $id]
        ];

        return $body;
    }

    public function jsonMessage($success = false, $message = '', $inputValue = []): array
    {
        $result = $success?"success":"error";

        $body = [
            'result' => $result,
            'message' => $message,
            'date' => date('d-m-Y'),
            'inputValue' => $inputValue
        ];
        return $body;
    }
}