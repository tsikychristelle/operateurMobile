<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$pageTitle = 'Accueil client';
$pageSubtitle = 'Bienvenue dans votre espace';
$activeNav = 'client-home';
$viewMode = 'client';
?>

<div class="card" style="max-width: 640px; margin: 0 auto;">
    <div class="card-header">
        <div>
            <h2>Bienvenue</h2>
            <p>Choisissez l’action à réaliser depuis votre espace client.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="form-grid" style="align-items: stretch;">
            <a href="/client-numero/solde" class="btn btn-primary" style="flex: 1; min-width: 180px; justify-content: center;">Voir le solde</a>
            <a href="/mouvement/depot" class="btn btn-ghost" style="flex: 1; min-width: 180px; justify-content: center;">Faire un dépôt</a>
            <a href="/mouvement/retrait" class="btn btn-ghost" style="flex: 1; min-width: 180px; justify-content: center;">Faire un retrait</a>
            <a href="/mouvement/transfert" class="btn btn-ghost" style="flex: 1; min-width: 180px; justify-content: center;">Faire un transfert</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>