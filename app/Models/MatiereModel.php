<?php

namespace App\Models;

use CodeIgniter\Model;

class MatiereModel extends Model
{
    protected $table = 'matieres';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['ue_id', 'code', 'libelle'];
    protected $useTimestamps = false;

    public function getSemestres(): array
    {
        return $this->db->table('semestres')
            ->select('id, code')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getMatieresBySemestre($semestreId): array
    {
        return $this->select('matieres.id, matieres.code, matieres.libelle, ue.code AS ue_code, ue.libelle AS ue_libelle, ue.credits, ue.type')
            ->join('ue', 'ue.id = matieres.ue_id')
            ->where('ue.semestre_id', $semestreId)
            ->orderBy('matieres.code', 'ASC')
            ->findAll();
    }
}
