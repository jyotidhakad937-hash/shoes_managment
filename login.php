<?php 
if(isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}
include 'header.php'; 
?>
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Login/Register</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="category.php">Login/Register</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="img/login.jpg" alt="">
                    <div class="hover">
                        <h4>New to our website?</h4>
                        <p>Join us today to explore more.</p>
                        <a class="primary-btn" href="registration.php">Create an Account</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Log in to enter</h3>
                    <form class="row login_form" id="loginForm">
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" name="keep_logged_in">
                                <label for="f-option2">Keep me logged in</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Log In</button>
                        </div>
                        <div class="col-md-12 form-group">
                            <p id="msg" style="font-weight: bold;"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
document.getElementById("loginForm").addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(this);
    let msgBox = document.getElementById("msg");

    msgBox.innerHTML = "Checking...";
    msgBox.style.color = "blue";

    fetch("php/login.php", { 
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success"){
            msgBox.style.color = "green";
            msgBox.innerHTML = data.message;
            setTimeout(() => { window.location.href = "index.php"; }, 1000);
        } else {
            msgBox.style.color = "red";
            msgBox.innerHTML = data.message;
        }
    })
    .catch(error => {
        msgBox.style.color = "red";
        msgBox.innerHTML = "Error: Check console or file path.";
        console.error(error);
    });
});
</script>