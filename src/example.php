<?php
require "apikey.php";
require "OpenId.php";
require "getInfo.php";

/* Here we start session. This is required for the sessions to work! */

session_start();

/* This checks whether or not the session "SteamAuth" is set. */
/* This will return either a boolean true or a boolean false. */
/* True if the user is logged in and false if the user isn't. */

if (!(isset($_SESSION['SteamAuth']) && $_SESSION['SteamAuth'] != '')) {
	$auth = false;
} else $auth = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>OpenID &amp; Steam Example</title>

	<!-- Do not use this example as your page. Use it to learn how to use the ressource. -->
	<!-- The page implements Twitter Bootstrap for easy styling. -->

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<a class="navbar-brand" href="https://github.com/foldagerdk/SteamOpenID">Example of using OpenID &amp; Steam</a>
			<?php if ($auth) { ?>
			<!-- If this is shown, the user is logged in, and the user's Steam information should be shown. -->
			<div class="navbar-right">
				<p class="navbar-text navbar-right">Signed in as <a href="<?php echo $info_url; ?>" class="navbar-link"><?php echo $info_name; ?></a> | <a href="auth.php?logout">Sign out</a>&nbsp;&nbsp;<a href="<?php echo $info_url; ?>"><img class="hidden-xs" src="<?php echo $info_avatar_sm; ?>" /></a></p>
			</div>
			<?php } else { ?>
			<!-- If this is shown, the has not signed in, and therefore no information is shown. Instead, there is a button to log in. -->
			<div class="navbar-right">
				<p class="navbar-text navbar-right"><a href="auth.php?login" style="margin-top: .5em;"><img src="http://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_small.png"></a></p>
			</div>
			<?php } ?>
		</div>
	</nav>
	<div class="container">
		<div class="col-lg-12">
			<?php if ($auth) { ?>
			<!-- This is what will show if the user is logged in. Basically this shows the different things you can do. -->
			<div class="row">
				<div class="col-md-12">
					<h2>Steam Name &amp; Location</h2>
					<div class="col-md-12">
						<p>Steam Name: <?php echo $info_name; ?></p>
						<p>Location: <?php echo $info_loc; ?></p>
						<p>Flag: <img src="http://openiconlibrary.sourceforge.net/gallery2/open_icon_library-full/icons/png/16x16/intl/flag-<?php echo strtolower($info_loc); ?>.png" /></p>
						<p>The flag should work with most nationalities.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h2>Steam ID and URL</h2>
					<div class="col-md-12">
						<p>Steam ID: <?php echo $info_id; ?></p>
						<p>Steam URL: <a href="<?php echo $info_url; ?>"><?php echo $info_url; ?></a></p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h2>Different avatar sizes</h2>
					<div class="col-md-4 text-center">
						<img class="vcenter" src="<?php echo $info_avatar_lg; ?>" alt="" />
						<p>Large</p>
					</div>
					<div class="col-md-4 text-center">
						<img class="vcenter" src="<?php echo $info_avatar_md; ?>" alt="" />
						<p>Medium</p>
					</div>
					<div class="col-md-4 text-center">
						<img class="vcenter" src="<?php echo $info_avatar_sm; ?>" alt="" />
						<p>Small</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<hr/>
					<p>Please note that all this information is cached, and may not show accurate results. To fix this, you can refresh the cache.</p>
					<!-- Yeah.. Since we are caching the information, we are not getting live results. You may wish to not cache things like names and onlinestatuses. -->
					<!-- I will publish a no-cache version of this ressource. -->
				</div>
			</div>
			<?php } else { ?>
			<!-- This is a message that is shown to tell the user that they have to log in in order to use the site features.-->
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-info">
						<h3>Nothing here?</h3>
						<p>Information will be shown here only if you are logged in.</p>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<footer class="navbar navbar-default navbar-fixed-bottom">
		<div class="container">
			<p class="navbar-text pull-right">Ressource created by <a href="http://foldager.me">Foldager</a> | More information can be found <a href="https://github.com/foldagerdk/SteamOpenID">here</a>.</p>
		</div>
	</footer>

	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</body>
</html>