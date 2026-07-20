<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div>
            <h2>Ajouter un statut</h2>
            <p>Ex : Avec frais, Sans frais</p>
        </div>
    </div>
    <div class="card-body">
        <form action="/status/save" method="post" class="form-grid">
            <div class="field">
                <label for="libelle">Libellé du statut</label>
                <input type="text" id="libelle" name="libelle" placeholder="Ex: Avec frais" required>
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
            <h2>Statuts</h2>
            <p><?= count($status) ?> statut(s) configuré(s)</p>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($status)): ?>
            <div class="empty-state">Aucun statut pour le moment.</div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Libellé</th>
                        <th class="actions">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($status as $s): ?>
                    <tr>
                        <td class="text-muted">#<?= esc($s['id']) ?></td>
                        <td><span class="badge badge-navy"><?= esc($s['libelle']) ?></span></td>
                        <td class="actions">
                            <a class="btn-danger-link" href="/status/delete/<?= $s['id'] ?>" onclick="return confirm('Supprimer ce statut ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
