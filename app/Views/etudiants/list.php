<?php
use CodeIgniter\Routes\RouteCollection;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
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
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .btn-notes {
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
        }
        .table th {
            background-color: #0d6efd;
            color: white;
            font-weight: 600;
        }
        .table tbody tr:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <div class="table-container">
            <h1 class="mb-4">
                <i class="bi bi-people-fill"></i> Liste des Étudiants
            </h1>
            
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($etudiants ?? []) as $etudiant): ?>
                        <tr>
                            <td><?= $etudiant['id'] ?></td>
                            <td><?= $etudiant['matricule'] ?></td>
                            <td><?= $etudiant['nom'] ?></td>
                            <td><?= $etudiant['prenom'] ?></td>
                            <td>
                                <a href="<?= site_url('etudiants/' . $etudiant['id'] . '/notes') ?>" 
                                   class="btn btn-primary btn-notes" 
                                   title="Voir les notes">
                                    <i class="bi bi-file-earmark-text"></i> Notes
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>