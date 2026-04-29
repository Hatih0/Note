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

    /**
     * Récupère les matières par semestre
     */
    public function getMatieresBySemestre($semestreId)
    {
        return $this->select('matieres.id, matieres.code, matieres.libelle, ue.credits, ue.type')
            ->join('ue', 'ue.id = matieres.ue_id')
            ->where('ue.semestre_id', $semestreId)
            ->orderBy('matieres.code', 'ASC')
            ->findAll();
    }

    /**
     * Récupère une matière avec ses détails
     */
    public function getMatiereDetails($matiereId)
    {
        return $this->select('matieres.*, ue.semestre_id, ue.credits, ue.type')
            ->join('ue', 'ue.id = matieres.ue_id')
            ->where('matieres.id', $matiereId)
            ->first();
    }

    /**
     * Récupère les semestres disponibles
     */
    public function getSemestres()
    {
        return $this->db->table('semestres')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
    }
}
