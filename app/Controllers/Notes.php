<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\MatiereModel;
use App\Models\NoteModel;

class Notes extends BaseController
{
    protected $etudiantModel;
    protected $matiereModel;
    protected $noteModel;

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
        $this->matiereModel = new MatiereModel();
        $this->noteModel = new NoteModel();
    }

    private function resolveEtudiantId($value): ?int
    {
        $etudiant = $this->etudiantModel->resolveIdentifier((string) $value);

        return $etudiant['id'] ?? null;
    }

    /**
     * Affiche le formulaire de saisie des notes
     */
    public function index()
    {
        $semestres = $this->matiereModel->getSemestres();
<<<<<<< HEAD
        $etudiants = $this->etudiantModel
            ->select('id, matricule, nom, prenom')
            ->orderBy('matricule', 'ASC')
            ->findAll();

        return view('notes/formulaire', [
            'semestres' => $semestres,
            'etudiants' => $etudiants
=======

        return view('notes/formulaire', [
            'semestres' => $semestres
>>>>>>> 7ec1c4798172e4a891eb25b69eba843db9aca679
        ]);
    }

    /**
     * Récupère les matières pour un semestre en AJAX
     */
    public function getMatieresBySemestre()
    {
        $semestreId = $this->request->getGet('semestre_id');

        if (!$semestreId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Semestre non spécifié']);
        }

        $matieres = $this->matiereModel->getMatieresBySemestre($semestreId);

        return $this->response->setJSON([
            'success' => true,
            'matieres' => $matieres
        ]);
    }

    /**
     * Insère ou met à jour une note
     */
    public function insererNote()
    {
        $etudiantValue = $this->request->getPost('etudiant_id');
        $matiereId = $this->request->getPost('matiere_id');
        $note = $this->request->getPost('note');

        $etudiantId = $this->resolveEtudiantId($etudiantValue);

        // Validation
        if (!$etudiantId || !$matiereId || $note === '' || $note === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Étudiant introuvable ou données invalides'
            ]);
        }

        $note = floatval($note);

        if ($note < 0 || $note > 20) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'La note doit être entre 0 et 20'
            ]);
        }

        try {
            $result = $this->noteModel->insertOrUpdateNote($etudiantId, $matiereId, $note);

            if ($result) {
                // Récupérer la note complète pour le retour
                $noteBD = $this->noteModel->where('etudiant_id', $etudiantId)
                    ->where('matiere_id', $matiereId)
                    ->first();

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Note enregistrée avec succès',
                    'note' => $noteBD
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur lors de l\'enregistrement'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    /**
<<<<<<< HEAD
     * Modifie une note existante
     */
    public function modifierNote()
    {
        $noteId = $this->request->getPost('note_id');
        $note = $this->request->getPost('note');

        if (!$noteId || $note === '' || $note === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Note introuvable ou données invalides'
            ]);
        }

        $note = floatval($note);

        if ($note < 0 || $note > 20) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'La note doit être entre 0 et 20'
            ]);
        }

        try {
            $result = $this->noteModel->updateNoteById($noteId, $note);

            if ($result) {
                $noteBD = $this->noteModel->find($noteId);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Note modifiée avec succès',
                    'note' => $noteBD
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la modification'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    /**
=======
>>>>>>> 7ec1c4798172e4a891eb25b69eba843db9aca679
     * Récupère les notes d'un étudiant pour un semestre
     */
    public function getNotesByEtudiant()
    {
        $etudiantValue = $this->request->getGet('etudiant_id');
        $semestreId = $this->request->getGet('semestre_id');
        $etudiantId = $this->resolveEtudiantId($etudiantValue);

        if (!$etudiantId || !$semestreId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Étudiant introuvable ou paramètres manquants'
            ]);
        }

        $notes = $this->noteModel->getNotesByEtudiantAndSemestre($etudiantId, $semestreId);

        return $this->response->setJSON([
            'success' => true,
            'notes' => $notes
        ]);
    }
}
