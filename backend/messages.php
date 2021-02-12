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
                                    <span>Messages</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">All Comments</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Message</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Response</th>
                                                
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                        $sql = "SELECT * FROM message";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        
                                        while ($ms = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $ms_di = $ms['ms_id'];
                                            $ms_name = $ms['ms_username'];
                                            $ms_email = $ms['ms_user_email'];
                                            $ms_detail = substr($ms['ms_details'],0, 30);
                                            $ms_status = $ms['ms_status'];
                                            $ms_date = $ms['ms_date']; ?>
                                            <tr>
                                                <td><?php echo $ms_di; ?></td>
                                                <td>
                                                <?php echo $ms_name; ?>
                                                </td>
                                                <td>
                                                    <?php echo $ms_email; ?>
                                                </td>
                                                <td><?php echo $ms_details ?></td>
                                                <td><?php echo $ms_date; ?></td>
                                                <td>
                                                    <div class="badge badge-<?php echo $ms_status=='approved'?'success':'warning' ?>">
                                                        <?php echo $ms_status;  ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if($ms_status == 'pending'){ ?>
                                                        <form action="reply.php" method="POST">
                                                            <input type="hidden" name="rid" value="<?php echo $ms_di; ?>">
                                                            <button name="mail" type="submit" class="btn btn-success btn-icon"><i data-feather="mail"></i></button>
                                                        </form>
                                                  <?php } else { ?>
                                                      <button class="btn btn-success btn-icon"><i data-feather="check"></i></button>
                                                   <?php } ?>
                                                    
                                                </td>
                                                
                                                <td>
                                                    <?php
                                                    if(isset($_POST['del'])){
                                                        $del_id = $_POST['del-id'];
                                                        $sql6 = "DELETE FROM message WHERE ms_id = :id";
                                                        $stmt6 = $pdo->prepare($sql6);
                                                        $stmt->execute([
                                                            ':id'=>$del_id
                                                        ]);
                                                        header("Location: message.php");
                                                    }
                                                    ?>
                                                    <form action="" method="POST">
                                                    <input type="hidden" name="del-id" value="<?php echo $ms_di; ?>">
                                                        <button type="submit" name="del" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                    </form>
                                                </td>
                                            </tr>  
                                            <tr>
                                            
                                        <?php }

                                        ?>
                                                                 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->
                </main>

<?php require_once('./includes/footer.php'); ?>