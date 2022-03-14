<?php
    $auth = true;
    require '_head.php';
    require '_navbar.php';
    require '_sqlFetchOffers.php';
?>
<?php if (!empty($offers)) {
    foreach ($offers as $offer) { ?>
<div class="card m-4" style="width:20%;">
    <div class="card-body">
        <h3 class="card-title"><?php echo $offer['name']; ?></h3>
        <p>Price : <?php echo $offer['price']; ?> €</p>
        <hr>
        <div class="d-flex justify-content-around">
            <a href="#" class="btn btn-outline-success col-5">Contact seller</a>
            <a href="singleOffer.php?id=<?php echo $offer['offers_id']; ?>"
                class="btn btn-outline-warning col-5">Details</a>
        </div>
    </div>
</div>
<?php }
} else { ?>
<div class="container mt-4 text-center bg-secondary p-2 " style="--bs-bg-opacity: .25">
    <h3>No offers available right now, come back soon !</h3>
</div>
<?php } ?>


<?php require '_footer.php'; ?>