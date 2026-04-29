<?php 

namespace App\Controllers;

use App\Models\UserModele;

class UserController extends BaseController
{
    private UserModele $userModel; 

    
    public function __construct()
    {
        $this->userModel = new UserModele();
    }

    public function login(): string
    {
        return view('login/login', [
            'firstUser' => $this->userModel->first(),
        ]);
    }

    public function checkUser()
    {
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()
                ->with('error', 'Email et mot de passe requis.');
        }

        $user = $this->userModel->checkUser($email, $password);

        if (! $user) {
            return redirect()->back()
                ->with('error', 'Email ou mot de passe incorrect.');
        }

        session()->set([
            'user_id'      => $user['id'],
            'email'        => $user['email'],
            'is_logged_in' => true,
        ]);

        return redirect()->to('/dashboard');
    }

}