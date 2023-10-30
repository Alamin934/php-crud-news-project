<div id ="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php
                include 'admin/config.php';
                $settings_sql = "SELECT * FROM settings";
                $settings_query = mysqli_query($conn, $settings_sql) or die("Query unsuccessful");
        
                if(mysqli_num_rows($settings_query)>0){
                    while($settings_info = mysqli_fetch_assoc($settings_query)){
                        echo '<span>'.$settings_info["footer_desc"].'</span>';
                    }
                }
            ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
