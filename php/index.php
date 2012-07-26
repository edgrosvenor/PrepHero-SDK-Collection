<?php
include_once "PrepHeroApi.php";
$api = new PrepHeroApi();
?>

<h1>Test PrepHero Example API Calls</h1>
<div>
	<h3><a href="<?php echo $api->getAuthUrl(); ?>"> Authentication -- JSON version</a></h3>
</div>