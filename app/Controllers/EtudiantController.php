<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\NoteModel;

class EtudiantController extends BaseController
{
    private EtudiantModel $etudiantModel;
    private NoteModel $noteModel;

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
        $this->noteModel = new NoteModel();
    }

    public function findAll()
    {
        $data = $this->etudiantModel->findAll();
        return view('etudiants/list', ['etudiants' => $data]);
    }

    /**
     * View student details with all their grades organized by parcours and semester
     */
    public function viewNotes($id)
    {
        $etudiant = $this->etudiantModel->find($id);
        
        if (!$etudiant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Étudiant non trouvé');
        }

        $notes = $this->noteModel->getNotesByParcoursAndSemester($id);
        
        // Group notes by year and parcours
        $groupedNotes = $this->groupNotesByYearAndParcours($notes);

        return view('etudiants/notes', [
            'etudiant' => $etudiant,
            'groupedNotes' => $groupedNotes
        ]);
    }

    /**
     * View notes for a specific semester
     */
    public function notesBySemester($id, $semestreCode)
    {
        $etudiant = $this->etudiantModel->find($id);
        
        if (!$etudiant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Étudiant non trouvé');
        }

        $notes = $this->noteModel->getNotesBySemester($id, $semestreCode);
        
        // Calculate semester average
        $stats = $this->calculateSemesterStats($notes);

        return view('etudiants/notes-semester', [
            'etudiant' => $etudiant,
            'semestreCode' => $semestreCode,
            'notes' => $notes,
            'stats' => $stats
        ]);
    }

    /**
     * View notes for a specific year (L2 shows both S3 and S4 with average)
     */
    public function notesByYear($id, $annee)
    {
        $etudiant = $this->etudiantModel->find($id);
        
        if (!$etudiant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Étudiant non trouvé');
        }

        $notes = $this->noteModel->getNotesByYear($id, $annee);
        
        // Group by semester for L2 display
        $groupedBySemester = [];
        foreach ($notes as $note) {
            if (!isset($groupedBySemester[$note->semestre_code])) {
                $groupedBySemester[$note->semestre_code] = [];
            }
            $groupedBySemester[$note->semestre_code][] = $note;
        }

        // Calculate averages if L2 (should have multiple semesters)
        $allNotes = array_merge(...array_values($groupedBySemester));
        $globalAverage = $this->calculateGlobalAverage($allNotes);

        return view('etudiants/notes-year', [
            'etudiant' => $etudiant,
            'annee' => $annee,
            'groupedBySemester' => $groupedBySemester,
            'globalAverage' => $globalAverage
        ]);
    }

    /**
     * Group notes by year and parcours
     */
    private function groupNotesByYearAndParcours($notes)
    {
        $grouped = [];
        
        foreach ($notes as $note) {
            $year = $note->annee;
            $parcoursCode = $note->parcours_code;
            $semestre = $note->semestre_code;
            
            if (!isset($grouped[$year])) {
                $grouped[$year] = [];
            }
            if (!isset($grouped[$year][$parcoursCode])) {
                $grouped[$year][$parcoursCode] = [
                    'libelle' => $note->parcours_libelle,
                    'semesters' => []
                ];
            }
            if (!isset($grouped[$year][$parcoursCode]['semesters'][$semestre])) {
                $grouped[$year][$parcoursCode]['semesters'][$semestre] = [];
            }
            
            $grouped[$year][$parcoursCode]['semesters'][$semestre][] = $note;
        }
        
        return $grouped;
    }

    /**
     * Calculate semester statistics
     */
    private function calculateSemesterStats($notes)
    {
        if (empty($notes)) {
            return ['average' => 0, 'count' => 0];
        }

        $total = 0;
        $count = 0;
        $obligatoire_total = 0;
        $obligatoire_count = 0;
        $optionnelle_best = [];

        foreach ($notes as $note) {
            $total += $note->note;
            $count++;

            if ($note->ue_type === 'obligatoire') {
                $obligatoire_total += $note->note;
                $obligatoire_count++;
            } else if ($note->ue_type === 'optionnelle') {
                // For optional, keep track of best grade per UE
                if (!isset($optionnelle_best[$note->ue_libelle])) {
                    $optionnelle_best[$note->ue_libelle] = $note->note;
                } else {
                    $optionnelle_best[$note->ue_libelle] = max($optionnelle_best[$note->ue_libelle], $note->note);
                }
            }
        }

        // Calculate with optional best grades
        $optional_total = array_sum($optionnelle_best);
        $final_total = $obligatoire_total + $optional_total;
        $final_count = $obligatoire_count + count($optionnelle_best);
        $average = $final_count > 0 ? $final_total / $final_count : 0;

        return [
            'average' => round($average, 2),
            'count' => $count,
            'total' => round($final_total, 2)
        ];
    }

    /**
     * Calculate global average (used for L2 with multiple semesters)
     */
    private function calculateGlobalAverage($notes)
    {
        if (empty($notes)) {
            return 0;
        }

        $total = 0;
        $count = 0;
        $optionnelle_best = [];

        foreach ($notes as $note) {
            if ($note->ue_type === 'obligatoire') {
                $total += $note->note;
                $count++;
            } else if ($note->ue_type === 'optionnelle') {
                if (!isset($optionnelle_best[$note->ue_libelle])) {
                    $optionnelle_best[$note->ue_libelle] = $note->note;
                } else {
                    $optionnelle_best[$note->ue_libelle] = max($optionnelle_best[$note->ue_libelle], $note->note);
                }
            }
        }

        $optional_total = array_sum($optionnelle_best);
        $final_total = $total + $optional_total;
        $final_count = $count + count($optionnelle_best);
        
        return $final_count > 0 ? round($final_total / $final_count, 2) : 0;
    }
}