<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SysInfo - Connexion</title>
    <style>
        :root {
            --bg-1: #0f1a31;
            --bg-2: #173458;
            --card: #ffffff;
            --text: #1f2a44;
            --muted: #6f7f97;
            --line: #d9e1ee;
            --primary: #2f68f6;
            --primary-dark: #2453c8;
            --soft: #f7f9fd;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            min-height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 20% 20%, rgba(71, 118, 255, 0.18), transparent 28%),
                radial-gradient(circle at 80% 75%, rgba(71, 118, 255, 0.14), transparent 25%),
                linear-gradient(180deg, var(--bg-2), var(--bg-1));
            display: grid;
            place-items: center;
            padding: 32px 16px;
        }

        .login-shell {
            width: min(100%, 440px);
        }

        .login-card {
            background: var(--card);
            border-radius: 18px;
            box-shadow: 0 28px 70px rgba(0, 0, 0, 0.22);
            padding: 34px 36px 30px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 34px;
        }

        .brand-mark {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(180deg, #3c8bff, #1f6ef6);
            display: grid;
            place-items: center;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
        }

        .brand-mark svg {
            width: 22px;
            height: 22px;
            fill: #ffffff;
        }

        .brand-title {
            margin: 0;
            font-size: 1.2rem;
            line-height: 1.1;
            font-weight: 700;
        }

        .brand-subtitle {
            margin: 2px 0 0;
            font-size: 0.82rem;
            color: var(--muted);
        }

        h1 {
            margin: 0 0 10px;
            font-size: 2rem;
            line-height: 1.1;
        }

        .lead {
            margin: 0 0 28px;
            color: var(--muted);
            font-size: 0.98rem;
        }

        .alert {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #fff1f1;
            color: #b42318;
            border: 1px solid #ffd4d4;
            font-size: 0.92rem;
        }

        .field {
            margin-bottom: 18px;
        }

        .field-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #9aa8bb;
        }

        .input-field {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--soft);
            padding: 14px 16px 14px 46px;
            font-size: 1rem;
            outline: none;
            color: var(--text);
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        .input-field:focus {
            border-color: rgba(47, 104, 246, 0.65);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(47, 104, 246, 0.12);
        }

        .row-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 10px 0 22px;
            flex-wrap: wrap;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text);
            font-size: 0.95rem;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
        }

        .forgot {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            border: 0;
            border-radius: 12px;
            background: linear-gradient(180deg, #3c76ff, var(--primary));
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            padding: 15px 18px;
            cursor: pointer;
            box-shadow: 0 14px 24px rgba(47, 104, 246, 0.25);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 28px rgba(47, 104, 246, 0.28);
        }

        .footer-note {
            margin: 24px 0 0;
            text-align: center;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .footer-note a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .footer-note a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            body {
                padding: 18px 12px;
            }

            .login-card {
                padding: 28px 20px 24px;
                border-radius: 16px;
            }

            h1 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <?php $firstUser = $firstUser ?? null; ?>

    <main class="login-shell">
        <section class="login-card" aria-label="Connexion SysInfo">
            <div class="brand">
                <div class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" role="img" focusable="false">
                        <path d="M12 3 3 8l9 5 9-5-9-5Zm0 8L3 6v4l9 5 9-5V6l-9 5Zm0 5L3 11v4l9 5 9-5v-4l-9 5Z"/>
                    </svg>
                </div>
                <div>
                    <p class="brand-title">SysInfo</p>
                    <p class="brand-subtitle">Système d'information</p>
                </div>
            </div>

            <h1>Connexion</h1>
            <p class="lead">Connectez-vous à votre espace de travail</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="/login" method="post">
                <div class="field">
                    <label class="field-label" for="email">Adresse e-mail</label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 4.2-8 5.33-8-5.33V6l8 5.33L20 6v2.2Z"/>
                        </svg>
                        <input class="input-field" type="email" name="email" id="email" value="<?= esc($firstUser['email'] ?? 'admin@example.com') ?>" required>
                    </div>
                </div>

                <div class="field">
                    <label class="field-label" for="password">Mot de passe</label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M17 9h-1V7a4 4 0 0 0-8 0v2H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2Zm-6 8.7V16a1 1 0 1 1 2 0v1.7a2 2 0 1 1-2 0ZM10 9V7a2 2 0 1 1 4 0v2h-4Z"/>
                        </svg>
                        <input class="input-field" type="password" name="password" id="password" value="admin123" required>
                    </div>
                </div>

                <div class="row-actions">
                    <label class="remember" for="remember">
                        <input type="checkbox" name="remember" id="remember" checked>
                        <span>Se souvenir de moi</span>
                    </label>

                    <a class="forgot" href="#">Mot de passe oublié ?</a>
                </div>

                <button class="submit-btn" type="submit">Se connecter</button>
            </form>

            <p class="footer-note">Pas encore de compte ? <a href="#">Contactez votre administrateur</a></p>
        </section>
    </main>
</body>
</html>