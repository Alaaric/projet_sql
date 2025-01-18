<main class="container">

    <div class="login-form-container">
        <h2>Connexion</h2>
        <form action="/auth/login/submit" method="POST">
            <input type="email" name="email" placeholder="Email" value="<?= isset($data['email']) ? htmlspecialchars($data['email']) : '' ?>" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" class="btn yes">Se connecter</button>
        </form>
        <p>
            Pas de compte ? <a href="/auth/register">Inscrit toi!</a>
        </p>
    </div>

</main>