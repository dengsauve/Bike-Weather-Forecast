<?php require 'php/header.php'; ?>

    <body>
        <div class="container">
            <div class="row">
                <section class="col-12">
                    <h1 class="display-4 d-inline">bikercast</h1>
                    <p class="lead">
                        Providing critical weather forecast information to determine if biking into work is a good idea.
                    </p>
                    <!-- Daily Conditions -->
                    <?php require 'php/forecast.php'; ?>
                    <p class="text-muted">
                        Not Spokane, WA? Change your location.
                    </p>
                </section>
            </div>

            <div class="row">
                <div class="col-12">
                    <div id="line_chart" class="shadow-sm"></div>
                </div>
            </div>

            <div class="row">
                <section class="col-12">
                    <h2>
                        Ten Day Forecast
                    </h2>
                </section>
                <?php require 'php/ten.php'; ?>
            </div>
        </div>

        <br/>
        
        <!-- Footer -->
        <?php require 'php/footer.php'; ?>

        <script type="text/javascript" src="/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="charts.js"></script>
        <script type="text/javascript" src="/node_modules/bootstrap/dist/js/bootstrap.js" ></script>
    </body>
</html>