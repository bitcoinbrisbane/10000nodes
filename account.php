<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Ten Thousand Bitcoin Nodes Project</title>
        <!--GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <!--BOOTSTRAP MAIN STYLES -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!--FONTAWESOME MAIN STYLE -->
        <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
        <!--CUSTOM STYLE -->
        <link href="assets/css/style.css" rel="stylesheet" />
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="assets/js/jquery-2.1.1.min.js"></script>
    </head>
<body>
    <?php
        require_once('easybitcoin.php');
        $bitcoin = new Bitcoin('bitcoinbrisbane','Dugong','localhost','8332');
    ?>
    <!-- HEADER SECTION -->
    <div id="header-section" >
        <div class="container">
        </div>
    </div>
    <!--END HEADER SECTION -->
    <div class="container">
        <div class="row main-low-margin">
            <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                <h2></h2>
                <h3>
                    <?php print("Total received " .$bitcoin->getaccountbalance(htmlspecialchars($_GET["account"]))); ?>
                </h3>
            </div>
        </div>
        <!-- ABOUT SECTION -->
        <table class="table">
            <tr>
                <th>Txn</th>
                <td>Date</td>
                <th>Amount</th>
            </tr>
            <tr>
                <td></td>
                <td>29-04-2014</td>
                <td>0.1337</td>
            </tr>
        </table>
    </div>
    <div class="cointainer">
        <button type="button" class="btn btn-default">Home</button>
    </div>
</body>
</html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">