<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$pageTitle = 'Connexion client';
$pageSubtitle = 'Accès à votre espace mobile';
$activeNav = 'client-login';
$viewMode = 'client';
?>

<div class="card" style="max-width: 560px; margin: 0 auto;">
    <div class="card-header">
        <div>
            <h2>Connexion client</h2>
            <p>Entrez vos informations pour accéder à votre compte.</p>
        </div>
    </div>
    <div class="card-body">
        <form action="/client-numero/login" method="post" class="form-grid">
            <div class="field">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" required>
            </div>
            <div class="field">
                <label for="numero">Numéro</label>
                <input type="text" name="numero" id="numero" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>