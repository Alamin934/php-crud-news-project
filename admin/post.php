<?php include "header.php";

    $limit = 7;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }
    $offset = ($page-1)*$limit;
    if($_SESSION['user_role'] == '1'){
        $post_sql = "SELECT * FROM post
        LEFT JOIN category ON post.category = category.category_id
        LEFT JOIN user ON post.author = user.user_id
        ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
    }elseif($_SESSION['user_role'] == '0'){
        $post_sql = "SELECT * FROM post
        LEFT JOIN category ON post.category = category.category_id
        LEFT JOIN user ON post.author = user.user_id
        WHERE post.author = {$_SESSION['user_id']}
        ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
    }
    
    $post_query = mysqli_query($conn, $post_sql) or die("Query unsuccessful");
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php 
                        $sl_no = $offset + 1;
                            if(mysqli_num_rows($post_query)>0):
                                while($post = mysqli_fetch_assoc($post_query)):
                        ?>
                          <tr>
                              <td class='id'><?php echo $sl_no; ?></td>
                              <td><?php echo $post['title']; ?></td>
                              <td><?php echo $post['category_name']; ?></td>
                              <td><?php echo $post['post_date']; ?></td>
                              <td><?php echo $post['username']; ?></td>

                              <td class='edit'><a href='update-post.php?id=<?php echo $post['post_id']; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?post_id=<?php echo $post['post_id']; ?>&cat_id=<?php echo $post['category']; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php $sl_no++; endwhile; endif; ?>
                      </tbody>
                  </table>
                  <?php
                  $posts_sql = "SELECT * FROM post";
                  $posts_query = mysqli_query($conn, $posts_sql) or die("Query unsuccessful");

                  if(mysqli_num_rows($posts_query)>0):
                    $total_user = mysqli_num_rows($posts_query);

                    $total_page = ceil($total_user/$limit);
                  ?>
                  <ul class='pagination admin-pagination'>
                    <?php
                    if($page>1){
                        echo "<li><a href='post.php?page=".($page-1)."'>Prev</a></li>";
                    }
                    
                        for($i=1; $i<=$total_page; $i++){
                            if($page==$i){
                                $active = "active";
                            }else{$active="";}
                            echo '<li class="'.$active.'"><a href="post.php?page='.$i.'">'.$i.'</a></li>';
                        }
                        if($total_page>$page){
                            echo "<li><a href='post.php?page=".($page+1)."'>Next</a></li>";
                        }
                    ?>
                  </ul>
                <?php
                    endif;
                ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; mysqli_close($conn); ?>
