<?php ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes - <?= $etudiant['prenom'] ?> <?= $etudiant['nom'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container-main {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header-section {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .student-name {
            font-size: 1.8rem;
            font-weight: 600;
            color: #0d6efd;
            margin: 0;
        }
        .student-info {
            color: #666;
            font-size: 0.95rem;
        }
        .year-section {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .year-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #0d6efd;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0d6efd;
        }
        .parcours-section {
            margin-bottom: 25px;
        }
        .parcours-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
            padding: 10px 15px;
            background-color: #e7f1ff;
            border-radius: 5px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .semester-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .semester-header {
            font-size: 1rem;
            font-weight: 600;
            color: #0d6efd;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .semester-link {
            font-size: 0.85rem;
            margin-left: 10px;
        }
        .grade-table {
            margin-bottom: 0;
        }
        .grade-table thead {
            background-color: #e7f1ff;
        }
        .grade-table th {
            font-weight: 600;
            color: #0d6efd;
            padding: 10px;
            border: none;
        }
        .grade-table td {
            padding: 10px;
            border-color: #dee2e6;
        }
        .grade-table tbody tr:hover {
            background-color: #f0f0f0;
        }
        .grade-excellent {
            font-weight: 600;
            color: #198754;
        }
        .grade-good {
            color: #0d6efd;
        }
        .grade-poor {
            color: #dc3545;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
        }
        .year-link-section {
            margin-top: 10px;
            text-align: right;
        }
        .year-link-section a {
            font-size: 0.85rem;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <a href="<?= site_url('etudiants/list') ?>" class="btn btn-secondary back-button">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>

        <div class="header-section">
            <p class="student-name">
                <i class="bi bi-person-fill"></i> <?= $etudiant['prenom'] ?> <?= $etudiant['nom'] ?>
            </p>
            <p class="student-info">
                <strong>Matricule:</strong> <?= $etudiant['matricule'] ?>
            </p>
        </div>

        <?php if (empty($groupedNotes)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Aucune note trouvée pour cet étudiant.
            </div>
        <?php else: ?>
            <?php foreach ($groupedNotes as $year => $parcours): ?>
                <div class="year-section">
                    <div class="year-title">
                        <span><?= $year ?></span>
                        <?php if (strpos($year, 'L') === 0): ?>
                            <a href="<?= site_url('etudiants/' . $etudiant['id'] . '/notes/year/' . $year) ?>" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-graph-up"></i> Voir moyenne annuelle
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php foreach ($parcours as $parcoursCode => $parcoursData): ?>
                        <div class="parcours-section">
                            <div class="parcours-title">
                                <span>
                                    <i class="bi bi-mortarboard-fill"></i> 
                                    <?= $parcoursData['libelle'] ?? $parcoursCode ?>
                                </span>
                            </div>

                            <?php foreach ($parcoursData['semesters'] as $semestreCode => $notes): ?>
                                <div class="semester-card">
                                    <div class="semester-header">
                                        <span>
                                            <i class="bi bi-calendar-check"></i> 
                                            Semestre <?= $semestreCode ?>
                                        </span>
                                        <a href="<?= site_url('etudiants/' . $etudiant['id'] . '/notes/semester/' . $semestreCode) ?>" 
                                           class="btn btn-sm btn-outline-primary semester-link">
                                            <i class="bi bi-arrow-right-circle"></i> Détails
                                        </a>
                                    </div>

                                    <table class="table grade-table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Unité d'Enseignement</th>
                                                <th>Matière</th>
                                                <th class="text-center">Note</th>
                                                <th class="text-center">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                // Group by UE and remove duplicate matières (by id if available, otherwise by libelle)
                                                $groupedByUE = [];
                                                $seen = [];
                                                foreach ($notes as $note) {
                                                    $ue = $note->ue_libelle;
                                                    $key = isset($note->matiere_id) ? 'id_' . $note->matiere_id : 'lib_' . $note->matiere_libelle;

                                                    if (!isset($groupedByUE[$ue])) {
                                                        $groupedByUE[$ue] = [];
                                                    }
                                                    if (!isset($seen[$ue])) {
                                                        $seen[$ue] = [];
                                                    }
                                                    if (isset($seen[$ue][$key])) {
                                                        continue; // skip duplicate matiere for this UE
                                                    }
                                                    $seen[$ue][$key] = true;
                                                    $groupedByUE[$ue][] = $note;
                                                }
                                            ?>
                                            <?php foreach ($groupedByUE as $ueName => $matieres): ?>
                                                <?php foreach ($matieres as $index => $note): ?>
                                                    <tr>
                                                        <?php if ($index === 0): ?>
                                                            <td rowspan="<?= count($matieres) ?>">
                                                                <strong><?= $ueName ?></strong>
                                                            </td>
                                                        <?php endif; ?>
                                                        <td><?= $note->matiere_libelle ?></td>
                                                        <td class="text-center">
                                                            <span class="<?php
                                                                if ($note->note >= 15) echo 'grade-excellent';
                                                                elseif ($note->note >= 12) echo 'grade-good';
                                                                else echo 'grade-poor';
                                                            ?>">
                                                                <?= number_format($note->note, 2, ',', '') ?>
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if ($note->ue_type === 'optionnelle'): ?>
                                                                <span class="badge bg-warning text-dark">Optionnel</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-info">Obligatoire</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
