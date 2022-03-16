<?php
    $auth = true;
    require '_head.php';
    require '_navbar.php';
    require '_sqlFetchSingle.php';

    echo '<pre>';
    print_r($offer);
    echo '</pre>';
?>
<?php if (!empty($offer)) {?>
<div class="card m-4" style="width:30%;">
    <img src="<?php echo $offer['image']; ?>" alt="<?php echo $offer['description']; ?>" class="img-fluid">
    <div class="card-body">
        <h3 class="card-title"><?php echo $offer['name']; ?></h3>
        <p>Price : <?php echo $offer['price']; ?> €</p>
        <hr>
        <p>Description : <?php echo $offer['description']; ?></p>
        <div class="d-flex justify-content-around">
            <?php if ($user === $offer['author_id']) { ?>
            <form action="deleteOffer_post.php" method="post">
                <input type="hidden" name="offers_id" value="<?php echo $offer['offers_id']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <input type="submit" class="form-control btn btn-outline-danger col-4" value="Delete offer" />
            </form>
            <?php } ?>
            <a href="#" class="btn btn-outline-warning col-4">Details</a>
        </div>
    </div>
</div>
<?php
} else {
    header('Location:offers.php?error=notFound');
}

require '_footer.php'; ?>