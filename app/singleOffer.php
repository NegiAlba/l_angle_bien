<?php
$auth = true;
    require '_head.php';
    require '_navbar.php';
    require '_sqlFetchSingle.php';
?>
<?php if (!empty($offer)) {?>
<div class="card m-4" style="width:30%;">
    <div class="card-body">
        <h3 class="card-title"><?php echo $offer['name']; ?></h3>
        <p>Price : <?php echo $offer['price']; ?> €</p>
        <hr>
        <p>Description : <?php echo $offer['description']; ?></p>
        <div class="d-flex justify-content-around">
            <a href="#" class="btn btn-outline-success col-5">Contact seller</a>
            <a href="#" class="btn btn-outline-warning col-5">Details</a>
        </div>
    </div>
</div>
<?php
} else {
    header('Location:offers.php?error=notFound');
}

require '_footer.php'; ?>