<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['etudiant_id', 'matiere_id', 'note', 'date_saisie'];
    protected $useTimestamps = false;

    /**
     * Récupère les notes d'un étudiant pour un semestre
     */
    public function getNotesByEtudiantAndSemestre($etudiantId, $semestreId)
    {
        return $this->select('notes.*, matieres.code, matieres.libelle, ue.credits, ue.type')
            ->join('matieres', 'matieres.id = notes.matiere_id')
            ->join('ue', 'ue.id = matieres.ue_id')
            ->where('notes.etudiant_id', $etudiantId)
            ->where('ue.semestre_id', $semestreId)
<<<<<<< HEAD
            ->orderBy('notes.date_saisie', 'DESC')
=======
>>>>>>> 7ec1c4798172e4a891eb25b69eba843db9aca679
            ->orderBy('matieres.code', 'ASC')
            ->findAll();
    }

    /**
     * Vérifie si une note existe déjà
     */
    public function noteExists($etudiantId, $matiereId)
    {
        return $this->where('etudiant_id', $etudiantId)
            ->where('matiere_id', $matiereId)
            ->countAllResults() > 0;
    }

    /**
     * Récupère ou crée la note d'un étudiant pour une matière
     */
    public function getOrCreateNote($etudiantId, $matiereId)
    {
        $note = $this->where('etudiant_id', $etudiantId)
            ->where('matiere_id', $matiereId)
            ->first();

        if (!$note) {
            $this->insert([
                'etudiant_id' => $etudiantId,
                'matiere_id' => $matiereId,
                'note' => null,
                'date_saisie' => date('Y-m-d H:i:s')
            ]);
            return $this->where('etudiant_id', $etudiantId)
                ->where('matiere_id', $matiereId)
                ->first();
        }

        return $note;
    }

    /**
     * Insère ou met à jour la note
     */
    public function insertOrUpdateNote($etudiantId, $matiereId, $note)
    {
<<<<<<< HEAD
        return $this->insert([
            'etudiant_id' => $etudiantId,
            'matiere_id' => $matiereId,
            'note' => $note,
            'date_saisie' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Met à jour une note existante par son identifiant
     */
    public function updateNoteById($noteId, $note)
    {
        return $this->update($noteId, [
            'note' => $note,
            'date_saisie' => date('Y-m-d H:i:s')
        ]);
=======
        $existing = $this->where('etudiant_id', $etudiantId)
            ->where('matiere_id', $matiereId)
            ->first();

        if ($existing) {
            return $this->update($existing['id'], [
                'note' => $note,
                'date_saisie' => date('Y-m-d H:i:s')
            ]);
        } else {
            return $this->insert([
                'etudiant_id' => $etudiantId,
                'matiere_id' => $matiereId,
                'note' => $note,
                'date_saisie' => date('Y-m-d H:i:s')
            ]);
        }
>>>>>>> 7ec1c4798172e4a891eb25b69eba843db9aca679
    }
}
