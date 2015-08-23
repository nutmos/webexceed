<?php 
    include 'libaweb/dblib.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alcohol Detector</title>
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.css">
</head>
<style>
.row{
    margin-top: 30px;
    margin-bottom: 30px
}
</style>
<body>
    <div class="container">
       <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="car.html">Alcohol Detector<span class="sr-only">(current)</span></a></li>
        <li><a href="settings.html">Settings</a></li>
      </ul>
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
        <div class="row">
            <div style="font-size: 30px; font-family: Helvetica Neue" class="text-center">The Alcohol Detector</div>
        </div>
        <div class="row">
            <div class="col-md-2 col-lg-2 col-xs-0 col-sm-0"></div>
            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            Your Alcohol Rate
                        </div>
                    </div>
                    <div class="panel-body text-center">
                        <div style="font-size: 50px" id="alc-rate">
                            50
                        </div>
                        <div style="font-size: 20px">
                        mg%
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6 text-center">
                    <button class="btn btn-success" id="buzzer-btn">Buzzer</button>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6 text-center">
                    <button class="btn btn-danger" id="emer-btn">Emergency</button>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-6">
                <div class="row text-center"><div style="font-size: 40px;">History</div></div>
                <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">Timestamp</div>
                <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">Alcohol Rate</div>
                
                <?php

                    $dbContoller = new DbContoller();

                    if(!$dbContoller->isConn){
                        echo "connect is fail!";
                    }
                    else{
                        $returned_log = $dbContoller->database->query("SELECT * FROM exeed12_log");
                        if($returned_log->num_rows > 0){
                            while($row = $returned_log->fetch_assoc()) {
                                echo "<div class=\"col-md-6 col-lg-6 col-xs-6 col-sm-6\">" . $row['date'] . "</div>" .
                                "<div class=\"col-md-6 col-lg-6 col-xs-6 col-sm-6\">" . $row['alcohol'] . "</div>";
                            }
                            $dbContoller->dbClose();
                        }
                    }
                ?>

            </div>
            <div class="col-md-2 col-lg-2 col-xs-0 col-sm-0"></div>
        </div>
    </div>
</body>
<script src="jquery-2.1.4.min.js"></script>
<script>
var alcRate = $("#alc-rate");
var buzzerBtn = $("#buzzer-btn");
var emerBtn = $("#emer-btn");
function emerPressed() {
    $.post("http://exceed.cupco.de/iot/ohzeed/emer-buzzer", {data: "E"});
}
function buzzerPressed() {
    $.post("http://exceed.cupco.de/iot/ohzeed/emer-buzzer", {data: "B"});
}
function refreshData() {
    $.get("http://exceed.cupco.de/iot/ohzeed/board", processData);
}
function processData(data) {
    alcRate.text(data);
}
function postToFacebook() {
    //$.post("http://graph.facebook.com/v2.4/me/feed/HTTP/1.1", {"message": "test"});
}
postToFacebook();
setInterval(refreshData, 5000);
emerBtn.click(emerPressed);
buzzerBtn.click(buzzerPressed);
</script>
</html>