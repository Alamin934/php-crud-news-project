<?php include "header.php"; include 'config.php';
if($_SESSION['user_role'] == '0'){
    header("Location: {$hostname}/admin/post.php");
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                        $limit = 3;
                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                        }else{
                            $page = 1;
                        }
                        $offset = ($page-1)*$limit;

                        $user_sql = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset},{$limit}";
                        $user_query = mysqli_query($conn, $user_sql) or die("Query unsuccessful");

                        if(mysqli_num_rows($user_query)>0):
                            while($user = mysqli_fetch_assoc($user_query)):
                        
                        if($user['role'] == 1){
                            $user_role = 'admin';
                        }else{$user_role = 'normal user';}
                        ?>
                          <tr>
                              <td class='id'><?php echo $user['user_id']; ?></td>

                              <td><?php echo $user['first_name'].' '.$user['last_name']; ?></td>

                              <td><?php echo $user['username']; ?></td>

                              <td><?php echo $user_role; ?></td>

                              <td class='edit'><a href='update-user.php?id=<?php echo $user["user_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                              
                              <td class='delete'><a href='delete-user.php?id=<?php echo $user["user_id"]; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                        <?php
                            endwhile;
                        endif;
                        ?>
                      </tbody>
                  </table>
                  <?php
                  $users_sql = "SELECT * FROM user";
                  $users_query = mysqli_query($conn, $users_sql) or die("Query unsuccessful");

                  if(mysqli_num_rows($users_query)>0):
                    $total_user = mysqli_num_rows($users_query);

                    $total_page = ceil($total_user/$limit);
                  ?>
                  <ul class='pagination admin-pagination'>
                    <?php
                    if($page>1){
                        echo "<li><a href='users.php?page=".($page-1)."'>Prev</a></li>";
                    }
                    
                        for($i=1; $i<=$total_page; $i++){
                            if($page==$i){
                                $active = "active";
                            }else{$active="";}
                            echo '<li class="'.$active.'"><a href="users.php?page='.$i.'">'.$i.'</a></li>';
                        }
                        if($total_page>$page){
                            echo "<li><a href='users.php?page=".($page+1)."'>Next</a></li>";
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
