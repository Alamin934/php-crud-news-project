<?php include "header.php";
if($_SESSION['user_role'] == false){
    header("Location: {$hostname}/admin/post.php");
}
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading"></h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <?php
        include 'config.php';
        $settings_sql = "SELECT * FROM settings";
        $settings_query = mysqli_query($conn, $settings_sql) or die("Query unsuccessful");

        if(mysqli_num_rows($settings_query)>0):
            while($settings_info = mysqli_fetch_assoc($settings_query)):
        ?>
        <form action="save-settings.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="">Website Name</label>
                <input type="text" name="website_name"  class="form-control" id="" value="<?php echo $settings_info['website_name'] ?>">
            </div>

            <div class="form-group">
                <label for="">Upload Logo</label>
                <input type="file" name="logo">
                <img  src="images/<?php echo $settings_info['logo'] ?>" height="150px">
                <input type="hidden" name="old-logo" value="<?php echo $settings_info['logo'] ?>">
            </div>

            <div class="form-group">
                <label for="">Footer Description</label>
                <textarea rows="5" cols="" name="footer_desc" class="form-control" required><?php echo $settings_info['footer_desc'] ?></textarea>
            </div>

            <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
        </form>
        <?php
            endwhile;
        endif;
        ?>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; mysqli_close($conn);?>
