<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$pageTitle = 'Dépôt';
$pageSubtitle = 'Ajoutez de l’argent sur votre compte';
$activeNav = 'client-depot';
$viewMode = 'client';
?>

<div class="card" style="max-width: 560px; margin: 0 auto;">
    <div class="card-header">
        <div>
            <h2>Faire un dépôt</h2>
            <p>Indiquez le montant que vous souhaitez ajouter à votre solde.</p>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
        <?php endif; ?>

        <div class="stat-card" style="margin-bottom: 20px;">
            <div class="label">Solde actuel</div>
            <div class="value orange"><?= esc(number_format($currentSolde, 0, ',', ' ')) ?> Ar</div>
        </div>

        <form action="/mouvement/depot" method="post" class="form-grid">
            <div class="field">
                <label for="montant">Montant</label>
                <input type="number" step="0.01" min="0.01" name="montant" id="montant" placeholder="Ex: 5000" required>
            </div>
            <button type="submit" class="btn btn-primary">Valider le dépôt</button>
        </form>

        <a href="/client-numero/accueil" class="btn btn-ghost" style="margin-top: 18px; display: inline-block;">Retour</a>
    </div>
</div>

<?= $this->endSection() ?>
