<?php 
    include 'header.php';
    include 'admin/config.php';
    $current_id = $_GET['aid'];

    $post_sql2 = "SELECT * FROM post INNER JOIN user ON post.author=user.user_id WHERE post.author ={$current_id}";
    $post_query2 = mysqli_query($conn, $post_sql2) or die("Query unsuccessful");

    $user_info = mysqli_fetch_assoc($post_query2);

?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <h2 class="page-heading"><?php echo strtoupper($user_info['username']); ?></h2>
                  <?php
                  
                  $limit = 3;
                  if(isset($_GET['page'])){
                      $page = $_GET['page'];
                  }else{
                      $page = 1;
                  }
                  $offset = ($page - 1) * $limit;
              
                  $post_sql = "SELECT post.post_id,post.title,post.description,post.post_date,post.post_img,post.category,post.author,category.category_name,user.username FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id WHERE post.author = {$current_id} ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                  $post_query = mysqli_query($conn, $post_sql) or die("Query unsuccessful");
                    if(mysqli_num_rows($post_query)>0):
                        while($post_info = mysqli_fetch_assoc($post_query)):
                    ?>
                    <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $post_info['post_id']; ?>"><img src="admin/upload/<?php echo $post_info['post_img']; ?>" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $post_info['post_id']; ?>'><?php echo $post_info['title']; ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?cid=<?php echo $post_info['category']; ?>'><?php echo $post_info['category_name']; ?></a>
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
                                        <p class="description">
                                            <?php echo substr($post_info['description'], 0, 130). "..."; ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $post_info['post_id']; ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        endwhile;
                    endif;

                    
                    if(mysqli_num_rows($post_query2)>0){
                        $total_post = mysqli_num_rows($post_query2);
                        $total_page = ceil($total_post / $limit);

                        echo "<ul class='pagination'>";
                        if($page>1){
                            echo "<li><a href='author.php?aid=".$current_id."&page=".($page-1)."'>Prev</a></li>";
                        }
                        for($i=1; $i<=$total_page; $i++){
                            if($i == $page){
                                $active = "active";
                            }else{
                                $active = "";
                            }
                            echo "<li class='{$active}'><a href='author.php?aid=".$current_id."&page={$i}'>{$i}</a></li>";
                        }    
                        if($total_page > $page){
                            echo "<li><a href='author.php?aid=".$current_id."&page=".($page+1)."'>Next</a></li>";
                        }
                        echo "</ul>";
                    }
                    mysqli_close($conn);
                    ?>

                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
