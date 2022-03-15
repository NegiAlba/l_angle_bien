<navbar>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container-fluid ">

            <a class="navbar-brand" href="index.php">LAB</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="offers.php">See offers</a>
                    </li>
                    <?php if ($_SESSION['user']) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="addOffers.php">Add offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-secondary" href="?logout">Log out</a>
                    </li>
                    <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="signIn.php">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signUp.php">Sign up</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</navbar>