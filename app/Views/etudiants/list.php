<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Matricule</th>
        <th>Nom</th>
        <th>Prénom</th>
    </tr>

    <?php foreach (($etudiants ?? []) as $etudiant): ?>
        <tr>
            <td><?= $etudiant['id'] ?></td>
            <td><?= $etudiant['matricule'] ?></td>
            <td><?= $etudiant['nom'] ?></td>
            <td><?= $etudiant['prenom'] ?></td>
        </tr>
    <?php endforeach; ?>

</table>