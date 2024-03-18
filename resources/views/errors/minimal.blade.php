<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="/assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="/assets/css/pace.min.css" rel="stylesheet" />
	<script src="/assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="/assets/css/app.css" rel="stylesheet">
	<link href="/assets/css/icons.css" rel="stylesheet">
	<title>@yield('code')</title>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="error-404 d-flex align-items-center justify-content-center">
			<div class="container">
				<div class="card py-5">
					<div class="row g-0">
						<div class="col col-xl-5">
							<div class="card-body p-4">
								<h1 class="display-1"><span class="text-primary">@yield('code')</span></h1>
								<h2 class="font-weight-bold display-4">@yield('message')</h2>
								<div class="mt-5"> <a href="/" class="btn btn-primary btn-lg px-md-5 radius-30">Главная</a>
								</div>
							</div>
						</div>
						{{-- <div class="col-xl-7">
							<img src="https://cdn.searchenginejournal.com/wp-content/uploads/2019/03/shutterstock_1338315902.png" class="img-fluid" alt="">
						</div> --}}
					</div>
					<!--end row-->
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
	<!-- Bootstrap JS -->
	<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
