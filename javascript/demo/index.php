<?php header('Access-Control-Allow-Origin: *'); header('Access-Control-Allow-Headers: Content-Type'); ?>
<html>
<head>
	<meta charset="utf-8">

	<title>JSO Demo</title>

	<!-- All JavaScript at the bottom, except this Modernizr build.
			 Modernizr enables HTML5 elements & feature detects for optimal performance.
			 Create your own custom Modernizr build: www.modernizr.com/download/ -->

	<script src="js/libs/json2.js"></script>
	<!-- https://github.com/wojodesign/local-storage-js -->
	<script src="js/libs/localstorage.js"></script>
	<script src="js/libs/modernizr-2.5.3.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

	<script src="../jso.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {


			// Add configuration for one or more providers.
			jso_configure({
				"prephero": {
					client_id: "testjs",
					//redirect_uri: "http://soleoshao.com/sandbox/oauth2/js/demo/index.html",
					authorization: "https://dev.prephero.com/PrepHero/v1?method=authorize&return=json",
					isDefault: true,
					presenttoken: "qs"
				}
			});

			// if (!confirm('Continue')) return;

			// Make sure that you have 
			jso_ensureTokens({
				// "facebook": ["read_stream"],
				// "google": ["https://www.googleapis.com/auth/userinfo.profile"],
				//"instagram": ["basic", "likes"]
				"prephero":[]
			});

			// This dumps all cached tokens to console, for easyer debugging.
			jso_dump();

			// Perform a data request
			$.oajax({
				url: "https://dev.prephero.com/PrepHero/v1",
				jso_provider: "prephero", // Will match the config identifier
				jso_scopes: false, // List of scopes (OPTIONAL)
				dataType: 'jsonp',
				crossDomain: true,
				success: function(data) {
					console.log("Response (bridge):");
					console.log(data);
				},
				error: function() {
					console.log("ERROR Custom callback()");
				}
			});

			// Perform a data request
			// $.oajax({
			// 	url: "https://www.googleapis.com/oauth2/v1/userinfo",
			// 	jso_provider: "google",
			// 	jso_allowia: true,
			// 	jso_scopes: ["https://www.googleapis.com/auth/userinfo.profile"],
			// 	dataType: 'json',
			// 	success: function(data) {
			// 		console.log("Response (google):");
			// 		console.log(data);
			// 	}
			// });

			// jso_wipe();

		});
	</script>

</head>
<body>



</body>
</html>