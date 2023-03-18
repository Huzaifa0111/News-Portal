<?php
session_start();
include 'includes/config.php';
//Genrating CSRF Token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['submit'])) {
    //Verifying CSRF Token
    if (!empty($_POST['csrftoken'])) {
        if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
            $name = addslashes($_POST['name']);
            $email = addslashes($_POST['email']);
            $comment = addslashes($_POST['comment']);
            $postid = intval($_GET['nid']);
            $st1 = '0';
            $query = mysqli_query($con, "insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
            if ($query) :
                echo "<script>alert('Comment successfully submitted. Comment will be displayed after admin approval.');</script>";
                unset($_SESSION['token']);
            else :
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            endif;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>News Portal | Article</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">

</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        <!-- Navigation -->
        <?php include 'includes/header.php'; ?>

        <!-- Page Content -->
        <div class="container flex-fill">
            <div class="row mt-4">

                <!-- Blog Entries Column -->
                <div class="col-md-8">

                    <!-- Blog Post -->
                    <?php
                    $pid = intval($_GET['nid']);
                    $query = mysqli_query($con, "select tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
                    while ($row = mysqli_fetch_array($query)) {
                    ?>

                        <div class="card mb-4">

                            <div class="card-body">
                                <h2 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h2>
                                <p><b>Category : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>"><?php echo htmlentities($row['category']); ?></a>
                                    |
                                    <b>Sub Category : </b><?php echo htmlentities($row['subcategory']); ?> | <b> Posted on
                                    </b><?php echo htmlentities($row['postingdate']); ?>
                                </p>
                                <hr />

                                <img class="img-fluid rounded" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">

                                <p class="card-text"><?php
                                                        $pt = $row['postdetails'];
                                                        echo (substr($pt, 0)); ?></p>
                            </div>
                            <div class="card-footer">
                                <a href="diff-view.php?nid=<?php echo $pid ?>">Compare with original article</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Sidebar Widgets Column -->
                <?php include 'includes/sidebar.php'; ?>
            </div>
            <!-- /.row -->
            <!---Comment Section --->

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <h5 class="card-header">Leave a Comment:</h5>
                        <div class="card-body">
                            <form name="Comment" method="post">
                                <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                                <div class="form-group mb-4">
                                    <input type="text" name="name" class="form-control" placeholder="Enter your fullname" required>
                                </div>

                                <div class="form-group mb-4">
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>

                                <div class="form-group mb-4">
                                    <textarea class="form-control" name="comment" rows="3" placeholder="Comment" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            </form>
                        </div>
                    </div>

                    <!---Comment Display Section --->
                    <div class="card mb-4">
                        <h5 class="card-header">
                            Comments
                        </h5>
                        <div class="card-block">
                            <ul class="px-0 mx-3 my-0">
                                <?php
                                $sts = 1;
                                $query = mysqli_query($con, "select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
                                if (!mysqli_fetch_array($query)) { ?>
                                    <div class="card-body">No comments yet.</div>
                                    <?php } else {
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <li class="card card-body bg-light my-3">
                                            <div class="card-block">
                                                <div class="me-3 float-start">
                                                    <img src="images/usericon.svg" style="max-width: 50px" alt="user profile image">
                                                </div>
                                                <div>
                                                    <h5 class="card-title h5">
                                                        <b><?php echo htmlentities($row['name']); ?></b>
                                                    </h5>
                                                    <h6 class="text-muted time"><?php echo htmlentities($row['postingDate']); ?></h6>
                                                </div>
                                                <div class="card-text mt-3">
                                                    <?php echo htmlentities($row['comment']); ?>
                                                </div>
                                            </div>
                                        </li>
                                <?php }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include 'includes/footer.php'; ?>
    </div>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>