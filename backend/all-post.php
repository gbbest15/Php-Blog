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
                                    <div class="page-header-icon"><i data-feather="layout"></i></div>
                                    <span>All Posts</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">All Posts</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Category</th>
                                                <th>Author</th>
                                                <th>Image</th>
                                                <th>Date</th>
                                                
                                                <th>Tags</th>
                                                
                                                <th>Views</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Category</th>
                                                <th>Author</th>
                                                <th>Image</th>
                                                <th>Date</th>               
                                                <th>Tags</th>
                                                <th>Views</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                        <?php 
                                                $sql = "SELECT * FROM posts ";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute();
                                                while($posts = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    // post_id, post_title, post_views, post_image, post_date, post_author, post_category_id, category_name
                                                    $post_id = $posts['post_id'];
                                                    $post_title = $posts['post_title'];
                                                    $post_views = $posts['post_view'];
                                                    $post_image = $posts['post_image'];
                                                    $post_date = $posts['post_date'];
                                                    $post_author = $posts['post_author'];
                                                    $post_status = $posts['post_status'];
                                                    $post_tags  = $posts['post_tag'];
                                                    $post_category_id = $posts['post_cat_id'];
                                                    $sql1 = "SELECT * FROM categories WHERE category_id = :id";
                                                    $stmt1 = $pdo->prepare($sql1);
                                                    $stmt1->execute([':id'=>$post_category_id]);
                                                    $category = $stmt1->fetch(PDO::FETCH_ASSOC);
                                                    $category_title = $category['category_name']; ?>
                                            <tr>
                                                <td><?php echo $post_id;  ?></td>
                                                <td>
                                                    <?php if($post_status == 'Published'){
                                                        echo "<a href='#'> $post_title </a>";
                                                    }else{
                                                         echo $post_post;    
                                                    } 
                                                    ?>
                                                    
                                                </td>
                                                <td>
                                                    <div class="badge badge-<?php echo $post_status== 'Published'?'success':'warning' ?>"><?php echo $post_status;  ?>
                                                    </div>
                                                </td>
                                                <td><?php echo $category_title;  ?></td>
                                                <td><?php echo $post_author;  ?></td>
                                                <td><img src="../img/<?php echo $post_image;  ?>" height="50" width="50" alt=""></td>
                                                <td><?php echo $post_date;  ?></td>
                                                
                                                <td><?php echo $post_tags;  ?></td>
                                                
                                                <td><?php echo $post_views;  ?></td>
                                                <td>
                                                    <form action="" method="POST">
                                                    <button type="edit" name="post-edit" class="btn btn-blue btn-icon"><i data-feather="edit"></i></button>
                                                    </form>
                                                </td>
                                                <td>
                                                <?php
                                                if (isset($_POST['post-delete'])){
                                                    $id = $_POST['id'];
                                                    $sql2= "DELETE FROM posts WHERE post_id = :id";
                                                    $stmt2 = $pdo->prepare($sql2);
                                                    $stmt2->execute([
                                                        ':id'=>$id
                                                    ]);
                                                   // echo "<div class='alert alert-success'> User Delete Successfull</div>";
                                                    header("location:all-post.php");
                                                }
                                                ?> 
                                                    <form action="all-post.php" method="POST">
                                                        <input type="hidden" value="<?php echo $post_id; ?>" name="id">
                                                        <button type="submit" name="post-delete" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                    </form>
                                                </td>
                                            </tr>  
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