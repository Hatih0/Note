// =====================================================
// GESTION DU FORMULAIRE DE NOTES - AJAX
// =====================================================

document.addEventListener('DOMContentLoaded', function() {
    const semestreSelect = document.getElementById('semestre');
    const etudiantInput = document.getElementById('etudiant');
    const chargerBtn = document.getElementById('charger-btn');
    const notesSection = document.getElementById('notes-section');
    const matieresList = document.getElementById('matieres-list');
    const messageDiv = document.getElementById('message');

    let currentSemestreId = null;
    let currentEtudiantId = null;
    let matieres = [];

    // ===== Événement : Charger les matières ===== 
    chargerBtn.addEventListener('click', function() {
        const semestreId = semestreSelect.value;
        const etudiantId = etudiantInput.value.trim();

        // Validation
        if (!semestreId) {
            showMessage('Veuillez sélectionner un semestre', 'error');
            return;
        }

        if (!etudiantId) {
            showMessage('Veuillez entrer le matricule ou l\'ID de l\'étudiant', 'error');
            return;
        }

        currentSemestreId = semestreId;
        currentEtudiantId = etudiantId;

        loadMatieres(semestreId);
    });

    // ===== Charger les matières pour un semestre ===== 
    function loadMatieres(semestreId) {
        showLoading(chargerBtn, true);
        
        fetch(`/notes/get-matieres?semestre_id=${semestreId}`)
            .then(response => response.json())
            .then(data => {
                showLoading(chargerBtn, false);

                if (data.success) {
                    matieres = data.matieres;
                    renderMatieres(matieres);
                    notesSection.style.display = 'block';
                    showMessage('Matières chargées avec succès', 'success');
                } else {
                    showMessage('Erreur lors du chargement des matières', 'error');
                }
            })
            .catch(error => {
                showLoading(chargerBtn, false);
                console.error('Erreur AJAX:', error);
                showMessage('Erreur lors de la communication avec le serveur', 'error');
            });
    }

    // ===== Rendu des matières ===== 
    function renderMatieres(matieres) {
        if (matieres.length === 0) {
            matieresList.innerHTML = '<p style="text-align: center; color: #999;">Aucune matière trouvée pour ce semestre</p>';
            return;
        }

        matieresList.innerHTML = '';

        matieres.forEach(matiere => {
            const item = document.createElement('div');
            item.className = 'matiere-item';
            item.innerHTML = `
                <div class="matiere-code">${matiere.code}</div>
                
                <div class="matiere-info">
                    <div class="matiere-libelle">${matiere.libelle}</div>
                    <div class="matiere-details">
                        Type: <strong>${matiere.type}</strong>
                    </div>
                </div>
                
                <div class="matiere-credits">
                    <div class="credits-label">Crédits</div>
                    <div class="credits-value">${matiere.credits}</div>
                </div>
                
                <div class="matiere-input-group">
                    <input type="number" 
                           class="note-input" 
                           data-matiere-id="${matiere.id}" 
                           min="0" 
                           max="20" 
                           step="0.5" 
                           placeholder="0-20" />
                    <button class="btn btn-sm btn-save" 
                            data-matiere-id="${matiere.id}">
                        Enregistrer
                    </button>
                </div>
            `;

            matieresList.appendChild(item);
        });

        // Ajouter les écouteurs d'événements aux boutons
        attachEventListeners();
    }

    // ===== Attacher les écouteurs aux boutons ===== 
    function attachEventListeners() {
        const saveButtons = document.querySelectorAll('.btn-save');
        
        saveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const matiereId = this.dataset.matiereId;
                const noteInput = document.querySelector(`.note-input[data-matiere-id="${matiereId}"]`);
                const note = noteInput.value.trim();

                if (!note) {
                    showMessage('Veuillez entrer une note', 'error');
                    return;
                }

                saveNote(matiereId, note, button, noteInput);
            });
        });

        // Permettre l'enregistrement avec Entrée
        const noteInputs = document.querySelectorAll('.note-input');
        noteInputs.forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const button = this.nextElementSibling;
                    button.click();
                }
            });
        });
    }

    // ===== Enregistrer une note ===== 
    function saveNote(matiereId, note, button, input) {
        // Validation
        const noteValue = parseFloat(note);
        if (isNaN(noteValue) || noteValue < 0 || noteValue > 20) {
            showMessage('La note doit être entre 0 et 20', 'error');
            return;
        }

        showLoading(button, true);

        const formData = new FormData();
        formData.append('etudiant_id', currentEtudiantId);
        formData.append('matiere_id', matiereId);
        formData.append('note', noteValue);

        fetch('/notes/inserer', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            showLoading(button, false);

            if (data.success) {
                showMessage(`Note de ${noteValue}/20 enregistrée avec succès pour la matière`, 'success');
                
                // Mettre à jour l'affichage
                updateNoteDisplay(matiereId, noteValue);
            } else {
                showMessage(`Erreur: ${data.message}`, 'error');
            }
        })
        .catch(error => {
            showLoading(button, false);
            console.error('Erreur AJAX:', error);
            showMessage('Erreur lors de l\'enregistrement de la note', 'error');
        });
    }

    // ===== Mettre à jour l'affichage de la note ===== 
    function updateNoteDisplay(matiereId, note) {
        const input = document.querySelector(`.note-input[data-matiere-id="${matiereId}"]`);
        const item = input.closest('.matiere-item');
        
        // Ajouter une animation de succès
        item.style.backgroundColor = 'rgba(40, 167, 69, 0.1)';
        setTimeout(() => {
            item.style.backgroundColor = '';
        }, 1500);
    }

    // ===== Afficher/Masquer le loading ===== 
    function showLoading(element, show) {
        if (show) {
            element.disabled = true;
            element.innerHTML = '<span class="spinner"></span> Chargement...';
        } else {
            element.disabled = false;
            element.innerHTML = 'Charger les Matières';
        }
    }

    // ===== Afficher les messages ===== 
    function showMessage(message, type) {
        messageDiv.textContent = message;
        messageDiv.className = `message ${type}`;
        messageDiv.style.display = 'block';

        // Cacher le message après 5 secondes
        setTimeout(() => {
            messageDiv.style.display = 'none';
        }, 5000);
    }

    // ===== Gestion des changements de semestre ===== 
    semestreSelect.addEventListener('change', function() {
        matieresList.innerHTML = '';
        notesSection.style.display = 'none';
        messageDiv.style.display = 'none';
    });

    // ===== Gestion des changements d'étudiant ===== 
    etudiantInput.addEventListener('input', function() {
        messageDiv.style.display = 'none';
    });
});
