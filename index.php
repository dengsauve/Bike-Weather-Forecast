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

            <div class="row">
                <div class="col-12">
                    <h2>Hourly Forecast Chart</h2>
                    <div id="line_chart" style="width: 100%; height: 50vh; min-height: 250px;"></div>
                </div>
            </div>

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

            <div class="row">
                <h2>Hourly Forecast for Spokane, WA</h2>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>
                                Date and Time
                            </th>
                            <th>
                                Temperature
                            </th>
                            <th>
                                Possible Precip
                            </th>
                            <th>
                                Wind Speed
                            </th>
                            <th>
                                Wind Direction
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Here is where we'll breakout the hr data.
                            $hourly_forecast = $hr->{'hourly_forecast'};

                            foreach($hourly_forecast as $forecast_hour)
                            {
                                echo "<tr>";

                                // Date Time
                                echo "<td scope='row'>" . $forecast_hour->{'FCTTIME'}->{'pretty'} . "</td>";

                                // Temperature
                                echo "<td>" . $forecast_hour->{'temp'}->{'english'} . " &deg;F</td>";

                                // Possibility of Precipitation (PoP)
                                echo "<td>" . $forecast_hour->{'pop'} . "%</td>";

                                // Wind Speed
                                echo "<td>" . $forecast_hour->{'wspd'}->{'english'} . " MPH</td>";

                                // Wind Direction
                                echo "<td>" . $forecast_hour->{'wdir'}->{'dir'} . "</td>";

                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                // Loads core lib + lib for line chart
                google.charts.load('current', {packages: ['corechart', 'line']});

                // Creates call once load is complete to do drawBasic()
                google.charts.setOnLoadCallback(drawBasic);

                // Actual function creating the line chart
                function drawBasic() {

                    // Initialize the data object
                    var data = new google.visualization.DataTable();
                    data.addColumn('datetime', 'Time of Day');
                    data.addColumn('number', 'Temperature');
                    data.addColumn('number', 'Windspeed');
                    data.addColumn('number', 'Precipitation Possibility');

                    data.addRows([
                        <?php
                            $hourly_forecast = $hr->{'hourly_forecast'};

                            foreach($hourly_forecast as $key => $forecast_hour)
                            {
                                $k = date("Y-m-d H:i:s", strtotime("+{$key}hours"));
                                
                                $tStr = substr($k, 0,4) . ", "
                                . substr($k, 5,2) . ", "
                                . substr($k, 8,2) . ", "
                                . substr($k, 11,2) . ", " 
                                . substr($k, 14,2);

                                echo "["
                                .  "new Date($tStr)"
                                . ", " 
                                . $forecast_hour->{'temp'}->{'english'} . ", "
                                . $forecast_hour->{'wspd'}->{'english'} . ", "
                                . $forecast_hour->{'pop'} . "], ";
                            }
                        ?>
                    ]);

                    var options = {
                        hAxis: {
                        title: 'Time of Day',
                        gridlines: {
                            count: -1,
                            units: {
                                days: {format: ['MMM dd']},
                                hours: {format: ['HH:mm', 'ha']}
                            }
                        },
                        minorGridlines: {
                            units: {
                                hours: {format: ['hh:mm:ss a', 'ha']},
                                minutes: {format: ['HH:mm a Z', ':mm']}
                            }
                        }
                        },
                        vAxis: {
                        title: 'Temperature, Wind, PoP'
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

                    chart.draw(data, options);
                }
            </script>

        </div>

        <script type="text/javascript" src="/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="/node_modules/bootstrap/dist/bootstrap.js" ></script>
    </body>
</html>