<?php
    // Current Conditions and Ten Day Forecast URLs
    $cc_url = "http://api.wunderground.com/api/963b29bf0454809e/conditions/q/WA/Spokane.json";
    $fc_url = "http://api.wunderground.com/api/963b29bf0454809e/forecast/q/WA/Spokane.json";
    $ten_url = "http://api.wunderground.com/api/963b29bf0454809e/forecast10day/q/WA/Spokane.json";

    $cc_json = file_get_contents($cc_url);
    $fc_json = file_get_contents($fc_url);
    $ten_json = file_get_contents($ten_url);

    $cc = json_decode($cc_json);
    $fc = json_decode($fc_json);
    $ten = json_decode($ten_json);

    // The Wunderground Logo url
    $img_url = $cc->{'current_observation'}->{'image'}->{'url'};

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

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="subject" content="weather forecast" />
        <meta name="author" content="Dennis Sauve, dengsauve@yahoo.com" />

        <title>bikercast</title>
        <meta name="description" content="Providing critical weather forecast information to determine if biking into work is a good idea." />
        <meta name="keywords" content="weather cycling forecast biking cyclist motorcycle" />
        
        <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css" />
    </head>

    <body>
        <div class="container">
            <div class="row">
                <section class="col-12">
                    <h1 class="display-4">bikercast</h1>
                    <p class="lead">
                        Providing critical weather forecast information to determine if biking into work is a good idea.
                    </p>
                    <div class="alert alert-<?php echo $condition; ?>" role="alert">
                        <?php echo $fc_day; ?>
                    </div>
                </section>
            </div>

            <div class="row">
                <div class="col-12">
                    <div id="line_chart" style="width: 100%; height: 50vh; min-height: 250px;"></div>
                </div>
                <a href="http://www.wunderground.com">
                    <img class="img-fluid" src="<?php echo $img_url; ?>" alt="Visit Weather Underground!" />
                </a>
            </div>

            <div class="row">
                <h2 class="col-12">
                    Ten Day Forecast
                </h2>
                <?php
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
                ?>
            </div>
        </div>

        <script type="text/javascript" src="/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="charts.js"></script>
        <script type="text/javascript" src="/node_modules/bootstrap/dist/bootstrap.js" ></script>
    </body>
</html>