<?php include "header.php";
if($_SESSION['user_role'] == 0){
    $current_post_id = $_GET['id'];

    $post_sql2 = "SELECT author FROM post WHERE post_id = {$current_post_id}";
    $post_query2 = mysqli_query($conn, $post_sql2) or die("Query unsuccessful");

    $post_info2 = mysqli_fetch_assoc($post_query2);
    if($post_info2['author'] != $_SESSION['user_id']){
        header("Location: {$hostname}/admin/post.php");
    }
}

?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
    <?php
        $current_post_id = $_GET['id'];

        $post_sql = "SELECT * FROM post
        LEFT JOIN category ON post.category = category.category_id
        LEFT JOIN user ON post.author = user.user_id WHERE post_id = {$current_post_id}
        ORDER BY post.post_id DESC";
        $post_query = mysqli_query($conn, $post_sql) or die("Query unsuccessful");

        if(mysqli_num_rows($post_query)>0):
            while($post_info = mysqli_fetch_assoc($post_query)):
    ?>
        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $post_info['post_id'] ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $post_info['title'] ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5"><?php echo $post_info['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <input type="hidden" name="old_cat" value="<?php echo $post_info['category']; ?>">
                <select class="form-control" name="category">
                <?php
                $cat_sql = "SELECT * FROM category";
                $cat_query = mysqli_query($conn, $cat_sql) or die("Query unsuccessful");

                if(mysqli_num_rows($cat_query)>0){
                    while($cat_info = mysqli_fetch_assoc($cat_query)){
                        if($cat_info['category_id'] == $post_info['category']){
                            $selected = 'selected';
                        }else{$selected = '';}

                    echo "<option $selected value='{$cat_info['category_id']}'>{$cat_info['category_name']}</option>";
                    }
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="upload/<?php echo $post_info['post_img'] ?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $post_info['post_img']; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <?php endwhile; endif; ?>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; mysqli_close($conn); ?>
