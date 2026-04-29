<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserModele extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'email',
        'password',
        'nom',
    ];

    protected $validationRules = [
        'email'    => 'required|valid_email|is_unique[utilisateurs.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'nom'      => 'required|min_length[2]',
    ];

    public function checkUser(string $email, string $password): ?array
    {
        $user = $this->where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null; 
    }

}