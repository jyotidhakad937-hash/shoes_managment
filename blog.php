
<?php include 'header.php';?>
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Blog Page</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.php">Blog</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
   
    <?php
include 'config.php'; 

$query = mysqli_query($conn, "SELECT * FROM blogs LIMIT 3");
?>


<section class="blog_categorie_area">
    <div class="container">
        <div class="row">

            <?php while ($row = mysqli_fetch_assoc($query)) { ?>

                <div class="col-lg-4">
                    <div class="categories_post">

                        <?php
                 
                 $image = !empty($row['image']) ? $row['image'] : 'default.jpg';
                        ?> 

                        <img src="admin/uploads/<?php echo htmlspecialchars($image); ?>" alt="post">
                        

                        <div class="categories_details">
                            <div class="categories_text">
                                <a href="blog-details.php?cat_id=<?php echo (int)$row['id']; ?>">
                                    <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                                </a>
                                <div class="border_line"></div>
                                <p><?php echo htmlspecialchars($row['description']); ?></p>
                            </div>
                        </div>

                    </div>
                </div>

            <?php } ?>

        </div>
    </div>
</section>

<section class="blog_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog_left_sidebar">
                        

<?php
$q = mysqli_query($conn, "SELECT * FROM blogs LIMIT 5");
while($row = mysqli_fetch_assoc($q)){
?>

<article class="row blog_item">

<div class="col-md-3">
    <div class="blog_info text-right">
        <div class="post_tag">
            <a class="active"><?php echo $row['category']; ?></a>
        </div>

        <ul class="blog_meta list">
            <li><?php echo $row['author']; ?> <i class="lnr lnr-user"></i></li>
            <li><?php echo date('d M, Y', strtotime($row['created_at'])); ?> <i class="lnr lnr-calendar-full"></i></li>
            <li><?php echo $row['views'] ?? 0; ?> Views <i class="lnr lnr-eye"></i></li>

            <li><?php echo $row['comments'] ?? 0; ?> comments <i class="lnr lnr-bubble"></i></li>

        </ul>
    </div>
</div>

<div class="col-md-9">
    <div class="blog_post">
        <img src="admin/uploads/<?php echo $row['image'] ?: 'default.jpg'; ?>">
        <h2><?php echo $row['title']; ?></h2>
        <p><?php echo substr($row['description'],0,120); ?>...</p>
        <a href="single-blog.php?id=<?php echo $row['id']; ?>">View More</a>
    </div>
</div>

</article>

<?php } ?>


                        <div class="pagination">
                    <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget search_widget">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Posts" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Posts'">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="lnr lnr-magnifier"></i></button>
                                </span>
                            </div>
                            <div class="br"></div>

<?php
$q = mysqli_query($conn, "SELECT * FROM blogs LIMIT 1");
while($row = mysqli_fetch_assoc($q)){
?>

<aside class="row blog_item">

<div class="col-md-3">
    <div class="blog_info text-right">
        <div class="post_tag">
           
        </div>

       
    </div>
</div>

<div class="col-md-9">
    <div class="blog_post">
       <img class="author_img rounded-circle" src="admin/uploads/<?php echo $row['image'] ?: 'default.jpg'; ?>"
     class="round-img">

        <h2><?php echo $row['title']; ?></h2>
        <p><?php echo substr($row['description'],0,120); ?>...</p>
        <a href="single-blog.php?id=<?php echo $row['id']; ?>">View More</a>
    </div>
</div>

</aside>

<?php } ?>


        <h3 class="widget_title">Popular Posts</h3>         
<?php
$q = mysqli_query($conn, "SELECT * FROM blogs LIMIT 4");
while($row = mysqli_fetch_assoc($q)){
?>

<aside>



<div class="media mb-3">

    <img src="admin/uploads/<?php echo $row['image'] ?: 'default.jpg'; ?>"
         style="width:70px;height:70px;object-fit:cover;" class="mr-2">

    <div class="media-body">
        <p class="mb-1">
            <?php echo htmlspecialchars($row['title']); ?>
        </p>
    </div>

</div>

<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

   


<?php include 'footer.php';?>