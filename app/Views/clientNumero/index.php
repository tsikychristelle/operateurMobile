<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion client · OpérateurMobile</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body.auth {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(900px 500px at 90% 0%, rgba(23,178,106,0.12), transparent 55%),
                var(--navy-950);
            padding: 24px;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: var(--card);
            border-radius: 18px;
            padding: 32px 28px;
            box-shadow: var(--shadow-md);
        }
        .auth-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
        }
        .auth-brand .brand-mark { width: 38px; height: 38px; font-size: 15px; }
        .auth-brand .title { font-weight: 700; font-size: 15px; }
        .auth-card h1 { font-size: 19px; margin: 0 0 6px; }
        .auth-card .lead { font-size: 13px; color: var(--ink-400); margin: 0 0 22px; line-height: 1.5; }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--ink-400);
            margin-top: 18px;
        }
        .back-link:hover { color: var(--ink-600); }
        .btn-block { width: 100%; }
    </style>
</head>
<body class="auth">
<div class="auth-card">
    <div class="auth-brand">
        <div class="brand-mark">CL</div>
        <div class="title">Espace client</div>
    </div>

    <h1>Connexion client</h1>
    <p class="lead">Entrez vos informations pour accéder à votre compte.</p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <form action="/client-numero/login" method="post" class="form-grid">
        <div class="field">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" required autofocus>
        </div>
        <div class="field">
            <label for="numero">Numéro</label>
            <input type="text" name="numero" id="numero" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:16px;">
            Se connecter
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </button>
    </form>

    <a href="/" class="back-link">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Retour au choix de l'espace
    </a>
</div>
</body>
</html>
