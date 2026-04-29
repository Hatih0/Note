<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Saisie des Notes</title>
    <link rel="stylesheet" href="<?= base_url('css/note-form.css') ?>">
    <style {csp-style-nonce}>
        * {
            transition: background-color 300ms ease, color 300ms ease;
        }
        *:focus {
            background-color: rgba(221, 72, 20, .2);
            outline: none;
        }
        html, body {
            color: rgba(33, 37, 41, 1);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            font-size: 16px;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
    </style>
</head>
<body>
    <div class="container-note">
        <header class="note-header">
            <h1>📝 Gestion des Notes</h1>
            <p>Saisie et gestion des notes par semestre</p>
        </header>

        <main class="note-main">
            <!-- Section de sélection du semestre -->
            <div class="selection-section">
                <div class="form-group">
                    <label for="semestre">Sélectionner un semestre :</label>
                    <select id="semestre" class="form-control">
                        <option value="">-- Choisir un semestre --</option>
                        <?php foreach ($semestres as $semestre): ?>
                            <option value="<?= $semestre['id'] ?>">
                                Semestre <?= $semestre['code'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="etudiant">Matricule de l'étudiant :</label>
                    <select id="etudiant" class="form-control">
                        <option value="">-- Choisir un étudiant --</option>
                        <?php foreach ($etudiants as $etudiant): ?>
                            <option value="<?= esc($etudiant['matricule']) ?>">
                                <?= esc($etudiant['matricule']) ?> - <?= esc($etudiant['nom'] . ' ' . $etudiant['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button id="charger-btn" class="btn btn-primary">Charger les Matières</button>
            </div>

            <!-- Section de saisie des notes -->
            <div id="notes-section" class="notes-section" style="display: none;">
                <h2>Matières et Saisie des Notes</h2>
                <div id="matieres-list" class="matieres-list">
                    <!-- Les matières seront ajoutées ici par JavaScript -->
                </div>
            </div>

            <!-- Section de messages -->
            <div id="message" class="message" style="display: none;"></div>
        </main>
    </div>

    <script src="<?= base_url('js/note-form.js') ?>"></script>
</body>
</html>
