<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? esc($pageTitle) . ' · OpérateurMobile' : 'OpérateurMobile' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="app-shell">

    <?php
        $viewMode = $viewMode ?? '';
        $isClientView = ($viewMode === 'client');
    ?>

    <aside class="sidebar">
        <div class="brand <?= $isClientView ? 'brand-client' : '' ?>">
            <div class="brand-mark <?= $isClientView ? 'brand-mark-client' : '' ?>"><?= $isClientView ? 'CL' : 'OM' ?></div>
            <div class="brand-text">
                <div class="title"><?= $isClientView ? 'Espace client' : 'OpérateurMobile' ?></div>
                <div class="subtitle"><?= $isClientView ? 'Mobile · V1' : 'Back-office · V1' ?></div>
            </div>
        </div>

        <?php if ($isClientView): ?>
            <div class="nav-section-label">Côté utilisateur</div>
            <ul class="nav-list">
                <li>
                    <a href="/client-numero/solde" class="nav-link <?= ($activeNav ?? '') === 'client-solde' ? 'active' : '' ?>">
                        <span class="ic">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </span>
                        Voir le solde
                    </a>
                </li>
                <li>
                    <a href="/mouvement/depot" class="nav-link <?= ($activeNav ?? '') === 'client-depot' ? 'active' : '' ?>">
                        <span class="ic">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></svg>
                        </span>
                        Faire un dépôt
                    </a>
                </li>
                <li>
                    <a href="/mouvement/retrait" class="nav-link <?= ($activeNav ?? '') === 'client-retrait' ? 'active' : '' ?>">
                        <span class="ic">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M19 12l-7 7-7-7"/></svg>
                        </span>
                        Faire un retrait
                    </a>
                </li>
                <li>
                    <a href="/mouvement/transfert" class="nav-link <?= ($activeNav ?? '') === 'client-transfert' ? 'active' : '' ?>">
                        <span class="ic">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 1l4 4-4 4"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><path d="M7 23l-4-4 4-4"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                        </span>
                        Faire un transfert
                    </a>
                </li>
            </ul>
        <?php else: ?>
            <div class="nav-section-label">Côté opérateur</div>
            <ul class="nav-list">
                <li>
                    <a href="/operateur" class="nav-link <?= ($activeNav ?? '') === 'operateur' ? 'active' : '' ?>">
                        <span class="ic">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </span>
                        Opérateurs
                    </a>
                </li>
                <li>
                    <a href="/operateur-prefix" class="nav-link <?= ($activeNav ?? '') === 'prefix' ? 'active' : '' ?>">
                        <span class="ic">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M9 18h6"/></svg>
                        </span>
                        Préfixes
                    </a>
                </li>
                <li>
                    <a href="/type-operation" class="nav-link <?= ($activeNav ?? '') === 'type' ? 'active' : '' ?>">
                        <span class="ic">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 1l4 4-4 4"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><path d="M7 23l-4-4 4-4"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                        </span>
                        Types d'opération
                    </a>
                </li>
                <li>
                    <a href="/interval-montant" class="nav-link <?= ($activeNav ?? '') === 'interval' ? 'active' : '' ?>">
                        <span class="ic">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </span>
                        Tranches de montant
                    </a>
                </li>
                <li>
                    <a href="/status" class="nav-link <?= ($activeNav ?? '') === 'status' ? 'active' : '' ?>">
                        <span class="ic">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>
                        </span>
                        Statuts
                    </a>
                </li>
            </ul>
        <?php endif; ?>

        <div class="sidebar-foot">Prototype interne &mdash; Version 1</div>
    </aside>

    <div class="main">
        <div class="topbar <?= $isClientView ? 'topbar-client' : '' ?>">
            <div>
                <h1><?= esc($pageTitle ?? '') ?></h1>
                <?php if (!empty($pageSubtitle)): ?>
                    <div class="crumb"><?= esc($pageSubtitle) ?></div>
                <?php endif; ?>
            </div>
            <div class="right">
                <a href="/" class="btn btn-ghost" style="font-size:12.5px;">Changer d'espace</a>
                <span class="pill <?= $isClientView ? 'pill-client' : '' ?>"><span class="dot"></span> <?= $isClientView ? 'Espace client actif' : 'Base connectée' ?></span>
            </div>
        </div>

        <div class="content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>
</body>
</html>
