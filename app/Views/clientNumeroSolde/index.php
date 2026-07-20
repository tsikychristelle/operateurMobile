<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$pageTitle = 'Solde du client';
$pageSubtitle = 'Consultation du compte';
$activeNav = 'client-solde';
$viewMode = 'client';
?>

<div class="card" style="max-width: 640px; margin: 0 auto;">
    <div class="card-header">
        <div>
            <h2>Solde actuel</h2>
            <p>Voici le montant disponible sur votre compte.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="stat-card">
            <div class="label">Montant disponible</div>
            <div class="value orange"><?= esc($clientNumeroSoldes['solde'] ?? 0) ?> Ar</div>
        </div>
        <a href="/client-numero/accueil" class="btn btn-ghost">Retour</a>
    </div>
</div>

<?= $this->endSection() ?>