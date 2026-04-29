<?php ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes Semestre - <?= $etudiant['prenom'] ?> <?= $etudiant['nom'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container-main {
            max-width: 1000px;
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
            margin-bottom: 5px;
        }
        .semester-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .stats-section {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .stat-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #0d6efd;
        }
        .notes-section {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table-section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #0d6efd;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0d6efd;
        }
        .grade-table thead {
            background-color: #e7f1ff;
        }
        .grade-table th {
            font-weight: 600;
            color: #0d6efd;
            border: none;
            padding: 12px;
        }
        .grade-table td {
            padding: 12px;
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
            font-weight: 600;
            color: #0d6efd;
        }
        .grade-poor {
            font-weight: 600;
            color: #dc3545;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
        }
        .breadcrumb-custom {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <nav class="breadcrumb-custom">
            <a href="<?= site_url('etudiants/list') ?>" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Étudiants
            </a>
            <span class="mx-2">/</span>
            <a href="<?= site_url('etudiants/' . $etudiant['id'] . '/notes') ?>" class="btn btn-sm btn-secondary">
                <i class="bi bi-file-earmark-text"></i> Notes
            </a>
            <span class="mx-2">/</span>
            <span class="btn btn-sm btn-primary disabled">
                <i class="bi bi-calendar-check"></i> Semestre <?= $semestreCode ?>
            </span>
        </nav>

        <div class="header-section">
            <p class="student-name">
                <i class="bi bi-person-fill"></i> <?= $etudiant['prenom'] ?> <?= $etudiant['nom'] ?>
            </p>
            <p class="student-info">
                <strong>Matricule:</strong> <?= $etudiant['matricule'] ?>
            </p>
            <p class="semester-title">
                <i class="bi bi-calendar-check"></i> Semestre <?= $semestreCode ?>
            </p>
        </div>

        <div class="stats-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="stat-label">Moyenne du Semestre</div>
                        <div class="stat-value <?php 
                            if ($stats['average'] >= 15) echo 'text-success';
                            elseif ($stats['average'] >= 12) echo 'text-info';
                            else echo 'text-danger';
                        ?>">
                            <?= number_format($stats['average'], 2, ',', '') ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="stat-label">Nombre de Matières</div>
                        <div class="stat-value"><?= $stats['count'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="notes-section">
            <h2 class="table-section-title">
                <i class="bi bi-table"></i> Détail des Notes
            </h2>

            <?php if (empty($notes)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Aucune note trouvée pour ce semestre.
                </div>
            <?php else: ?>
                <table class="table grade-table table-hover">
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
                            $groupedByUE = [];
                            foreach ($notes as $note) {
                                if (!isset($groupedByUE[$note->ue_libelle])) {
                                    $groupedByUE[$note->ue_libelle] = [];
                                }
                                $groupedByUE[$note->ue_libelle][] = $note;
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
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
