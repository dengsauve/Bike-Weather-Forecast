<?php
    $cc_url = "http://api.wunderground.com/api/963b29bf0454809e/conditions/q/WA/Spokane.json";
    $hr_url = "http://api.wunderground.com/api/963b29bf0454809e/hourly/q/WA/Spokane.json";

    $ten_url = "http://api.wunderground.com/api/963b29bf0454809e/forecast10day/q/WA/Spokane.json";

    $cc_json = file_get_contents($cc_url);
    $hr_json = file_get_contents($hr_url);
    $ten_json = file_get_contents($ten_url);

    $cc = json_decode($cc_json);
    $hr = json_decode($hr_json);

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
                <div class="card" style="width: 9rem;">
                    <img 
                    class="card-img-top" 
                    src="<?php echo $cc->{'current_observation'}->{'image'}->{'url'}; ?>" 
                    alt="Card image cap">
                    <div class="card-body">
                        <a href="http://www.wunderground.com" class="card-icon">Visit Weather Underground</a>
                    </div>
                </div>
            </div>

            <br/>

            <h2>
                Ten Day Forecast
            </h2>

            <div class="row">
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

            <h2>Hourly Forecast</h2>

            <div class="row">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">
                                Date and Time
                            </th>
                            <th scope="col">
                                Temperature
                            </th>
                            <th>
                                Wind Speed
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Here is where we'll breakout the hr data.
                            $hourly_forecast = $hr->{'hourly_forecast'};

                            foreach($hourly_forecast as $forecast_hour)
                            {
                                // Date Time
                                echo "<tr>";
                                echo "<th scope='row'>" . $forecast_hour->{'FCTTIME'}->{'pretty'} . "</th>";

                                // Temperature
                                echo "<th scope='row'>" . $forecast_hour->{'temp'}->{'english'} . " &deg;F</th>";

                                // Wind Speed
                                echo "<th scope='row'>" . $forecast_hour->{'wspd'}->{'english'} . " MPH</th>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div id="chart_div" style="width: 100%;"></div>
            </div>

        </div>

        <script type="text/javascript" src="/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="/node_modules/bootstrap/dist/bootstrap.js" ></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="/charts.js"></script>
    </body>
</html>