<?php
class AuthController {
    public function login() {
        $request = new Request();
        $data = $request->getBody();
        $userModel = new User();

        $user = $userModel->attemptLogin($data['username'], $data['password']);
        if ($user) {
            $token = bin2hex(random_bytes(16));
            $userModel->saveToken($user['id'], $token);
            Response::json(['token' => $token]);
        } else {
            Response::json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function me() {
        $user = $this->authenticate();
        Response::json(['id' => $user['id'], 'username' => $user['username']]);
    }

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
        return $user;
    }
}
