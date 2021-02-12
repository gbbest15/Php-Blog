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
                                    <span>Try Creating New Post</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <?php
                    if(isset($_POST['save'])){
                        $post_title = $_POST['post-title'];
                        $post_status = $_POST['post-status'];
                        $post_cat = $_POST['select-category'];
                        $post_photo = $_FILES['post-photo']['name'];
                        $post_photo_tmp = $_FILES['post-photo']['tmp_name'];
                        $post_details = $_POST['post-content'];
                        $post_tags = $_POST['post-tags'];

                        $sql1 = "SELECT * FROM categories WHERE category_name = :name";
                        $stmt1 = $pdo->prepare($sql1);
                        $stmt1->exeCute([
                            ':name'=>$post_cat
                        ]);
                        $fet_cat = $stmt1->fetch(PDO::FETCH_ASSOC);
                        // categories id
                        $cat_id = $fet_cat['category_id'];

                        if(empty($post_photo)){
                            $erro = true;
                        }
                        move_uploaded_file("{$post_photo_tmp}","../img/{$post_photo}");

                        $sql2= "INSERT INTO posts (post_title, post_details, post_author, post_cat_id, post_tag, post_image, post_status) VALUES (:title, :details,:author,:cat_id, :tag, :image,:status)";
                        $stmt2= $pdo->prepare($sql2);
                        $stmt2->execute([
                            ':title' =>$post_title,
                            ':details'=>$post_details,
                            ':author'=>$_SESSION['user_name'],
                            ':cat_id'=>$cat_id,
                            ':tag'=>$post_tags,
                            ':image'=>$post_photo,
                            ':status'=>$post_status
                        ]);                     
                            $succes= true;
                        }
                    ?>

                    <!--Start Form-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Create New Post</div>
                            <div class="card-body">
                                <?php
                                if(isset($erro)){
                                    echo "<p class='alert alert-danger'>Please upload the image of the picture</p>";
                                }elseif(isset($succes)){
                                        echo "<p class='alert alert-success'>Post Save Successfull</p>";
                                }
                                ?>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="post-title">Post Title:</label>
                                        <input class="form-control" name="post-title" type="text" placeholder="Post title ..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="post-status">Post Status:</label>
                                        <select class="form-control" name="post-status">
                                            <option>Published</option>
                                            <option>Draft</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="select-category">Select Category:</label>
                                        <select class="form-control" name="select-category">
                                        <?php 
                                        $sql = "SELECT * FROM categories";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        while ($cat = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $cat_name = $cat['category_name']; ?>
                                                <option><?php echo $cat_name; ?></option>
                                            <?php }
                                                ?>
                                        
                                            
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-title">Choose photo:</label>
                                        <input class="form-control" name="post-photo" type="file" />
                                    </div>

                                    <div class="form-group">
                                        <label for="post-content">Post Details:</label>
                                        <textarea class="form-control" placeholder="Type here..." name="post-content" rows="9"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="post-tags">Post Tags:</label>
                                        <textarea class="form-control" placeholder="Tags..." name="post-tags" rows="3"></textarea>
                                    </div>
                                    <button class="btn btn-primary mr-2 my-1" type="submit" name="save">Submit now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Form-->

                </main>

<?php require_once('./includes/footer.php'); ?>