<?php
$auth = true;
    require '_head.php';
    require '_navbar.php';
    require '_sqlfetchCategories.php';

?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
    <form action="addOffers_post.php" method="post" class="container" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name *</label>
            <input type="text" class="form-control" id="type" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category *</label>
            <select name="category" id="category" class="form-select">
                <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category['categories_id']; ?>"><?php echo $category['label']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price *</label>
            <input type="number" min="1" step="0.1" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-outline-success btn-lg">Add my offer</button>
        </div>

    </form>

</main>

<?php require '_footer.php'; ?>

<?php

/**
 * ! ETAPES LOGIQUES DE LA CREATION D'ITEMS.
 *
 * TODO : Vérifier que le formulaire est approprié (typage, présence du name...)
 * TODO : Vérifier la présence des inputs nécessaires
 * TODO : Vérifier la validité des inputs pour l'inclusion dans la BDD
 * TODO : Vérifier la base de données pour la possibilité d'inclusion (si le produit existe déja, ce ne sera pas nécessaire pour ce projet)
 * TODO : Récupérer les données après introduction (pour vérification)
 */
?>