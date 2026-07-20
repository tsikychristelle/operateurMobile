<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpérateurMobile · Bienvenue</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body.landing {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(1200px 600px at 15% -10%, rgba(255,122,26,0.16), transparent 60%),
                radial-gradient(900px 500px at 100% 10%, rgba(23,178,106,0.12), transparent 55%),
                var(--navy-950);
            padding: 32px 20px;
        }
        .landing-wrap { width: 100%; max-width: 880px; }
        .landing-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
            margin-bottom: 10px;
        }
        .landing-brand .brand-mark { width: 44px; height: 44px; font-size: 17px; }
        .landing-brand .title { color: #fff; font-size: 18px; font-weight: 700; }
        .landing-sub {
            text-align: center;
            color: #9aa5c3;
            font-size: 14px;
            margin-bottom: 40px;
        }
        .choice-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }
        .choice-card {
            background: var(--card);
            border-radius: 18px;
            padding: 30px 28px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255,255,255,0.06);
            text-align: left;
            transition: transform .15s ease, box-shadow .15s ease;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .choice-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 34px rgba(16, 26, 46, 0.16);
        }
        .choice-ic {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .choice-ic.operateur { background: linear-gradient(135deg, var(--orange-500), var(--orange-600)); }
        .choice-ic.client { background: linear-gradient(135deg, #1e2c4d, #0b1220); }
        .choice-card h2 { margin: 0; font-size: 18px; font-weight: 700; }
        .choice-card p { margin: 0; font-size: 13.5px; color: var(--ink-600); line-height: 1.5; }
        .choice-card .go-btn {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--orange-600);
        }
        .choice-card.client .go-btn { color: var(--navy-700); }
        .landing-foot {
            text-align: center;
            color: #6d7896;
            font-size: 12px;
            margin-top: 30px;
        }
        @media (max-width: 640px) {
            .choice-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body class="landing">
<div class="landing-wrap">

    <div class="landing-brand">
        <div class="brand-mark">OM</div>
        <div class="title">OpérateurMobile</div>
    </div>
    <div class="landing-sub">Choisissez votre espace de connexion pour continuer</div>

    <div class="choice-grid">

        <a href="/operateur" class="choice-card operateur">
            <div class="choice-ic operateur">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </div>
            <h2>Espace opérateur</h2>
            <p>Gérez les opérateurs, les préfixes, les types d'opération et les barèmes de frais du back-office.</p>
            <span class="go-btn">
                Se connecter en tant qu'opérateur
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
            </span>
        </a>

        <a href="/client-numero" class="choice-card client">
            <div class="choice-ic client">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <h2>Espace client</h2>
            <p>Connectez-vous avec votre numéro de téléphone : consultez votre solde, faites un dépôt, un retrait ou un transfert.</p>
            <span class="go-btn">
                Se connecter avec mon numéro
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
            </span>
        </a>

    </div>

    <div class="landing-foot">OpérateurMobile &middot; Version 1 &middot; Prototype interne</div>
</div>
</body>
</html>
