<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>{{ $title }}</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

	<link rel="stylesheet" type="text/css" href="src/plugins/datetimepicker/datetimepicker.css">

	<link rel="stylesheet" type="text/css" href="src/styles/loader.css">


</head>

<body>
	{{-- Pre Loader --}}
	{{-- @include('partials.preloader') --}}
	{{-- Header Component --}}
	@include('partials.header')

	{{-- Side Bar Component --}}
	@include('partials.sidebar')

	<div class="main-container">
		<div class="pd-ltr-20">
			@yield('content')

			{{-- Footer Component --}}
			@include('partials.footer')
		</div>
	</div>

	@include('sweetalert::alert')
	{{-- <script src="vendors/scripts/sweetalert.min.js"></script> --}}

	{{-- Js --}}
	<script src="src/scripts/jquery.min.js"></script>

	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src="src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

	{{-- plugins --}}
	<script src="src/plugins/datetimepicker/moment.min.js"></script>
	<script src="src/plugins/datetimepicker/datetimepicker.js"></script>
	<script src="src/plugins/ckeditor/ckeditor.js"></script>



	<script src="src/scripts/custom.js"></script>

	<script src="vendors/scripts/datatable-setting.js"></script>


	<script>
		// auto close alert
	$(document).ready(function () {
	window.setTimeout(function () {
		$(".alert-notif")
		.fadeTo(500, 0)
		.slideUp(500, function () {
			$(this).remove();
		});
	}, 3500);
	});

	function htmlspecialchars(string) {
  // Our finalized string will start out as a copy of the initial string.
  var escapedString = string;

  // For each of the special characters,
  var len = htmlspecialchars.specialchars.length;
  for (var x = 0; x < len; x++) {
    // Replace all instances of the special character with its entity.
    escapedString = escapedString.replace(
      new RegExp(htmlspecialchars.specialchars[x][0], "g"),
      htmlspecialchars.specialchars[x][1]
    );
  }

  // Return the escaped string.
  return escapedString;
}

// A collection of special characters and their entities.
htmlspecialchars.specialchars = [
  ["&", "&amp;"],
  ["<", "&lt;"],
  [">", "&gt;"],
  ['"', "&quot;"],
];

	</script>

	@yield('script')
</body>

</html>