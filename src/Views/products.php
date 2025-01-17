<main class="container">
    <h1>Produits</h1>

    <form method="GET" action="/products" class="filters">
        <label for="category_id">Catégorie :</label>
        <select name="category_id" id="category_id" class="fields">
            <option value="">Toutes</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= isset($filters['category_id']) && $filters['category_id'] == $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="min_price">Prix min :</label>
        <input type="number" name="min_price" id="min_price" value="<?= htmlspecialchars($filters['min_price'] ?? '') ?>" step="42" class="fields">

        <label for="max_price">Prix max :</label>
        <input type="number" name="max_price" id="max_price" value="<?= htmlspecialchars($filters['max_price'] ?? '') ?>" step="42" class="fields">

        <button type="submit">Filtrer</button>
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
                    <td><img src="/assets/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['image']) ?>" width="80"></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?> €</td>
                    <td><?= htmlspecialchars($product['stock']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>