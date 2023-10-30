<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                    <div class="post-container">
                    <?php
                    include 'admin/config.php';

                    $current_id = $_GET['id'];

                    $post_sql = "SELECT post.post_id,post.title,post.description,post.post_date,post.post_img,post.category,post.author,category.category_name,user.username FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id WHERE post.post_id = {$current_id}";

                    $post_query = mysqli_query($conn, $post_sql) or die("Query unsuccessful");

                    if(mysqli_num_rows($post_query)>0):
                        while($post_info = mysqli_fetch_assoc($post_query)):
                    ?>
                        <div class="post-content single-post">
                            <h3><?php echo $post_info['title']; ?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <a href="category.php?cid=<?php echo $post_info['category']; ?>"><?php echo $post_info['category_name']; ?></a>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href='author.php?aid=<?php echo $post_info['author']; ?>'><?php echo $post_info['username']; ?></a>
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo $post_info['post_date']; ?>
                                </span>
                            </div>
                            <img class="single-feature-image" src="admin/upload/<?php echo $post_info['post_img']; ?>" alt=""/>
                            <p class="description">
                                <?php echo $post_info['description']; ?>
                            </p>
                        </div>
                    <?php endwhile; endif; mysqli_close($conn);?>

                    </div>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
