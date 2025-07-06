<?php
class StudentController {
    private function authenticate() {
        $request = new Request();
        $token = trim(str_replace('Bearer ', '', $request->getHeader('Authorization') ?? ''));
        if (!$token) {
            Response::json(['message' => 'Missing token'], 401);
        }
        $userModel = new User();
        $user = $userModel->findByToken($token);
        if (!$user) {
            Response::json(['message' => 'Invalid token'], 401);
        }
    }

    public function index() {
        $this->authenticate();
        $studentModel = new Student();
        Response::json($studentModel->getAll());
    }

    public function show($id) {
        $this->authenticate();
        $studentModel = new Student();
        $student = $studentModel->find($id);
        if (!$student) {
            Response::json(['message' => 'Student not found'], 404);
        }
        Response::json($student);
    }

    public function store() {
        $this->authenticate();
        $request = new Request();
        $data = $request->getBody();
        $studentModel = new Student();
        $studentModel->create($data);
        Response::json(['message' => 'Student added']);
    }

    public function update($id) {
        $this->authenticate();
        $request = new Request();
        $data = $request->getBody();
        $studentModel = new Student();
        $studentModel->update($id, $data);
        Response::json(['message' => 'Student updated']);
    }

    public function destroy($id) {
        $this->authenticate();
        $studentModel = new Student();
        $studentModel->delete($id);
        Response::json(['message' => 'Student deleted']);
    }
}
