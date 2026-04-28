<?php include 'header.php'; ?>

<section class="banner-area organic-breadcrumb">
	<div class="container">
		<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
			<div class="col-first">
				<h1>Contact Us</h1>
				<nav class="d-flex align-items-center">
					<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
					<a href="category.php">Contact</a>
				</nav>
			</div>
		</div>
	</div>
</section>

<section class="contact_area section_gap_bottom">
	<div class="container">
		<div id="mapBox" class="mapBox"
			data-lat="40.701083"
			data-lon="-74.1522848"
			data-zoom="13">
		</div>

		<div class="row">
			<div class="col-lg-3">
				<div class="contact_info">
					<div class="info_item">
						<i class="lnr lnr-home"></i>
						<h6>California, United States</h6>
						<p>Santa monica bullevard</p>
					</div>
					<div class="info_item">
						<i class="lnr lnr-phone-handset"></i>
						<h6><a href="#">00 (440) 9865 562</a></h6>
						<p>Mon to Fri 9am to 6 pm</p>
					</div>
					<div class="info_item">
						<i class="lnr lnr-envelope"></i>
						<h6><a href="#">support@colorlib.com</a></h6>
						<p>Send us your query anytime!</p>
					</div>
				</div>
			</div>

			<div class="col-lg-9">
				<form class="row contact_form" method="post" id="contactForm">
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" class="form-control" name="name" placeholder="Enter your name">
						</div>
						<div class="form-group">
							<input type="email" class="form-control" name="email" placeholder="Enter email address">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="subject" placeholder="Enter Subject">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<textarea class="form-control" name="message" rows="1" placeholder="Enter Message"></textarea>
						</div>
					</div>

					<div class="col-md-12 text-right">
						<button type="submit" class="primary-btn">Send Message</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("contactForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    let btn = this.querySelector("button");
    
   btn.innerText = "Sending...";
    btn.disabled = true;

    fetch("admin/php/contact.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success"){
          Swal.fire({
                icon: 'success',
                title: 'Sent!',
                text: data.message,
                confirmButtonColor: '#ffba00' // Aapki theme ka color
            });
            this.reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message,
                confirmButtonColor: '#ffba00'
            });
        }
        btn.innerText = "Send Message";
        btn.disabled = false;
    })
    .catch(() => {
       Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: 'Something went wrong. Please try again later.',
            confirmButtonColor: '#ffba00'
        });
        btn.innerText = "Send Message";
        btn.disabled = false;
    });
});
</script>

<?php include 'footer.php'; ?>
