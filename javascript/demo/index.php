
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title>PrepHero Demo</title>


 	<script type="text/javascript" src="gwt-oauth2.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="../lib/prephero.js"></script>
</head>
<body>
<center>
	<h1>Test JavaScript API for PrepHero</h1>	
<button type='button' onclick="prephero.authenticate();">Authenticate with PrepHero</button>
<br/><br/>
<button type='button' onclick="prephero.getUserInfo();">Get User Info</button>
<br/><br/>
<button type='button' onclick="prephero.revokeAccess();">Revoke Access</button><br/>
<br/>
</center>
</body>
</html>