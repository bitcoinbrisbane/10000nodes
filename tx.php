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
    <div class="cointainer">
        <?php
            require_once('easybitcoin.php');

            $password = $_SESSION["password"];
            $bitcoin = new Bitcoin('bitcoinbrisbane', $password, 'localhost','8332');
            $txn = $bitcoin->gettransaction($_GET["txid"]);
        ?>
        <div class="row">
			<!-- TXN SECTION -->
            <div class="cointainer">
                <div class = "panel-heading" style = "background-color: #6495ed;color: #fff;border-color: #ef7b35;">
                    Transaction
                </div>
                <table class="table">
                    <tr>
                        <th>Account</th>
                        <th>Balance</th>
                        <th></th>
                    </tr>
                    <?php
                        $accounts = $bitcoin->listaccounts();

                        foreach($details as $detail => $txn)
                        {
                            echo "<tr><td>$key</td><td>.$val</td><td>";
                            echo "<a href='account.php?account='.$key'>Details</a></td></tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">