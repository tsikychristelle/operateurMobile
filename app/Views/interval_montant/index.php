<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div>
            <h2>Ajouter une tranche de montant</h2>
            <p>Ces tranches servent de base aux barèmes de frais (dépôt / retrait / transfert)</p>
        </div>
    </div>
    <div class="card-body">
        <form action="/interval-montant/save" method="post" class="form-grid">
            <div class="field">
                <label for="debut">Montant début (Ar)</label>
                <input type="number" id="debut" name="debut" placeholder="Ex: 100" required>
            </div>
            <div class="field">
                <label for="fin">Montant fin (Ar)</label>
                <input type="number" id="fin" name="fin" placeholder="Ex: 1000" required>
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
            <h2>Tranches de montant</h2>
            <p><?= count($intervalles) ?> tranche(s) configurée(s)</p>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($intervalles)): ?>
            <div class="empty-state">Aucune tranche de montant pour le moment.</div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Montant compris entre</th>
                        <th class="actions">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($intervalles as $i): ?>
                    <tr>
                        <td><span class="mono"><?= number_format((float)$i['debut'], 0, ',', ' ') ?> Ar</span> et <span class="mono"><?= number_format((float)$i['fin'], 0, ',', ' ') ?> Ar</span></td>
                        <td class="actions">
                            <a class="btn-danger-link" href="/interval-montant/delete/<?= $i['id'] ?>" onclick="return confirm('Supprimer cette tranche ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
