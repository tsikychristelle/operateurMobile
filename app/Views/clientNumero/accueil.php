<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$pageTitle = 'Accueil client';
$pageSubtitle = 'Bienvenue dans votre espace';
$activeNav = '';
?>

<div class="card" style="max-width: 640px; margin: 0 auto;">
    <div class="card-header">
        <div>
            <h2>Bienvenue</h2>
            <p>Choisissez l’action à réaliser depuis votre espace client.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="stat-grid">
            <div class="stat-card">
                <div class="label">Consultation</div>
                <div class="value green">Solde</div>
            </div>
        </div>
        <a href="/client-numero/solde" class="btn btn-primary">Voir le solde</a>
    </div>
</div>

<?= $this->endSection() ?>