<?php session_start (); ?>
 <?php


function loginForm() {
    echo '
	<div class="form-group">
		<div id="loginform">
			<form action="live-chat.php" method="post">
			<h1>Simple Live Chat</h1><hr/>
				<label for="name">Please Enter Your Name To Proceed..</label>
				<input type="text" name="name" id="name" value= "'.$_SESSION['user_name'].'" class="form-control" placeholder="Enter Your Name"/>
				<input type="submit" class="btn btn-default" name="enter" id="enter" value="Enter" />
			</form>
		</div>
	</div>
   ';
}
 
if (isset ( $_POST ['enter'] )) {
    if ($_POST ['name'] != "") {
        $_SESSION ['chat-name'] = stripslashes ( htmlspecialchars ( $_POST ['name'] ) );
        $cb = fopen ( "./log.html", 'a' );
        if(isset($_SESSION['login']) && $_SESSION['user_role'] == 'admin'){
        fwrite ( $cb, "<div class='msgln'><i>User " . $_SESSION ['user_role'] . " has joined the chat session.</i><br></div>" );
        }else{
        fwrite ( $cb, "<div class='msgln'><i>User " . $_SESSION ['chat-name'] . " has joined the chat session.</i><br></div>" );
        }
        fclose ( $cb );
    } else {
        echo '<span class="error">Please Enter a Name</span>';
    }
}
 
if (isset ( $_GET ['logout'] )) {
    $cb = fopen ( "./log.html", 'a' );
    if(isset($_SESSION['login']) && $_SESSION['user_role'] == 'admin'){
    fwrite ( $cb, "<div class='msgln'><i>User " . $_SESSION ['user_role'] . " has left the chat session.</i><br></div>" );
    unset($_SESSION['chat-name']);
    fclose ( $cb );
    header ( "Location: live-chat.php" );    
}else{
    fwrite ( $cb, "<div class='msgln'><i>User " . $_SESSION ['chat-name'] . " has left the chat session.</i><br></div>" );
    unset($_SESSION['chat-name']);
    header ( "Location: live-chat.php" );
    }
    
    }
    
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<link rel="stylesheet" href="css/style2.css">
	<link rel="stylesheet" href="js/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <link rel="icon" type="image/x-icon" href="img/favicon.png" />
</head>
<body id="bg">
<?php
if(!isset($_SESSION['login'])){
    echo "<div class='alert alert-danger'>You Have To Registered Before You Get To Forum  <a href='./backend/signin.php'> Sign in!!!!!</a></div>";
     die();
}
?>
    
<?php
	if (! isset ( $_SESSION ['chat-name'] )) {
	loginForm ();
	} else {
?>
<div id="wrapper">
	<div id="menu">
	<h1>Live Chat!</h1><hr/>
		<p class="welcome"><b>Welcome - <a><?php echo $_SESSION['chat-name']; ?></a></b></p>
		<p class="logout"><a id="exit" href="#" class="btn btn-default">Exit Live Chat</a></p>
	<div style="clear: both"></div>
	</div>
	<div id="chatbox">
	<?php
		if (file_exists ( "log.html" ) && filesize ( "log.html" ) > 0) {
		$handle = fopen ( "log.html", "r" );
		$contents = fread ( $handle, filesize ( "log.html" ) );
		fclose ( $handle );

		echo $contents;
		}
	?>
	</div>
<form name="message" action="">
	<input name="usermsg" class="form-control" type="text" id="usermsg" placeholder="Create A Message" />
	<input name="submitmsg" class="btn btn-default" type="submit" id="submitmsg" value="Send" />
</form>
</div>



<script type="text/javascript">
        $(document).ready(function(){
        });
        $(document).ready(function(){
            $("#exit").click(function(){
                var exit = confirm("Are You Sure You Want To Leave This Page?");
                if(exit==true){window.location = 'live-chat.php?logout=true';}     
            });
        });
        $("#submitmsg").click(function(){
                var clientmsg = $("#usermsg").val();
                $.post("live-post.php", {text: clientmsg});             
                $("#usermsg").attr("value", " ");
                loadLog;
            return false;
        });


        function loadLog(){    
            var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
            $.ajax({
                url: "./log.html",
                cache: false,
                success: function(html){       
                    $("#chatbox").html(html);       
                    var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
                    if(newscrollHeight > oldscrollHeight){
                        $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal');
                    }              
                },
            });
        }
        setInterval (loadLog, 2500);
        </script>

    <?php
    }
    ?>
</body>
</html>

