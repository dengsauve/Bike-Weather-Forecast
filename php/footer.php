<?
// Current Conditions
$cc_url = "http://api.wunderground.com/api/963b29bf0454809e/conditions/q/WA/Spokane.json";
$cc_json = file_get_contents($cc_url);
$cc = json_decode($cc_json);


// The Wunderground Logo url
$img_url = $cc->{'current_observation'}->{'image'}->{'url'};
?>

<div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">About bikercast</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
            Cyclists use bikercast to research the upcoming weather in their area, and decide whether or not to ride.
        </p>
        <p>
            I designed this site to be simple to use, with at-a-glance data provided for cyclists on the move.
        </p>
        -Dennis
      </div>
    </div>
  </div>
</div>

<footer class="footer">
    <div class="container">
        <a href="http://www.wunderground.com" target="_blank">
            <img class="img-fluid" src="<?php echo $img_url; ?>" alt="Visit Weather Underground!" />
        </a>
        <span class="text-muted">
            Powered by Weather Underground
            -
            &copy; <?php echo Date("Y"); ?> Dennis Sauve -
        </span>
        <a role="button" href="" data-toggle="modal" data-target="#aboutModal">
            About bikercast
        </a>
    </div>
</footer>