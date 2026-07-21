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
            <a href="/epargne" class="btn btn-ghost" style="flex: 1; min-width: 180px; justify-content: center;">Faire une epargne </a>
        </div>
    </div>
</div>

<div class="card" style="max-width: 840px; margin: 24px auto 0;">
    <div class="card-header">
        <div>
            <h2>Historique des mouvements</h2>
            <p>Vos derniers dépôts, retraits et transferts.</p>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($mouvements)): ?>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 8px 6px;">Date</th>
                        <th style="text-align: left; padding: 8px 6px;">Type</th>
                        <th style="text-align: left; padding: 8px 6px;">Montant</th>
                        <th style="text-align: left; padding: 8px 6px;">Partenaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mouvements as $mouvement): ?>
                        <tr>
                            <td style="padding: 8px 6px;"><?= esc(date('d/m/Y H:i', strtotime($mouvement['date']))) ?></td>
                            <td style="padding: 8px 6px;"><?= esc($mouvement['typeOperation'] ?? 'Mouvement') ?></td>
                            <td style="padding: 8px 6px;"><?= esc(number_format((float) ($mouvement['montant'] ?? 0), 0, ',', ' ')) ?> Ar</td>
                            <td style="padding: 8px 6px;"><?= esc($mouvement['numeroRecepteur'] ?: $mouvement['numeroEnvoyeur'] ?: '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun mouvement enregistré pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>