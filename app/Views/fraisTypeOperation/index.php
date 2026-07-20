<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$pageTitle = 'Configurations des frais';
$pageSubtitle = 'Gestion des frais par type d’opération';
$activeNav = 'type';

$typeLabels = [];
foreach ($types as $type) {
    $typeLabels[$type['id']] = $type['type'];
}
?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="stat-grid">
    <div class="stat-card">
        <div class="label">Règles de frais enregistrées</div>
        <div class="value orange"><?= count($fraisTypeOperation) ?></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h2>Ajouter une règle de frais</h2>
            <p>Définissez un intervalle et le montant associé à un type d’opération.</p>
        </div>
    </div>
    <div class="card-body">
        <form action="/frais-type-operation/save" method="post" class="form-grid">
            <div class="field">
                <label for="typeOperation">Type d’opération</label>
                <select name="typeOperation" id="typeOperation" required>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= esc($type['id']) ?>"><?= esc($type['type']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="debut">Début</label>
                <input type="number" name="debut" id="debut" required>
            </div>
            <div class="field">
                <label for="fin">Fin</label>
                <input type="number" name="fin" id="fin" required>
            </div>
            <div class="field">
                <label for="frais">Frais</label>
                <input type="number" name="frais" id="frais" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Ajouter
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h2>Liste des frais par type</h2>
            <p><?= count($fraisTypeOperation) ?> règle(s) configurée(s)</p>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($fraisTypeOperation)): ?>
            <div class="empty-state">Aucune règle de frais pour le moment.</div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Frais</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fraisTypeOperation as $frais): ?>
                        <tr>
                            <td><span class="badge badge-green"><?= esc($typeLabels[$frais['idTypeOperation']] ?? $frais['idTypeOperation']) ?></span></td>
                            <td class="mono"><?= esc($frais['debut']) ?></td>
                            <td class="mono"><?= esc($frais['fin']) ?></td>
                            <td class="mono"><?= esc($frais['frais']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>