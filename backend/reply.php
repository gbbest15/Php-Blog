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
                                    <div class="page-header-icon"><i data-feather="mail"></i></div>
                                    <span>Reply</span>
                                </h1>
                            </div>
                        </div>
                    </div>


                    <?php
                    if(isset($_POST['mail'])){
                    $id = $_POST['rid'];
                     $sql = "SELECT * FROM message WHERE ms_id = :id";
                     $stmt= $pdo->prepare($sql);
                     $stmt->execute([
                         ':id'=>$id
                     ]);
                     $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
                     $id= $fetch['ms_id'];
                     $name = $fetch['ms_username'];
                     $msg = $fetch['ms_details'];
                    }else{
                        header("Location: messages.php");
                    }
                    ?>
                    <!--Start Form-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Reponse Area:</div>
                            <div class="card-body">
                                <?php 
                                if(isset($_POST['respond'])){
                                    $r_id = $_POST['r-id'];
                                    $reply_text = $_POST['reply'];
                                    $sql1 = "UPDATE message SET reply =:reply, ms_state =:state, ms_status =:status WHERE ms_id = :id";
                                    $stmt1= $pdo->prepare($sql1);
                                    $stmt1->execute([
                                        ':id'=>$r_id,
                                        ':status'=>'approved',
                                        ':state'=>1,
                                        ':reply'=>$reply_text
                                    ]);
                                    header("Location: messages.php");
                                }
                                ?>
                                <form method="POST">
                                    <div class="form-group">
                                        <input type="hidden" value="<?php echo $id; ?>" name="r-id">
                                        <label for="post-content">Message:</label>
                                        <textarea class="form-control" placeholder="Type here..." id="post-content"  rows="9" readonly="true"><?php echo $msg; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="user-name">User name:</label>
                                        <input class="form-control" id="user-name" type="text" placeholder="User name ..." readonly="true" value="<?php echo $name; ?>" />
                                    </div>                               

                                    <div class="form-group">
                                        <label for="post-tags">Reply:</label>
                                        <textarea name="reply" class="form-control" placeholder="Type your reply here..." id="post-tags" rows="9"></textarea>
                                    </div>

                                    <button name="respond" type="submit" class="btn btn-primary mr-2 my-1" type="button">Send my respose</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Form-->

                </main>

<?php require_once('./includes/footer.php'); ?>