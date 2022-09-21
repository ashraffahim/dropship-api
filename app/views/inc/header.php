<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $data['title']; ?></title>
	<meta name="description" content="<?php echo $data['description']; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- style -->
	<!-- build:css /assets/css/site.min.css -->
	<!-- <link rel="stylesheet" href="/libs/font-awesome-pro-5/css/free.min.css" type="text/css"> -->
	<link rel="stylesheet" href="/libs/font-awesome-pro-5/css/all.min.css" type="text/css">
	<link rel="stylesheet" href="/assets/css/bootstrap.css" type="text/css">
	<link rel="stylesheet" href="/assets/css/style.css" type="text/css">
	<!-- endbuild -->
	<link rel="canonical" href="<?php echo $data['canonical']; ?>">
	<link rel="manifest" href="/manifest.json">
	<script type="application/ld+json"><?php echo $data['schema']; ?></script>
	<!-- Script -->
	<!-- jQuery -->
	<script src="/libs/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="/libs/popper.js/dist/umd/popper.min.js"></script>
	<script src="/libs/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- App -->
	<script src="/assets/js/config.js"></script>
	<script src="/assets/js/script.js"></script>
<body>
	<main>
		<nav class="navbar mb-5">
			<div class="container-fluid">
				<div class="row justify-content-between">
					<div class="col-2 d-inline-flex">
						<a href="/" style="display: inline-block;height: 34px;width: 34px;background-image: url(<?php echo LOGO; ?>);background-size: cover;">
						</a>
					</div>
				</div>
			</div>
		</nav>