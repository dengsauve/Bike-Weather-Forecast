<?
// Current Conditions
$cc_url = "http://api.wunderground.com/api/963b29bf0454809e/conditions/q/WA/Spokane.json";
$cc_json = file_get_contents($cc_url);
$cc = json_decode($cc_json);


// The Wunderground Logo url
$img_url = $cc->{'current_observation'}->{'image'}->{'url'};
?>

<footer class="footer">
    <div class="container">
        <span class="text-muted">Powered by Weather Underground</span>
            <a href="http://www.wunderground.com" target="_blank">
                <img class="img-fluid" src="<?php echo $img_url; ?>" alt="Visit Weather Underground!" />
            </a>
        <span class="text-muted">&copy; <?php echo Date("Y"); ?> Dennis Sauve</span>
    </div>
</footer>