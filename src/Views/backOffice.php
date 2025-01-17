<main class="container">

    <h1>Back Office - Dashboard</h1>
<br>
    <!-- Categories -->
    <h2>Catégories</h2>
    <article class="categories">
        <table>
            <thead>
                <tr>
                    <th>Nombre de produits par catégorie</th>
                    <th>Nom de la catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                    <?php 
                        $found = false;
                        foreach ($productsCountByCategory as $categoryProductCount): 
                            if ($categoryProductCount['category_id'] === $category['id']) : 
                                $found = true;
                        ?>
                                <td><?= $categoryProductCount['product_count'] ?></td>
                        <?php 
                                break;
                            endif; 
                        endforeach; 

                        if (!$found):
                        ?>
                            <td>0</td>
                    <?php endif; ?>
                        <td>

                            <form action="/backoffice/categories/edit" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="entity" value="category">
                                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                <input type="text" name="name" value="<?= $category['name'] ?>">
                        </td>
                        <td sl>
                                <button type="submit" class="form-button">Éditer</button>
                            </form>
                        
                            <form action="/backoffice/categories/delete" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="entity" value="category">
                                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                <button type="submit" class="form-button">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Ajouter une catégorie</h3>
        <form action="/backoffice/categories/add" method="POST" class="add-category">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="entity" value="category">
            <input type="text" name="name" placeholder="nom de catégorie" required>
            <button type="submit">Ajouter</button>
        </form>
    </article>
    <br>

    <!-- Products -->
    <h2>Produits</h2>
    <article class="products">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Categorie</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <form action="/backoffice/products/edit" method="POST" enctype="multipart/form-data" style="display:inline;" class="edit-product">
                            <td>
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="entity" value="product">
                                <input type="hidden" name="id" value="<?= $product['product_id'] ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($product['product_name']) ?>" required class="form-input">
                        </td>
                        <td>
                             <textarea name="description" required class="form-textarea"><?= htmlspecialchars($product['description']) ?></textarea>
                        </td>
                        <td>
                            <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" required class="form-input number-input">
                        </td>
                        <td>
                            <input type="number" name="stock" value="<?= htmlspecialchars($product['stock']) ?>" required class="form-input number-input">
                        </td>
                        <td>
                            <select name="categoryId" required class="form-input" class="form-file-input">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <label for="file-upload" class="custom-file-upload">
                                choisir une image
                            </label>
                            <input type="file" id="file-upload" name="image" class="file-upload">
                            <input type="hidden" name="current_image" value="<?= htmlspecialchars($product['image']) ?>">
                            <img src="/assets/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['image']) ?>" width="80">
                        </td>
                        <td class="product-actions">
                            <button type="submit" class="form-button">Éditer</button>
                            </form>
                            <form action="/backoffice/products/delete" method="POST">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="entity" value="product">
                                <input type="hidden" name="id" value="<?= $product['product_id'] ?>">
                                <button type="submit" class="form-button">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Ajouter un Produit</h3>
        <form action="/backoffice/products/add" method="post" enctype="multipart/form-data" class="add-product">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="entity" value="product">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Prix :</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="stock">Stock :</label>
            <input type="number" id="stock" name="stock" required>

            <label for="category_id">Catégorie :</label>
            <select id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="image">Image :</label>
            <input type="file" id="image" name="image">

            <button type="submit">Ajouter</button>
        </form>
    </article>
<br>

    <!-- Users -->
    <h2>Utilisateurs</h2>
    <article class="users">
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <form action="/backoffice/users/edit" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="entity" value="user">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <select name="role" id="">
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : "" ?>>admin</option>
                                    <option value="client" <?= $user['role'] === 'client' ? 'selected' : "" ?>>client</option>
                                </select>
                        </td>
                        <td>
                                <button type="submit"  class="form-button">Edit</button>
                            </form>

                            <form action="/backoffice/users/delete" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="entity" value="user">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit"  class="form-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </article>
</main>