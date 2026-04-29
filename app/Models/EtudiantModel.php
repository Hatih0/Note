<?php

namespace App\Models;

use CodeIgniter\Model;

class EtudiantModel extends Model
{
    protected $table = 'etudiants';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['matricule', 'nom', 'prenom'];
    protected $useTimestamps = false;

    public function findByMatricule(string $matricule): ?array
    {
        return $this->where('matricule', $matricule)->first();
    }

    public function resolveIdentifier(string $value): ?array
    {
        if (ctype_digit($value)) {
            $etudiant = $this->find((int) $value);

            if ($etudiant) {
                return $etudiant;
            }
        }

        return $this->findByMatricule($value);
    }
}