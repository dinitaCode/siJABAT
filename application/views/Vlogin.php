<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>siJABAT - Rekomendasi Jabatan</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="shortcut icon" href="<?= base_url(); ?>assets/img/logfull.png">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<div class="login-logo">
					<a href="<?=base_url()?>">
					<img class="img-fluid pad" src="<?= base_url('assets/img/logo.png') ?>" />
						<h6 class="text-muted"><i><b>Knowledge Based</b> Recommender System</i></h6>
					</a>
					<!-- <a href="#"><small><i>Knowledge Based Recommender System</i></small></a> -->
				</div>
				<hr>
				<form action="<?= base_url('proseslog') ?>" method="post">
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="username" placeholder="Username"  autocomplete="off" autofocus>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
							<div class="icheck-primary">
								<input type="checkbox" id="remember">
								<label for="remember">
									Remember Me
								</label>
							</div>
							<hr>
							<button type="submit" class="btn btn-primary btn-block">Sign In</button>
					<!-- <div class="row">
						<div class="col-8">
						</div>
						<div class="col-4">
						</div>
					</div> -->
				</form>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>

	<script>
		<?php if (@$_SESSION['notification']) { ?>
			var isi = <?php echo json_encode($this->session->flashdata('notification')) ?>;
			Swal.fire({
				icon: 'success',
				title: 'Hei...',
				text: isi
			});
		<?php unset($_SESSION['notification']);
		} else  if (@$_SESSION['tetot']) { ?>
			var isi = <?php echo json_encode($this->session->flashdata('tetot')) ?>;
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: isi
			});
		<?php unset($_SESSION['tetot']);
		} else ?>
	</script>
	<!-- jQuery -->
	<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
</body>

</html>