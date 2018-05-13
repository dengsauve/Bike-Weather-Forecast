<?php

$ten_url = "http://api.wunderground.com/api/963b29bf0454809e/forecast10day/q/WA/Spokane.json";
$ten_json = file_get_contents($ten_url);
$ten = json_decode($ten_json);

$days = $ten->{'forecast'}->{'txt_forecast'}->{'forecastday'};

foreach($days as $day)
{
    echo '<div class="card col-12 col-sm-6 col-md-4 col-lg-3">';
    echo '  <div class="card-body">';
    echo "      <h5 class='card-title'>" . $day->{'title'} . "</h5>";
    echo '      <p class="card-text">' . $day->{'fcttext'} . "</p>";
    echo '  </div>';
    echo '</div>';
}