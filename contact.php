<?php $current_page = "Contact us"; ?>
<?php require_once("./includes/header.php"); ?>

        <div id="layoutDefault">
            <div id="layoutDefault_content">
                <main>
                    
                    <nav class="navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
                        <div class="container">
                            <a class="navbar-brand text-dark" href="index.php">Developer Lynda</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><img src="./img/menu.png" style="height:20px;width:25px" /><i data-feather="menu"></i></button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto mr-lg-5">
                                <?php 
                                    require_once("./includes/nav-bar.php");
                                ?>
                                </ul>
                                <?php 
                                    $curr_page = basename(__FILE__);
                                    require_once("./includes/registration.php");
                                ?>
                            </div>
                        </div>
                    </nav>

                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
                        <div class="page-header-content pt-10">
                            <div class="container text-center">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <h1 class="page-header-title mb-3">Contact Us</h1>
                                        <p class="page-header-text">We will back to you in a week!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-rounded text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0" /></svg>
                        </div>
                    </header>

                    <?php 
                        if(isset($_COOKIE['_uid_'])) {
                            $user_id = base64_decode($_COOKIE['_uid_']);
                        } else if(isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                        } else {
                            $user_id = -1;
                        }
                        $sql = "SELECT * FROM users WHERE user_id = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':id' => $user_id
                        ]);
                        $rowcount = $stmt->rowCount();
                        if ($rowcount !=0 ){
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        $user_id = $user['user_id'];
                        $user_name = $user['user_name'];
                        $user_email = $user['user_email'];
                        $user_photo = $user['user_photo'];
                        }
                        
                    ?>

                                <?php
                                    if (isset($_POST['submit'])){
                                        $user_name = $_POST['user-name'];
                                        $email = $_POST['email'];
                                        $ms_details = trim($_POST['details']);

                                        $sql = "INSERT INTO message (ms_username, ms_user_id, ms_user_email, ms_details) VALUES (:username, :user_id, :email, :details)";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute([
                                            ':username'=> $user_name,
                                            ':user_id'=>$user_id,
                                            ':email'=>$email,
                                            ':details'=> $ms_details
                                        ]);
                                        header("Location: contact.php");
                                    }
                                ?>
                    <section class="bg-white py-10">
                        <div class="container">
                            <?php
                        if(isset($_COOKIE['_uid_']) || isset($_COOKIE['_uiid_']) || isset($_SESSION['login'])) { ?>
                            <form action="" method="POST">
                                <div class="form-row">
                                    <div class="form-group col-md-6"><label class="text-dark" for="inputName">Full name</label><input value="<?php echo $user_name; ?>" readonly name="user-name" class="form-control py-4" id="inputName" type="text" placeholder="Full name" /></div>
                                    <div class="form-group col-md-6"><label class="text-dark" for="inputEmail">Email</label><input value="<?php echo $user_email; ?>"  readonly name="email" class="form-control py-4" id="inputEmail" type="email" placeholder="name@example.com" /></div>
                                </div>
                                <div class="form-group"><label class="text-dark" for="inputMessage">Message</label><textarea class="form-control py-3" id="inputMessage" name="details" type="text" placeholder="Enter your message..." rows="4"></textarea></div>
                                <div class="text-center"><button class="btn btn-primary btn-marketing mt-4" name="submit" type="submit">Submit Request</button></div>
                            </form>
                            <?php } else { ?>
                                <a href="./backend/signin.php"> Login before you contact us </a>
                            <?php } ?>
                        </div>


                        <?php
                            $sql2 = "SELECT * FROM message WHERE ms_user_id = :id";
                            $stmt2= $pdo->prepare($sql2);
                            $stmt2->execute([
                                ':id'=>$user_id
                            ]);
                            $rows = $stmt2->rowCount();
                            if( $rows != 0) { ?>
                                <div class="mt-5 container">
                                    <table class="table table-striped table-bordered table-hover" >
                                        <thead class="text-center"style="width:400px">
                                            <tr >
                                                <th scope="col">message</th>
                                                <th scope="col">Reply</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  
                                            while ($mes = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                $ms_details = $mes['ms_details'];
                                                $ms_reply = $mes['reply']; ?>
                                                <tr>
                                                <td><?php echo $ms_details; ?></td>
                                                <td><?php echo $ms_reply; ?></td>
                                                </tr>

                                            <?php }
                                            ?>
                                            
                                        </tbody>
                                    </table>

                                </div>
                               
                           <?php }

                        ?>
                        

                        <div class="svg-border-rounded text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0" /></svg>
                        </div>
                    </section>
                </main>
            </div>
            <div id="layoutDefault_footer">
                <footer class="footer pt-4 pb-4 mt-auto bg-dark footer-dark">
                    <div class="container">
                        <hr class="my-1" />
                        <div class="row align-items-center">
                            <div class="col-md-6 small">Copyright &#xA9; Your Website 2020</div>
                            <div class="col-md-6 text-md-right small">
                                <a href="privacy-policy.php">Privacy Policy</a>
                                &#xB7;
                                <a href="terms-conditions.php">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

<?php require_once("./includes/footer.php"); ?>