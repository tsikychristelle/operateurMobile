<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$pageTitle = 'Transfert client';
$pageSubtitle = 'Transfert avec frais selon l’intervalle';
$activeNav = 'client-home';
$viewMode = 'client';
?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="card" style="max-width: 720px; margin: 0 auto;">
    <div class="card-header">
        <div>
            <h2>Effectuer un transfert</h2>
            <p>Le compte connecté est débité du montant plus le frais, et le récepteur reçoit le montant transféré.</p>
        </div>
    </div>
    <div class="card-body">
        <form action="/mouvement/transfert" method="post" class="form-grid">
            <div class="field">
                <label for="recepteur">Numéro du récepteur</label>
                <input type="text" name="recepteur" id="recepteur" required>
            </div>
            <div class="field">
                <label for="montant">Montant</label>
                <input type="number" name="montant" id="montant" min="1" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Transférer</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>