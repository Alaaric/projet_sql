<main class="container">
    <h1>Produits</h1>

    <form method="GET" action="/products" class="filters">
        <label for="category_id">Catégorie :</label>
            <div id="list1" class="dropdown-check-list" tabindex="100">
                <span class="anchor">catégories</span>
                <ul class="items">
                    <li>
                        <input type="checkbox" id="select_all" onclick="toggleUnselectAll(this)">
                        <label for="select_all">Toutes</label>
                    </li>
                    <?php foreach ($categories as $category): ?>
                    <li><input type="checkbox" name="category_id[]" value="<?= $category->getId() ?>" <?= isset($filters['category_id']) && in_array($category->getId(), (array)$filters['category_id']) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($category->getName()) ?>
                    </input></li>
                    <?php endforeach; ?>
                </ul>
            </div>
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

<script>
    const checkList = document.getElementById('list1');
checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
  if (checkList.classList.contains('visible'))
    checkList.classList.remove('visible');
  else
    checkList.classList.add('visible');
}

function toggleUnselectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('input[name="category_id[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        selectAllCheckbox.checked = false;
    }
</script>