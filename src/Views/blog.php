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

        <button type="submit">Filtrer</button>
    </form>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>

        <h2><?= isset($article) ? 'Modifier' : 'Créer' ?> un article</h2>
        <form action="<?= isset($article) ? '/blog/edit/' . $article['_id'] : '/blog/create' ?>" method="POST">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" value="<?= isset($article) ? htmlspecialchars($article['titre']) : '' ?>" required>

            <label for="contenu">Contenu:</label>
            <textarea id="contenu" name="contenu" required><?= isset($article) ? htmlspecialchars($article['contenu']) : '' ?></textarea>

            <label for="auteur">Auteur:</label>
            <input type="text" id="auteur" name="auteur" value="<?= isset($article) ? htmlspecialchars($article['auteur']) : '' ?>" required>

            <label for="tags">Tags (séparés par des virgules):</label>
            <input type="text" id="tags" name="tags" value="<?= isset($article) ? implode(', ', (array)$article['tags']) : '' ?>" required>

            <button type="submit"><?= isset($article) ? 'Modifier' : 'Créer' ?></button>
        </form>
    <?php endif; ?>


    <h2>Articles</h2>
    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <h2><?= htmlspecialchars($article['titre']) ?></h2>
                <p><?= htmlspecialchars($article['contenu']) ?></p>
                <p><strong>Auteur:</strong> <?= htmlspecialchars($article['auteur']) ?></p>
                <p><strong>Date de création:</strong> <?= htmlspecialchars($article['date_creation']->toDateTime()->format('Y-m-d H:i:s')) ?></p>
                <p><strong>Tags:</strong> <?= implode(', ', (array)$article['tags']) ?></p>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/blog/edit/<?= $article['_id'] ?>">Modifier</a>
                    <form action="/blog/delete/<?= $article['_id'] ?>" method="POST" style="display:inline;">
                        <button type="submit">Supprimer</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
