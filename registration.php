<?php include 'header.php'; ?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Register</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Register</a>
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
                        <h4>Already have an account?</h4>
                        <p>Log in to your account to explore our latest updates.</p>
                        <a class="primary-btn" href="login.php">Log In Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Create an Account</h3>
                    
                    <form class="row login_form" id="registerForm">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" required id="f-option2">
                                <label for="f-option2">I agree to the Terms & Conditions</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Register Now</button>
                        </div>
                        <div class="col-md-12 form-group">
                            <p id="msg" style="font-weight:bold;"></p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
document.getElementById("registerForm").addEventListener("submit", function(e){
    e.preventDefault();

    let formData = new FormData(this);
    let msgBox = document.getElementById("msg");

    msgBox.innerHTML = "Processing...";
    msgBox.style.color = "blue";

    // Backend file ka path sahi hona chahiye
    fetch("php/register.php", { 
        method: "POST",
        body: formData
    })
    .then(res => res.text()) // Pehle text mein lein taaki agar error ho to dikh jaye
    .then(text => {
        try {
            let data = JSON.parse(text); // Phir JSON parse karein
            if(data.status === "success"){
                msgBox.style.color = "green";
                msgBox.innerHTML = data.message;
                setTimeout(() => {
                    window.location.href = "login.php";
                }, 1500);
            } else {
                msgBox.style.color = "red";
                msgBox.innerHTML = data.message;
            }
        } catch (error) {
            console.log("Server Response:", text); // Console mein error dekhein
            msgBox.style.color = "red";
            msgBox.innerHTML = "Server error. Check console.";
        }
    })
    .catch(error => {
        console.error("Error:", error);
        msgBox.innerHTML = "Network error occurred.";
    });
});
</script>