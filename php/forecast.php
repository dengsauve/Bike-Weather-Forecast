<?php

$fc_url = "http://api.wunderground.com/api/963b29bf0454809e/forecast/q/WA/Spokane.json";
$fc_json = file_get_contents($fc_url);
$fc = json_decode($fc_json);

// Conditional Alert Strings
$great = "success";
$clear = "info";
$subpar = "warning";
$poor = "danger";

// Today's Forecast
$fc_day = $fc->{'forecast'}->{'txt_forecast'}->{'forecastday'}[0]->{'fcttext'};

$neg_keywords = ['thunderstorm', 'snow', 'rain', 'freezing', 'shower', 'flurries', 'cloudy', 'variable'];
$pos_keywords = ['sunny', 'light', 'sunshine', 'clear'];

$score = 0;

foreach($neg_keywords as $n)
{
    if( strpos($fc_day, $n) !== false ){
        $score--;
    }
}

foreach($pos_keywords as $p)
{        
    if( strpos($fc_day, $p) !== false ){
        $score++;
    }
}

$condition = $clear;

if( $score > 0 )
{
    $condition = $great;
}
elseif( $score == 0 )
{
    $condition = $clear;
}
elseif( $score < 0 )
{
    $condition = $subpar;
}
else
{
    $condition = $poor;
}

?>

<div class="alert alert-<?php echo $condition; ?>" role="alert">
    <?php echo $fc_day; ?>
</div>