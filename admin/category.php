<?php include "header.php"; 
if($_SESSION['user_role'] == '0'){
    header("Location: {$hostname}/admin/post.php");
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                    <?php
                    $limit = 5;
                    if(isset($_GET['page'])){
                        $current_page = $_GET['page'];
                    }else{
                        $current_page = 1;
                    }
                    
                    $offset = ($current_page - 1)*$limit;

                    $cat_sql = "SELECT * FROM category ORDER BY category_id LIMIT {$offset},{$limit}";
                    $cat_query = mysqli_query($conn, $cat_sql) or die("Query unsuccessful");

                    if(mysqli_num_rows($cat_query) > 0):
                        while($cat_info = mysqli_fetch_assoc($cat_query)):
                    ?>
                        <tr>
                            <td class='id'><?php echo $cat_info['category_id']; ?></td>
                            <td><?php echo $cat_info['category_name']; ?></td>
                            <td><?php echo $cat_info['post']; ?></td>

                            <td class='edit'><a href='update-category.php?id=<?php echo $cat_info['category_id']; ?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $cat_info['category_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                    <?php endwhile; endif; ?>
                    </tbody>
                </table>
                <?php
                $cat_sql1 = "SELECT * FROM category";
                $cat_query1 = mysqli_query($conn, $cat_sql1) or die("Query unsuccessful");
                if(mysqli_num_rows($cat_query1)>0){
                    $total_cat = mysqli_num_rows($cat_query1);
                    $total_page = ceil($total_cat/$limit);
                }
                ?>
                <ul class='pagination admin-pagination'>
                <?php
                if($current_page>1){
                    echo "<li><a href='category.php?page=".($current_page-1)."'>Prev</a></li>";
                }
                    for($i=1; $i<=$total_page; $i++){
                        if($i == $current_page){
                            $active = "active";
                        }else{$active = "";}
                        echo "<li class='$active'><a href='category.php?page=$i'>$i</a></li>";
                    }
                if($current_page<$total_page){
                    echo "<li><a href='category.php?page=".($current_page+1)."'>Next</a></li>";
                }
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; mysqli_close($conn);?>
