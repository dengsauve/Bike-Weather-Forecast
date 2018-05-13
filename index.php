<?php require 'php/header.php'; ?>

    <body>
        <div class="container">
            <div class="row">
                <section class="col-12">
                    <h1 class="display-4">bikercast</h1>
                    <p class="lead">
                        Providing critical weather forecast information to determine if biking into work is a good idea.
                    </p>
                    <!-- Daily Conditions -->
                    <?php require 'php/forecast.php'; ?>
                </section>
            </div>

            <div class="row">
                <div class="col-12">
                    <div id="line_chart" style="width: 100%; height: 50vh; min-height: 250px;"></div>
                </div>
            </div>

            <div class="row">
                <h2 class="col-12">
                    Ten Day Forecast
                </h2>
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