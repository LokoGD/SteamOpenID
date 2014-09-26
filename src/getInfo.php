<?php

session_start();

if (!(isset($_SESSION['SteamAuth']) && $_SESSION['SteamAuth'] != '')) {
	/*This should never happen. This is just in case it does. */
	$info_name = "error";
	$info_id = "error";
	$info_url = "error";
	$info_avatar_sm = "error";
	$info_avatar_md = "error";
	$info_avatar_lg = "error";
} else {
	/*This is what should happen. */
	$Steam64 = $_SESSION['SteamID64'];
	$steamuser = json_decode(file_get_contents("/cache/$Steam64.json"));
	foreach ($steamuser->response->players as $player){
		$info_name = $player->personaname;
		$info_id = $player->steamid;
		$info_url = $player->profileurl;
		$info_avatar_sm = $player->avatar;
		$info_avatar_md = $player->avatarmedium;
		$info_avatar_lg = $player->avatarfull;
		$info_loc = $player->loccountrycode;
	}
}
?>
