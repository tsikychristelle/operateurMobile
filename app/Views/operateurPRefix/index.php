<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div>
            <h2>Ajouter un préfixe</h2>
            <p>Associez un préfixe (ex : 033, 037) à un opérateur</p>
        </div>
    </div>
    <div class="card-body">
        <form action="/operateur-prefix/save" method="post" class="form-grid">
            <div class="field">
                <label for="idOperateur">Opérateur</label>
                <select id="idOperateur" name="idOperateur" required>
                    <option value="">-- Choisir un opérateur --</option>
                    <?php foreach ($operateurs as $op): ?>
                        <option value="<?= $op['id'] ?>"><?= esc($op['libelle']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="prefix">Préfixe</label>
                <input type="text" id="prefix" name="prefix" placeholder="Préfixe (ex: 033)" maxlength="3" required>
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
            <h2>Préfixes configurés</h2>
            <p><?= count($prefixes) ?> préfixe(s)</p>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($prefixes)): ?>
            <div class="empty-state">Aucun préfixe configuré pour le moment.</div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Préfixe</th>
                        <th>Opérateur</th>
                        <th class="actions">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($prefixes as $p): ?>
                    <tr>
                        <td><span class="mono"><?= esc($p['prefix']) ?></span></td>
                        <td><span class="badge badge-navy"><?= esc($p['libelle']) ?></span></td>
                        <td class="actions">
                            <a class="btn-danger-link" href="/operateur-prefix/delete/<?= $p['id'] ?>" onclick="return confirm('Supprimer ce préfixe ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
