<header>
    <nav class="navbar">
        <a href="/" class="logo">NFCHAT</a>
        <a href="/">Accueil</a>
        <a href="/products">Produits</a>
        <a href="/article">Articles</a>

        <?php if (isset($_SESSION['user'])): ?>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="/backoffice">Backoffice</a>
            <?php endif; ?>
            <a href="/logout">Déconnexion</a>
        <?php else: ?>
            <a href="/auth/login">Connexion</a>
            <a href="/auth/register">Inscription</a>
        <?php endif; ?>
    </nav>
</header>