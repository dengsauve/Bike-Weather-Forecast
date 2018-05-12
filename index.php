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
        <title>bikercast</title>
        <meta name="description" content="Providing critical weather forecast information to determine if biking into work is a good idea." />
        
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css" />
    </head>
    <body>
        <div class="container">

            <h1 class="display-4">bikercast</h1>

            <p class="lead">
                Providing critical weather forecast information to determine if biking into work is a good idea.
            </p>

            <div class="row">
                <div class="col-12">
                    <div id="line_chart" style="width: 100%; height: 50vh; min-height: 250px;"></div>
                </div>
                <a href="http://www.wunderground.com">
                                <img class="img-fluid" 
                                src="<?php echo $cc->{'current_observation'}->{'image'}->{'url'}; ?>" 
                                alt="Visit Weather Underground!" />
                </a>
            </div>

            <br/>

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
                                    hours: {format: ['HH:mm a', 'ha']}
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
                        },
                        'title':'36 Hour Forecast',
                        titleTextStyle: {
                            color: "#212529",
                            fontSize: 38,
                            fontName: 'Arial',
                            bold: false
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