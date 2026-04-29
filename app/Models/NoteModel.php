<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'etudiant_id',
        'matiere_id',
        'note',
        'date_saisie'
    ];

    /**
     * Get all notes of a student (detailed view)
     */
    public function getNotesByEtudiant($etudiant_id)
    {
        return $this->db->table('notes n')
            ->select('
                n.id,
                COALESCE(n.note, 0) AS note,
                n.date_saisie,
                m.code AS matiere_code,
                m.libelle AS matiere_libelle,
                ue.libelle AS ue_libelle,
                ue.type AS ue_type,
                s.code AS semestre_code
            ')
            ->join('matieres m', 'm.id = n.matiere_id', 'left')
            ->join('ue', 'ue.id = m.ue_id', 'left')
            ->join('semestres s', 's.id = ue.semestre_id', 'left')
            ->where('n.etudiant_id', $etudiant_id)
            ->orderBy('s.code', 'ASC')
            ->orderBy('m.libelle', 'ASC')
            ->get()
            ->getResult();
    }

    /**
     * Get notes grouped by parcours and semester
     * Always returns ALL subjects with 0 if no note exists
     */
    public function getNotesByParcoursAndSemester($etudiant_id)
    {
        $db = \Config\Database::connect();

        return $db->table('matieres m')
            ->select('
                ep.annee,
                ep.parcours_id,
                p.code AS parcours_code,
                p.libelle AS parcours_libelle,
                s.id AS semestre_id,
                s.code AS semestre_code,
                ue.id AS ue_id,
                ue.libelle AS ue_libelle,
                ue.type AS ue_type,
                m.id AS matiere_id,
                m.libelle AS matiere_libelle,
                COALESCE(MAX(n.note), 0) AS note
            ')
            ->join('ue', 'ue.id = m.ue_id')
            ->join('semestres s', 's.id = ue.semestre_id')
            ->join('etudiant_parcours ep', 'ep.etudiant_id = ' . $db->escape($etudiant_id))
            ->join('parcours p', 'p.id = ep.parcours_id')
            ->join(
                'notes n',
                'n.matiere_id = m.id AND n.etudiant_id = ' . $db->escape($etudiant_id),
                'left'
            )
            ->where('ep.etudiant_id', $etudiant_id)
            ->groupBy('m.id, ep.parcours_id, p.id, s.id, ue.id, ep.annee')
            ->orderBy('ep.annee', 'ASC')
            ->orderBy('s.code', 'ASC')
            ->orderBy('ue.libelle', 'ASC')
            ->get()
            ->getResult();
    }

    /**
     * Get notes by semester
     * Ensures 0 if no grade exists
     */
    public function getNotesBySemester($etudiant_id, $semestre_code)
    {
        $db = \Config\Database::connect();

        return $db->table('matieres m')
            ->select('
                s.code AS semestre_code,
                ue.libelle AS ue_libelle,
                ue.type AS ue_type,
                m.id AS matiere_id,
                m.libelle AS matiere_libelle,
                COALESCE(MAX(n.note), 0) AS note
            ')
            ->join('ue', 'ue.id = m.ue_id')
            ->join('semestres s', 's.id = ue.semestre_id')
            ->join(
                'notes n',
                'n.matiere_id = m.id AND n.etudiant_id = ' . $db->escape($etudiant_id),
                'left'
            )
            ->where('s.code', $semestre_code)
            ->groupBy('m.id')
            ->orderBy('ue.libelle', 'ASC')
            ->get()
            ->getResult();
    }

    /**
     * Get notes by academic year
     * Always shows all subjects (0 if missing)
     */
    public function getNotesByYear($etudiant_id, $annee)
    {
        $db = \Config\Database::connect();

        return $db->table('matieres m')
            ->select('
                ep.annee,
                p.code AS parcours_code,
                p.libelle AS parcours_libelle,
                s.code AS semestre_code,
                ue.libelle AS ue_libelle,
                ue.type AS ue_type,
                m.id AS matiere_id,
                m.libelle AS matiere_libelle,
                COALESCE(MAX(n.note), 0) AS note
            ')
            ->join('ue', 'ue.id = m.ue_id')
            ->join('semestres s', 's.id = ue.semestre_id')
            ->join('etudiant_parcours ep', 'ep.etudiant_id = ' . $db->escape($etudiant_id))
            ->join('parcours p', 'p.id = ep.parcours_id')
            ->join(
                'notes n',
                'n.matiere_id = m.id AND n.etudiant_id = ' . $db->escape($etudiant_id),
                'left'
            )
            ->where('ep.etudiant_id', $etudiant_id)
            ->where('ep.annee', $annee)
            ->groupBy('m.id, ep.parcours_id, p.id, s.id, ue.id, ep.annee')
            ->orderBy('s.code', 'ASC')
            ->orderBy('ue.libelle', 'ASC')
            ->get()
            ->getResult();
    }

    /**
     * Get best grade for optional UE
     */
    public function getOptionalUEBestGrade($etudiant_id, $ue_id)
    {
        $db = \Config\Database::connect();

        $result = $db->table('notes n')
            ->select('COALESCE(MAX(n.note), 0) AS best_note')
            ->join('matieres m', 'm.id = n.matiere_id')
            ->where('n.etudiant_id', $etudiant_id)
            ->where('m.ue_id', $ue_id)
            ->get()
            ->getRow();

        return $result->best_note ?? 0;
    }
}