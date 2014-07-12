<?php
error_reporting(E_ERROR | E_PARSE);

require 'OpenId.php';
require 'apikey.php';

$redir = "/example.php";
/* You may want to specify this as something like $_GET['previouspage'], and have your login/logout buttons send the GET information. */

session_start();

try {
    $openid = new LightOpenID('awsu.me');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            if (!(isset($_SESSION['SteamAuth']) && $_SESSION['SteamAuth'] != '')) {
                $openid->identity = 'http://steamcommunity.com/openid/?l=english';
                header('Location: ' . $openid->authUrl());
            } else {
                header("Location: {$redir}?err1");
            }
        } else if(isset($_GET['logout'])) {
            if (isset($_SESSION['SteamAuth']) && $_SESSION['SteamAuth'] != '') {
                unset($_SESSION['SteamAuth']);
                unset($_SESSION['SteamID64']);
                header("Location: {$redir}");
            } else {
                header("Location: {$redir}?err2");
            }
        } else {
            header("Location {$redir}");
        }
    } elseif($openid->mode == 'cancel') {
        header("Location: {$redir}?err3");
    } else {
        if($openid->validate()) {
            $id = $openid->identity;
            $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
            preg_match($ptn, $id, $matches);
            $_SESSION['SteamAuth'] = $id;
            $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api&steamids=$matches[1]";
            $json_object= file_get_contents($url);
            $json_decoded = json_decode($json_object);
            foreach ($json_decoded->response->players as $player) {
                $_SESSION['SteamID64'] = $player->steamid;
            }
            $Steam64 = str_replace("http://steamcommunity.com/openid/id/", "", $_SESSION['SteamAuth']);
            $profile = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={$api}&steamids={$Steam64}");
            $buffer = fopen("cache/{$Steam64}.json", "w+");
            fwrite($buffer, $profile);
            fclose($buffer);
            header("Location: {$redir}?success");
        } else {
            header("Location: {$redir}?err4");
        }
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
echo 'If you for some reason is still here, try going to <a href="/">the main page</a>.';
?>
