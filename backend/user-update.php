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
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                                    <span>Updating User</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Edit User</div>
                            <div class="card-body">
                                <?php
                                if(isset($_POST['update'])){
                                    $id1 = $_POST['idupdate'];
                                    $user_name = trim($_POST['user-name']);
                                    $nick_name = trim($_POST['nick-name']);
                                    // to check if the nick name already exixt
                                    $sql2 = "SELECT * FROM users WHERE user_nickname = :nickname";
                                    $stmt2 = $pdo->prepare($sql2);
                                    $stmt2->execute([
                                        ':nickname' => $nick_name
                                    ]);
                                    $countNickname = $stmt2->rowCount();
                                    if($countNickname >= 2) {
                                        echo "<p class='alert alert-danger'>Nick name already exist!</p>";
                                    }

                                    $user_mail = trim($_POST['user-email']);
                                    // to check if email exit
                                    $sql3 = "SELECT * FROM users WHERE user_email = :email";
                                    $stmt3 = $pdo->prepare($sql3);
                                    $stmt3->execute([
                                        ':email' => $user_mail
                                    ]);
                                    $countemail = $stmt3->rowCount();
                                    if($countemail >= 2) {
                                        echo "<p class='alert alert-danger'>Email already exist!</p>";
                                    }
                                    $user_role = $_POST['user-role'];
                                    $user_photo = $_FILES['user-photo']['name'];
                                    $user_photo_tmp= $_FILES['user-photo']['tmp_name'];
                                    move_uploaded_file("{$user_photo_tmp}","./assets/img/{$user_photo}");

                                        if(empty($user_photo)){
                                        $sql4 = "SELECT * FROM users WHERE user_id = :id";
                                        $stmt4 = $pdo->prepare($sql4);
                                        $stmt4->execute([
                                            ':id' => $id1
                                        ]);
                                        $u = $stmt4->fetch(PDO::FETCH_ASSOC);
                                         $user_photo = $u['user_photo'];
                                        
                                        }
                                    $sql5 = "UPDATE users SET user_name =:username, user_nickname=:nickname, user_email=:email, user_photo=:photo, user_role=:roles WHERE user_id=:id ";
                                    $stmt5= $pdo->prepare($sql5);
                                    $stmt5->execute([
                                        ':username'=>$user_name,
                                        ':nickname'=>$nick_name,
                                        ':email'=>$user_mail,
                                        ':photo'=> $user_photo,
                                        ':roles'=> $user_role,
                                        ':id'=>$id1
                                    ]);
                                   header("Location: users.php");
                                }

                                ?>      
                                <?php
                                 if (isset($_POST['userEdit'])) {
                                    $id = $_POST['editid'];
                                    $sql = "SELECT * FROM users where user_id = :id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([
                                        ':id'=>$id
                                    ]);
                                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $user_id = $user['user_id'];
                                    $user_name = $user['user_name'];
                                    $u_nick_name = $user['user_nickname'];
                                    $user_email = $user['user_email'];
                                    $user_photo = $user['user_photo'];
                                    $user_role = $user['user_role'];
                                }

                                ?>                                  
                                <form method="POST" enctype="multipart/form-data">
                                    
                                    <input type="hidden" name="idupdate" value="<?php echo $user_id; ?>"/>
                                    
                                    <div class="form-group">
                                        <label for="user-name">User Name:</label>
                                        <input class="form-control" name="user-name" value="<?php echo $user_name; ?>" type="text" placeholder="User Name..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="user-name">Nick Name:</label>
                                        <input class="form-control" name="nick-name" value="<?php echo $u_nick_name; ?>" type="text" placeholder="User Name..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="user-email">User Email:</label>
                                        <input class="form-control" name="user-email" value="<?php echo $user_email; ?>" type="email" placeholder="User Email..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="user-role">Role:</label>
                                        <select class="form-control" name="user-role">
                                            <option value="Admin" <?php echo $user_role == "admin"? "selected":"" ?>>Admin</option>
                                            <option value="Subscriber" <?php echo $user_role == "Subscriber"? "selected":"" ?>>Subscriber</option>
                                        </select>
                                        <div class="form-group">
                                        <label for="post-title">Choose photo:</label>
                                        <input class="form-control" name="user-photo" type="file" />
                                        <img src="./assets/img/<?php echo $user_photo; ?>" alt="" height="50" width="50">
                                    </div>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-primary mr-2 my-1" type="button">Update now!</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->
                </main>

 <?php require_once('./includes/footer.php'); ?>