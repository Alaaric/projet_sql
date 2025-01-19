<main class="container">

    <div class="login-form-container">
        <h2>Inscription</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form action="/auth/register/submit" method="POST">
            <input type="text" name="name" placeholder="Nom" required>
            <input type="text" name="firstname" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
            <button type="submit" class="btn yes">S'inscrire</button>
        </form>
        <p>
            Déjà un compte ? <a href="/auth/login">Se connecter</a>
        </p>
    </div>

</main>