<?php
class Request {
    private $body;
    private $headers;

    public function __construct() {
        $this->body = json_decode(file_get_contents("php://input"), true) ?? [];
        $this->headers = getallheaders();
    }

    public function getBody() {
        return $this->body;
    }

    public function getHeader($key) {
        return $this->headers[$key] ?? null;
    }
}
