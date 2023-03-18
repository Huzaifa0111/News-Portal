<?php
session_start();
include('includes/config.php');
require_once("vendor/autoload.php");

use Caxy\HtmlDiff\HtmlDiff;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>News Portal | Diff view</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="css/diff.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        <!-- Navigation -->
        <?php include('includes/header.php'); ?>
        <!-- Page Content -->
        <div class="container flex-fill">
            <div class="row mt-4">

                <!-- Blog Entries Column -->
                <div class="col-md-8">

                    <!-- Blog Post -->
                    <?php
                    $pid = intval($_GET['nid']);
                    $query = mysqli_query($con, "select tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.OrigPostDetails as origpostdetails, tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
                    while ($row = mysqli_fetch_array($query)) {
                    ?>

                        <div class="card mb-4">

                            <div class="card-body">
                                <h2 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h2>
                                <p><b>Category : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>"><?php echo htmlentities($row['category']); ?></a>
                                    |
                                    <b>Sub Category : </b><?php echo htmlentities($row['subcategory']); ?> <b> Posted on
                                    </b><?php echo htmlentities($row['postingdate']); ?>
                                </p>
                                <hr />

                                <img class="img-fluid rounded" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
                                <p>
                                    <?php
                                    $htmlDiff = new HtmlDiff($row['origpostdetails'], $row['postdetails']);
                                    $content = $htmlDiff->build();
                                    echo $content; ?>
                                </p>

                            </div>

                            <div class="card-footer text-muted">
                                <a href="news-details.php?nid=<?php echo $pid ?>">View current article</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Sidebar Widgets Column -->
                <?php include 'includes/sidebar.php'; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>