<?php
    include("mysql_connect.php");
    session_start();
    if (!isset($_SESSION['u_id'])) header("Location: login.php") ;

    $u_id = $_SESSION['u_id'];
    $u_name = $_SESSION['u_name'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nomi in the House~</title>
    <?php include('_headCommon.php');?>
</head>
<body>

    <?php include('_navbar.php');?>
<?php
if (isset($_GET['c_id'])){
    $c_id = $_GET['c_id'];


    $query = "SELECT content.c_title, content.c_text, content.c_image, LKS.l_date
                FROM content
                LEFT JOIN (SELECT * FROM likes WHERE u_id = '$u_id') LKS
                ON content.c_id=LKS.c_id
                WHERE content.c_id = ?";


    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $c_id);
        $stmt->execute();
        $stmt->bind_result($title, $text, $image, $l_date);
        $stmt->fetch();
        $stmt->close();
        if ($title){
            ?>

        <div class = "container-fluid singlecontent" align = "center">

            <h1><?php echo($title)?></h1>
            <img src="<?php echo($image)?>" id = "pics" >
            <p><?php echo($text)?></p>
            <span>
                <?php
                        if($l_date){
                    ?>
                            <a href="#likeContent" data-postId="<?php echo($c_id); ?>" > <img id ="like" src="image/like.png" width ="40px"></a>

                    <?php

                        }else{
                    ?>
                            <a href="#likeContent" data-postId="<?php echo($c_id); ?>" > <img id ="like" src="image/dlike.png" width ="40px"></a>
                    <?php

                        }

                    ?>
            </span>
            <div class="modal-body">

              <ul class = "list-group  pcc" data-postId="0">
                 <li id = "fcom" data-postId="<?php echo($c_id); ?>" class="list-group-item">Show comments...</li>


              </ul>
                <input type="text" class="form-control " name = "comment" id="postCommentText" placeholder="Comment...">
                <span class="error"><?php echo $comErr;?></span>
            </br>
                <button type="submit" class="btn btn-primary" id = "submitPostComment" value = "cf" data-postId="<?php echo($c_id); ?> " data-uname="<?php echo($u_name); ?>">Post</button>
            </div>

        </div>

        <?php
        }
        $mysqli->close();
    }


}else{
   // echo('HUH?');
}
?>


    <?php include('_footer.php');?>
    <?php include('_scripts.php');?>
</body>