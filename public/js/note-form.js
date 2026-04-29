// =====================================================
// GESTION DU FORMULAIRE DE NOTES - AJAX
// =====================================================

document.addEventListener('DOMContentLoaded', function() {
    const semestreSelect = document.getElementById('semestre');
    const etudiantSelect = document.getElementById('etudiant');
    const chargerBtn = document.getElementById('charger-btn');
    const notesSection = document.getElementById('notes-section');
    const matieresList = document.getElementById('matieres-list');
    const messageDiv = document.getElementById('message');

    let currentSemestreId = null;
    let currentEtudiantId = null;
    let matieres = [];
    let notesByMatiere = {};

    // ===== Événement : Charger les matières ===== 
    chargerBtn.addEventListener('click', function() {
        const semestreId = semestreSelect.value;
        const etudiantId = etudiantSelect.value.trim();

        // Validation
        if (!semestreId) {
            showMessage('Veuillez sélectionner un semestre', 'error');
            return;
        }

        if (!etudiantId) {
            showMessage('Veuillez sélectionner un étudiant', 'error');
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
                    loadExistingNotes(semestreId);
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

    function loadExistingNotes(semestreId) {
        fetch(`/notes/get-notes?semestre_id=${semestreId}&etudiant_id=${encodeURIComponent(currentEtudiantId)}`)
            .then(response => response.json())
            .then(data => {
                notesByMatiere = {};

                if (data.success && Array.isArray(data.notes)) {
                    data.notes.forEach(note => {
                        if (!notesByMatiere[note.matiere_id]) {
                            notesByMatiere[note.matiere_id] = [];
                        }

                        notesByMatiere[note.matiere_id].push(note);
                    });
                }

                renderMatieres(matieres);
                notesSection.style.display = 'block';
                showMessage('Matières chargées avec succès', 'success');
            })
            .catch(error => {
                console.error('Erreur AJAX:', error);
                renderMatieres(matieres);
                notesSection.style.display = 'block';
                showMessage('Matières chargées avec succès', 'success');
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
            const notes = notesByMatiere[matiere.id] || [];
            const notesHtml = notes.length > 0
                ? `
                    <div class="notes-history" data-matiere-id="${matiere.id}">
                        ${notes.map(note => `
                            <div class="note-row" data-note-id="${note.id}">
                                <div class="note-row-value">
                                    <strong>${note.note}</strong>/20
                                    <span class="note-row-date">${formatDate(note.date_saisie)}</span>
                                </div>
                                <div class="note-row-actions">
                                    <button class="btn btn-sm btn-edit-note" data-note-id="${note.id}" data-note-value="${note.note}">Modifier</button>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `
                : '<div class="notes-history empty">Aucune note enregistrée</div>';

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

                <div class="matiere-notes-block">
                    ${notesHtml}
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
                        Ajouter
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
        const editButtons = document.querySelectorAll('.btn-edit-note');
        
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

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const noteId = this.dataset.noteId;
                const noteValue = this.dataset.noteValue;
                beginEditNote(noteId, noteValue, this);
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
                showMessage(`Nouvelle note de ${noteValue}/20 ajoutée avec succès`, 'success');
                input.value = '';
                reloadNotes();
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

    function beginEditNote(noteId, noteValue, button) {
        const row = button.closest('.note-row');
        if (!row) {
            return;
        }

        row.innerHTML = `
            <div class="note-row-value editing">
                <input type="number" class="note-edit-input" min="0" max="20" step="0.5" value="${noteValue}">
            </div>
            <div class="note-row-actions">
                <button class="btn btn-sm btn-confirm-edit" data-note-id="${noteId}">Sauver</button>
                <button class="btn btn-sm btn-cancel-edit" data-note-id="${noteId}" data-note-value="${noteValue}">Annuler</button>
            </div>
        `;

        const confirmButton = row.querySelector('.btn-confirm-edit');
        const cancelButton = row.querySelector('.btn-cancel-edit');
        const editInput = row.querySelector('.note-edit-input');

        confirmButton.addEventListener('click', function() {
            const newValue = editInput.value.trim();
            updateNote(noteId, newValue);
        });

        cancelButton.addEventListener('click', function() {
            reloadNotes();
        });
    }

    function updateNote(noteId, note) {
        const noteValue = parseFloat(note);
        if (isNaN(noteValue) || noteValue < 0 || noteValue > 20) {
            showMessage('La note doit être entre 0 et 20', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('note_id', noteId);
        formData.append('note', noteValue);

        fetch('/notes/modifier', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(`Note modifiée en ${noteValue}/20`, 'success');
                reloadNotes();
            } else {
                showMessage(`Erreur: ${data.message}`, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur AJAX:', error);
            showMessage('Erreur lors de la modification de la note', 'error');
        });
    }

    function reloadNotes() {
        if (!currentSemestreId || !currentEtudiantId) {
            return;
        }

        loadExistingNotes(currentSemestreId);
    }

    function formatDate(dateString) {
        if (!dateString) {
            return '';
        }

        const date = new Date(dateString.replace(' ', 'T'));
        if (Number.isNaN(date.getTime())) {
            return dateString;
        }

        return date.toLocaleString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
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
    etudiantSelect.addEventListener('change', function() {
        messageDiv.style.display = 'none';
    });
});
