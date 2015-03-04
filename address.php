<!DOCTYPE html>
<?php
    // Start the session
    session_start();
?>
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
        $password = $_SESSION["password"]
        $bitcoin = new Bitcoin('bitcoinbrisbane', $password, 'localhost','8332');
    ?>
    <div class="container">
        <div class="row main-low-margin">
            <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                <h3><?php print("Total received " .$bitcoin->getbalance(htmlspecialchars($_GET["address"]))); ?></h3>
            </div>
        </div>
        <div class="row main-low-margin">
            <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                <p>
                    <?php .$bitcoin->validateaddress(htmlspecialchars($_GET["address"])); ?></p>
            </div>
        </div>
        <table class="table">
			<tr>
				<th>Address</th>
				<th>Amount</th>
				<th>Confirmations</th>
			</tr
		<?php
			$txns = $bitcoin->listtransactions(htmlspecialchars($_GET["address"]));

			foreach($txns as $key => $val)
			{
				echo "<tr><td>";
				echo $key;
				echo "</td><td>";
				echo $val ." BTC";
				echo "</td><td>";
				echo "<a href='account.php?account='" .$key ."'>Details</a></td>";
				echo "</tr>";
			}
		?>
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