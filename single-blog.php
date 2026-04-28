<?php
include 'config.php';

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

$blog_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

/* Redirect BEFORE any output */
if (!$blog_id) {
    header("Location: blog.php");
    exit;
}

$query = "SELECT * FROM blogs WHERE id = ? AND status = 1 LIMIT 1";
$stmt  = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $blog_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    header("Location: blog.php");
    exit;
}

$blog = mysqli_fetch_assoc($result);

/* HTML OUTPUT START */
include 'header.php';
?>


<!-- Banner -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex align-items-center justify-content-end">
            <div class="col-first">
                <h1><?= e($blog['title']); ?></h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="blog.php">Blog</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="blog_area single-post-area section_gap">
    <div class="container">
        <div class="row">

            <!-- Blog -->
            <div class="col-lg-8">
                <div class="single-post">

                    <div class="feature-img mb-4">
                        <img class="img-fluid"
                             src="admin/uploads/<?= !empty($blog['image']) ? e($blog['image']) : 'no-image.jpg'; ?>"
                             alt="<?= e($blog['title']); ?>">
                    </div>

                    <div class="blog_details">
                        <h2><?= e($blog['title']); ?></h2>

                        <ul class="blog_meta list mb-3">
                            <li><i class="lnr lnr-user"></i> <?= e($blog['author']); ?></li>
                            <li><i class="lnr lnr-calendar-full"></i>
                                <?= date("d M, Y", strtotime($blog['created_at'])); ?>
                            </li>
                            <li><i class="lnr lnr-tag"></i> <?= e($blog['category']); ?></li>
                        </ul>

                        <p><?= nl2br(e($blog['description'])); ?></p>
                    </div>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog_right_sidebar">

                    <!-- Categories -->
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Categories</h4>
                        <ul class="list cat-list">
                            <?php
                            $catQuery = mysqli_query($conn,
                                "SELECT category, COUNT(*) total 
                                 FROM blogs WHERE status=1 GROUP BY category"
                            );
                            while ($cat = mysqli_fetch_assoc($catQuery)) {
                            ?>
                            <li>
                                <a href="blog.php?search=<?= urlencode($cat['category']); ?>"
                                   class="d-flex justify-content-between">
                                    <p><?= e($cat['category']); ?></p>
                                    <p><?= $cat['total']; ?></p>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </aside>

                    <!-- Recent Posts -->
                    <aside class="single_sidebar_widget popular_post_widget">
                        <h3 class="widget_title">Recent Posts</h3>
                        <?php
                        $recentQuery = mysqli_query($conn,
                            "SELECT id, title, image, created_at 
                             FROM blogs WHERE status=1 ORDER BY id DESC LIMIT 4"
                        );
                        while ($recent = mysqli_fetch_assoc($recentQuery)) {
                        ?>
                        <div class="media post_item">
                            <img src="admin/uploads/<?= !empty($recent['image']) ? e($recent['image']) : 'no-image.jpg'; ?>"
                                 width="80">
                            <div class="media-body">
                                <a href="single-blog.php?id=<?= $recent['id']; ?>">
                                    <h3><?= e($recent['title']); ?></h3>
                                </a>
                                <p><?= date("d M, Y", strtotime($recent['created_at'])); ?></p>
                            </div>
                        </div>
                        <?php } ?>
                    </aside>

                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
