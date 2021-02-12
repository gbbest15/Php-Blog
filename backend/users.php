<?php require_once('./includes/header.php'); ?>

    <body class="nav-fixed">
        <?php require_once('./includes/top-navbar.php'); ?>        

        <!--Side Nav-->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php 
                    $curr_page = basename(__FILE__);
                    require_once("./includes/left-sidebar.php");
                ?>
            </div>

            <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content d-flex align-items-center justify-content-between text-white">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="users"></i></div>
                                    <span>All Users</span>
                                </h1>
                                <a href="new-user.html" title="Add new category" class="btn btn-white">
                                    <div class="page-header-icon"><i data-feather="plus"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">All Users</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Photo</th>
                                                <th>Registered on</th>
                                                <th>Role</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php 
                                        $sql= "SELECT * FROM users";
                                        $stmt =$pdo->prepare($sql);
                                        $stmt->execute();
                                        while($user=$stmt->fetch(PDO::FETCH_ASSOC)){
                                            $user_id = $user['user_id'];
                                            $username = $user['user_name'];
                                            $user_email = $user['user_email'];
                                            $user_photo = $user['user_photo'];
                                            $reg_no = $user['registered_on'];
                                            $role = $user['user_role'];?>
                                            <tr>
                                                <td><?php echo $user_id; ?></td>
                                                <td>
                                                <?php echo $username; ?>
                                                </td>
                                                <td>
                                                    <?php echo $user_email; ?>
                                                </td>
                                                
                                                <td><img src="./assets/img/<?php echo $user_photo; ?>" height="50" width="50"></td>
                                                <td><?php echo $reg_no; ?></td>
                                                <td>
                                                    <div class="badge badge-<?php echo $role =='admin' || $role=='Admin'?'success':'warning'; ?>">
                                                        <?php echo $role; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if($user_id == $_SESSION['user_id']) { ?>
                                                            <button title="you cant edit yourself" class="btn btn-primary btn-icon"><i data-feather="edit"></i></button>
                                                        <?php }else {?>
                                                            <form action="user-update.php" method="Post">
                                                                <input type="hidden" name="editid" value="<?php echo $user_id; ?>" />
                                                                <button name="userEdit" class="btn btn-primary btn-icon"><i data-feather="edit"></i></button>
                                                            </form>
                                                       <?php }
                                                    ?>
                                                    
                                                </td>
                                                <td>
                                                <?php
                                                if (isset($_POST['delete'])){
                                                    $id = $_POST['id'];
                                                    $sql1= "DELETE FROM users WHERE user_id = :id";
                                                    $stmt = $pdo->prepare($sql1);
                                                    $stmt->execute([
                                                        ':id'=>$id
                                                    ]); 
                                                    //echo "<div class='alert alert-success'> User Delete Successfull</div>";
                                                    header("location:users.php");
                                                }
                                                ?>                                                

                                                <?php if ($role == 'admin' && $user_id == $_SESSION['user_id'] ){
                                                        echo '<button title="you can not delect your self" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>';
                                                    } else{
                                                        echo '
                                                        <form action="users.php" method= "post">  
                                                            <input type="hidden" name="id" value="' .$user_id.'" /> 
                                                            <button name="delete" type="submit" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                         </form>
                                                        ';
                                                    }?>
                                                    
                                                </td>
                                            </tr>                                                                                     
                                            <?php } ?> 
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->
                </main>

<?php require_once('./includes/footer.php'); ?>