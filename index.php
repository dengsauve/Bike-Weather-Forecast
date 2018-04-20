<?php
    $cc_url = "http://api.wunderground.com/api/963b29bf0454809e/conditions/q/WA/Spokane.json";

    $cc_json = file_get_contents($cc_url);
    $cc = json_decode($cc_json);
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

        <h2>
            Current Temperature Today:
            <small>
                <?php echo $cc->{'current_observation'}->{'temp_f'}; ?>
            </small>
        </h2>

        <div class="card" style="width: 18rem;">
            <img 
            class="card-img-top" 
            src="<?php echo $cc->{'current_observation'}->{'image'}->{'url'}; ?>" 
            alt="Card image cap">
            <div class="card-body">
                <a href="http://www.wunderground.com" class="btn btn-primary">Visit Weather Underground</a>
            </div>
        </div>
            

        <script type="text/javascript" src="/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="/node_modules/bootstrap/dist/bootstrap.js" ></script>
    </body>
</html>