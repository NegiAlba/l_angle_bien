<?php
    require '_head.php';
    require '_navbar.php';

    // ? Initialisation d'une variable alerte, elle permettra de définir l'affichage ou non d'un bloc d'alerte qui servira pour l'UX.
    $alert = false;

    // ? L'affichage des alertes dépend d'une requête GET que le back revoit, pour renseigner sur le type d'erreur rencontré et sa gravité.
    if (!empty($_GET)) {
        $alert = true;
        if ('missingInput' == $_GET['error']) {
            $type = 'warning';
            $message = 'Missing  input : You need to fill every field in the form';
        }
    }

?>
<div class="w-50 mx-auto mt-4">
    <!-- //? Affichage de l'alerte qui permet de renseigner l'utilisateur sur sa progression dans l'utilisation du site.
    //? Cet affichage est conditionné par 3 variables , alert, type et message que l'on a initialisé plus tôt. -->
    <?php if ($alert) { ?>
    <div class="alert alert-<?php echo $type; ?>" role="alert">
        <?php echo $message; ?>
    </div>
    <?php } ?>

    <div class="card-body">
        <form action="signIn_post.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">E-mail address or username</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="username"
                    aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Sign-in</button>
        </form>
    </div>
</div>

<?php require '_footer.php'; ?>