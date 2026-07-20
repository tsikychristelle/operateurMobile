<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div>
            <h2>Ajouter un type d'opération</h2>
            <p>Ex : Dépôt, Retrait, Transfert</p>
        </div>
    </div>
    <div class="card-body">
        <form action="/type-operation/save" method="post" class="form-grid">
            <div class="field">
                <label for="type">Type d'opération</label>
                <input type="text" id="type" name="type" placeholder="Ex: Dépôt" required>
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
            <h2>Types d'opération</h2>
            <p><?= count($types) ?> type(s) configuré(s)</p>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($types)): ?>
            <div class="empty-state">Aucun type d'opération pour le moment.</div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th class="actions">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($types as $t): ?>
                    <tr>
                        <td class="text-muted">#<?= esc($t['id']) ?></td>
                        <td><span class="badge badge-green"><?= esc($t['type']) ?></span></td>
                        <td class="actions">
                            <a class="btn-danger-link" href="/type-operation/delete/<?= $t['id'] ?>" onclick="return confirm('Supprimer ce type ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
