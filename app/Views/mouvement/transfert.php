<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="card" style="max-width: 720px; margin: 0 auto;">
    <div class="card-header">
        <div>
            <h2>Effectuer un transfert multiple</h2>
            <p>Le montant total sera partagé équitablement entre tous les récepteurs (s'ils appartiennent au même opérateur).</p>
        </div>
    </div>
    <div class="card-body">
        <form action="/mouvement/transfert" method="post" class="form-grid" id="transferForm">
            <div class="field">
                <label for="recepteurs">Numéros des récepteurs (séparés par des virgules)</label>
                <input type="text" name="recepteurs" id="recepteurs" placeholder="034XXXXXXX, 034YYYYYYY" required>
            </div>
            <div class="field">
                <label for="montant">Montant total à partager</label>
                <input type="number" name="montant" id="montant" min="1" step="0.01" required>
            </div>
            <input type="hidden" name="avecFrais" id="avecFrais" value="0">
            <button type="submit" class="btn btn-primary">Transférer</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('transferForm').addEventListener('submit', function () {
        const withFee = window.confirm('Voulez-vous envoyer avec les frais ?');
        document.getElementById('avecFrais').value = withFee ? '1' : '0';
    });
</script>

<?= $this->endSection() ?>