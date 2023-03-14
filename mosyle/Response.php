<?php

namespace Mosyle;

class Response
{

    private $message;
    private $status;
    private $data;
    private $code;

    public function __construct($message, $status = 'success', $code = 200, $data = null)
    {
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
        $this->code = $code;
    }

    public function send()
    {
        header("HTTP/1.1 {$this->code}");
        header('Content-Type: application/json');
        echo json_encode([
            'message' => $this->message,
            'status' => $this->status,
            'data' => $this->data ?? []
        ]);
    }

}