<main class="container">
    <h1>Blog</h1>

    <form method="GET" action="/blog">
        <label for="tag">Filtrer par tag:</label>
        <select id="tag" name="tag">
            <option value="">Tous les tags</option>
            <?php foreach ($tags as $tag): ?>
                <option value="<?= htmlspecialchars($tag) ?>" <?= isset($filters['tag']) && $filters['tag'] === $tag ? 'selected' : '' ?>><?= htmlspecialchars($tag) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="auteur">Filtrer par auteur:</label>
        <select id="auteur" name="auteur">
            <option value="">Tous les auteurs</option>
            <?php foreach ($auteurs as $auteur): ?>
                <option value="<?= htmlspecialchars($auteur) ?>" <?= isset($filters['auteur']) && $filters['auteur'] === $auteur ? 'selected' : '' ?>><?= htmlspecialchars($auteur) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn yes">Filtrer</button>
    </form>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>

        <h2><?= isset($article) ? 'Modifier' : 'Créer' ?> un article</h2>
        <form action="<?= isset($article) ? '/blog/edit/' . $article->getId() : '/blog/create' ?>" method="POST">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" value="<?= isset($article) ? htmlspecialchars($article->getTitre()) : '' ?>" required>

            <label for="contenu">Contenu:</label>
            <textarea id="contenu" name="contenu" required><?= isset($article) ? htmlspecialchars($article->getContenu()) : '' ?></textarea>

            <label for="auteur">Auteur:</label>
            <input type="text" id="auteur" name="auteur" value="<?= isset($article) ? htmlspecialchars($article->getAuteur()) : '' ?>" required>

            <label for="tags">Tags:</label>
            <input type="text" id="tags" name="tags" value="<?= isset($article) ? htmlspecialchars(implode(', ', $article->getTags())) : '' ?>" required>

            <button type="submit" class="btn yes"><?= isset($article) ? 'Modifier' : 'Créer' ?></button>
        </form>
    <?php endif; ?>

    <h2>Articles</h2>
    <?php foreach ($articles as $article): ?>
        <article>
            <h3><?= htmlspecialchars($article->getTitre()) ?></h3>
            <p><?= htmlspecialchars($article->getContenu()) ?></p>
            <p><strong>Auteur:</strong> <?= htmlspecialchars($article->getAuteur()) ?></p>
            <p><strong>Date de création:</strong> <?= htmlspecialchars($article->getDateCreation()->format('Y-m-d H:i:s')) ?></p>
            <p><strong>Tags:</strong> <?= htmlspecialchars(implode(', ', $article->getTags())) ?></p>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                <form action="/blog/delete/<?= $article->getId() ?>" method="POST" style="display:inline;">
                    <button type="submit" class="btn no">Supprimer</button>
                </form>
                <a href="/blog/edit/<?= $article->getId() ?>">Modifier</a>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</main>