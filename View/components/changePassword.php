<div class="container">
    
    <h3>Change your password here:</h3>
    <?php
    if(isset($_SESSION['message'])) :
    ?>
    <div class="alert alert-info">
        <?=$_SESSION['message'];?>
    </div>
    <?php
    unset($_SESSION['message']);
    endif;
    ?>
    <form action="" method="post">
        <div class="mb-3 mt-5">
            <label for="new"><b>New Password</b></label>
            <br>
            <input type="text" class="form-control mt-1" placeholder="password" name="pass" style='width:380px;'>
        </div>
        <div class="mb-5 mt-1">
            <button class="btn btn-dark" type="submit" style='background-color:#007bff;'>Change</button>
        </div>
    </form>
</div>

<?php
if($_SESSION['user'] == 'secretary'){
    if(isset($_POST['pass'])){
        $password = $_POST['pass'];
        if(
            !secretaryUpdatePassword($_SESSION['sec-id'],$password)
        ){
            $_SESSION['message'] = 'error updating password';
        }
        else{
            $_SESSION['message'] = 'success';
        }
    }
}
if($_SESSION['user'] == 'doctor'){
    if(isset($_POST['pass'])){
        $password = $_POST['pass'];
        include '../../Controller/doctorController.php';
        if(
            !doctorUpdatePassword($_SESSION['doc-id'],$password)
        ){
            $_SESSION['message'] = 'error updating password';
        }
        else{
            $_SESSION['message'] = 'success';
        }
    }
}
?>