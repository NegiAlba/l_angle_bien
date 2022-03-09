<?php
    require '_head.php';
    require '_navbar.php';

?>
<div class="container mt-4 text-center bg-secondary p-2 " style="--bs-bg-opacity: .25">
    <div class="w-50 mx-auto mt-4">
        <!-- //? De quoi est constitué un formulaire ?
        //? 1.Une balise form, où il faut préciser action et method
        //? - action correspond à la page qui va gérer le processing du formulaire
        //? ATTENTION : Par défaut la page action est la page sur laquelle on se situe. //? Il y aura donc un rechargement de la page (avec l'envoi des infos)
        //? - method concerne la méthode à utiliser pour envoyer les données (méthodes HTTP)
        //? ATTENTION : Par défaut la méthode utilisée est la méthode GET
        //? 2. De champs avec des name, c'est IMPERATIF sinon vous ne pourrez pas récupérer les données
     -->
        <form action="signUp_post.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password2" name="password2">
            </div>
            <button type="submit" class="btn btn-primary">Sign up</button>
        </form>
    </div>
</div>

<?php require '_footer.php'; ?>