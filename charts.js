// Loads core lib + lib for line chart
google.charts.load('current', {packages: ['corechart', 'line']});

// Creates call once load is complete to do drawBasic()
google.charts.setOnLoadCallback(drawBasic);

// Actual function creating the line chart
function drawBasic() {

    // Will eventually need to be dynamic based on user location or input.
    $hr_url = "http://api.wunderground.com/api/963b29bf0454809e/hourly/q/WA/Spokane.json";

    // Initialize the data object
    var data = new google.visualization.DataTable();
    data.addColumn('datetime', 'Time of Day');
    data.addColumn('number', 'Temperature');
    data.addColumn('number', 'Windspeed');
    data.addColumn('number', 'Precipitation Possibility');

    // Initialize chart options variable
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

    var today = new Date();
    var arraysIn = [];
    
    $.getJSON($hr_url, function(json_data) {
        json_data.hourly_forecast.forEach(function(hour){
            console.log([today, parseInt(hour.temp.english), parseInt(hour.wspd.english), parseInt(hour.pop)]);
            arraysIn.push([new Date(today), parseInt(hour.temp.english), parseInt(hour.wspd.english), parseInt(hour.pop)]);
            today.setHours(today.getHours() + 1);
        });
    }).done(function(){
        data.addRows(arraysIn);
        var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
        chart.draw(data, options);
    });
}