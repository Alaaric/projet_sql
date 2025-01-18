<main class="container">
    <h1>Produits</h1>

    <form method="GET" action="/products" class="filters">
        <label for="category_id">Catégorie :</label>
        <select name="category_id" id="category_id" class="fields">
            <option value="">Toutes</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->getId() ?>" <?= isset($filters['category_id']) && $filters['category_id'] == $category->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->getName()) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="min_price">Prix min :</label>
        <input type="number" name="min_price" id="min_price" value="<?= htmlspecialchars($filters['min_price'] ?? '') ?>" step="42" class="fields">

        <label for="max_price">Prix max :</label>
        <input type="number" name="max_price" id="max_price" value="<?= htmlspecialchars($filters['max_price'] ?? '') ?>" step="42" class="fields">

        <button type="submit" class="btn yes">Filtrer</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>aperçu</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><img src="/assets/<?= htmlspecialchars($product->getImage()) ?>" alt="<?= htmlspecialchars($product->getImage()) ?>" width="80"></td>
                    <td><?= htmlspecialchars($product->getName()) ?></td>
                    <td><?= htmlspecialchars($product->getDescription()) ?></td>
                    <td><?= htmlspecialchars($product->getPrice()) ?> €</td>
                    <td><?= htmlspecialchars($product->getStock()) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>