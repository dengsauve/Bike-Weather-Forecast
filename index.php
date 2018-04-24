<?php
    $cc_url = "http://api.wunderground.com/api/963b29bf0454809e/conditions/q/WA/Spokane.json";
    $ten_url = "http://api.wunderground.com/api/963b29bf0454809e/forecast10day/q/WA/Spokane.json";

    $cc_json = file_get_contents($cc_url);
    $ten_json = file_get_contents($ten_url);

    $cc = json_decode($cc_json);
    $ten = json_decode($ten_json);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bikercast</title>

        <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css" />

    </head>
    <body>
        <div class="container">

        <h1>Hello User</h1>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <img class="img-thumbnail" src="<?php echo $cc->{'current_observation'}->{'icon_url'};?>" alt="Card image cap">
                    <h5 class="card-title">Right Now</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Temperature: <?php echo $cc->{'current_observation'}->{'temp_f'}; ?>
                        <br/>
                        Windspeed: <?php echo $cc->{'current_observation'}->{'wind_mph'} ?>
                    </h6>
                    <p class="card-text">
                        Conditions: <?php echo $cc->{'current_observation'}->{'weather'} ?>
                    </p>
                    <a class="btn btn-primary" href="<?php echo $cc->{'current_observation'}->{'forecast_url'};?>">Forecast</a>
                </div>
            </div>
        </div>

        <br/>

        <div class="row">
            <div class="card col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>

            <?php
                $days = $ten->{'forecast'}->{'txt_forecast'}->{'forecastday'};

                foreach($days as $day)
                {
                    echo '<div class="card col-xs-12 col-sm-6 col-md-4 col-lg-3">';
                    echo '  <div class="card-body">';
                    echo "      <h5 class='card-title'>" . $day->{'title'} . "</h5>";
                    echo '      <p class="card-text">' . $day->{'fcttext'} . "</p>";
                    echo '  </div>';
                    echo '</div>';
                }
            ?>
        </div>

        <br/>


        <div class="card" style="width: 9rem;">
            <img 
            class="card-img-top" 
            src="<?php echo $cc->{'current_observation'}->{'image'}->{'url'}; ?>" 
            alt="Card image cap">
            <div class="card-body">
                <a href="http://www.wunderground.com" class="card-icon">Visit Weather Underground</a>
            </div>
        </div>
            

        <script type="text/javascript" src="/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="/node_modules/bootstrap/dist/bootstrap.js" ></script>
    </body>
</html>