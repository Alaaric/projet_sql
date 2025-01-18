<main class="container">
    <h1>Blog</h1>

    <form method="GET" action="/blog">
        <label for="tags">Filtrer par tag:</label>
        <div id="filter-tag-list" class="dropdown-check-list" tabindex="100">
            <span class="anchor">Sélectionner les tags</span>
            <ul class="items">
                <li>
                    <input type="checkbox" id="select_all_filter_tags" onclick="toggleUnselectAll(this)">
                    <label for="select_all_filter_tags">Tous</label>
                </li>
                <?php foreach ($tags as $tag): ?>
                <li>
                    <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag) ?>" <?= isset($filters['tags']) && in_array($tag, (array)$filters['tags']) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($tag) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

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
            <div id="tag-list" class="dropdown-check-list" tabindex="100">
                <span class="anchor">Sélectionner les tags</span>
                <ul class="items">
                    <li>
                        <input type="checkbox" id="select_all_tags" onclick="toggleUnselectAll(this)">
                        <label for="select_all_tags">Tous</label>
                    </li>
                    <?php foreach ($tags as $tag): ?>
                    <li>
                        <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag) ?>" <?= isset($article) && in_array($tag, $article->getTags()) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($tag) ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

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

<script>
    const checkList = document.getElementById('tag-list');
    checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
        if (checkList.classList.contains('visible'))
            checkList.classList.remove('visible');
        else
            checkList.classList.add('visible');
    }

    function toggleUnselectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('input[name="tags[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        selectAllCheckbox.checked = false;
    }

    const filterTagList = document.getElementById('filter-tag-list');
    filterTagList.getElementsByClassName('anchor')[0].onclick = function(evt) {
        if (filterTagList.classList.contains('visible'))
            filterTagList.classList.remove('visible');
        else
            filterTagList.classList.add('visible');
    }

    function toggleUnselectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('input[name="tags[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        selectAllCheckbox.checked = false;
    }
</script>