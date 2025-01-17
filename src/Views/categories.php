<main class="container">

    <h1>Categories</h1>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <?= htmlspecialchars($category['nom']) ?>
                <form action="categories/delete" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $category['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Ajouter une nouvelle catégorie</h2>
    <form action="categories/add" method="POST">
        <label for="name">Nom de la catégorie :</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">Ajouter</button>
    </form>
</main>