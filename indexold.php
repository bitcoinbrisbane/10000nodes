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
        /* gets the data from a URL */
        function get_data($url) {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        require_once('easybitcoin.php');
        $bitcoin = new Bitcoin('bitcoinbrisbane','441f5cc0839c6aa669506c734b8d6cadf10db229','localhost','8332');

        $result = $bitcoin->getinfo();
        $current_block = get_data('https://blockchain.info/q/getblockcount');
        $node_blocks = $result['blocks']; #$bitcoin->getblockcount();
    ?>
    <!-- HEADER SECTION -->
    <div id="header-section" >
        <div class="container">
            <div class="text-center">
                <svg width="562" height="318">
                <line x1="50" y1="50" x2="200" y2="100" style="stroke:rgb(0,0,0);stroke-width:10" />
                <line x1="50" y1="200" x2="200" y2="100" style="stroke:rgb(0,0,0);stroke-width:10" />
                <line x1="200" y1="280" x2="200" y2="100" style="stroke:rgb(0,0,0);stroke-width:10" />
                <line x1="380" y1="100" x2="200" y2="100" style="stroke:rgb(0,0,0);stroke-width:10" />
                <line x1="380" y1="100" x2="530" y2="50" style="stroke:rgb(0,0,0);stroke-width:10" />
                <line x1="380" y1="100" x2="530" y2="200" style="stroke:rgb(0,0,0);stroke-width:10" />
                <line x1="380" y1="100" x2="380" y2="280" style="stroke:rgb(0,0,0);stroke-width:10" />
                <circle cx="50" cy="50" r="32" stroke="black" stroke-width="1" fill="black" />
                <circle cx="50" cy="50" r="26" stroke="black" stroke-width="1" fill="white" />
                <circle cx="50" cy="200" r="32" stroke="black" stroke-width="1" fill="black" />
                <circle cx="200" cy="100" r="32" stroke="black" stroke-width="1" fill="black" />
                <circle cx="200" cy="280" r="32" stroke="black" stroke-width="1" fill="black" />
                <circle cx="380" cy="100" r="32" stroke="black" stroke-width="1" fill="black" />
                <circle cx="380" cy="280" r="32" stroke="black" stroke-width="1" fill="black" />
                <circle cx="530" cy="50" r="32" stroke="black" stroke-width="1" fill="black" />
                <circle cx="530" cy="200" r="32" stroke="black" stroke-width="1" fill="black" />
                <circle cx="530" cy="200" r="26" stroke="black" stroke-width="1" fill="white" />
                   Sorry, your browser does not support inline SVG.
                </svg>
                <div class="row main-low-margin">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h2 class="head-line" >THE TEN THOUSAND NODES PROJECT</h2>
                        </div>
                    </div>
                </div>
                <p>
                    <?php
                        if ($current_block != $node_blocks)
                        {
                            echo "Block chain syncing... ";
                        }
                        else
                        {
                            echo "Block chain synced, ";
                        }

                        echo "block height $node_blocks / $current_block, ";
                        echo "current difficulty " .$result['difficulty'] .", ";
                        echo $result['connections'] ." connections to the network.";
                    ?>
                </p>
            </div>
        </div>
    </div>
    <!--END HEADER SECTION -->
    <div class="container">
        <div class="row main-low-margin text-center">
            <div class="col-md-4 col-sm-4" >
                <i class="glyphicon glyphicon-off fa-5x color-yellow"></i>
                <h3>ALWAYS ON</h3>
                <p>
                    0 dBA. No fans means no noise making it perfect to always leave the node running.
                </p>
            </div>               
                <div class="col-md-4 col-sm-4" >
                <i class="glyphicon glyphicon-cog fa-5x color-black"></i>
                <h3>NO CONFIGURATION</h3>
                <p>
                    The device is pre-configured and carries a copy of the entire block chain*..
                    Your device should only take a few minutes to sync instead of weeks.
                </p>
            </div>
            <div class="col-md-4 col-sm-4" >
                <i class="glyphicon glyphicon-flash fa-5x color-black"></i>
                <h3>LOW POWER</h3>
                <p>
                    The node uses a 5V ~2Amp power supply.
                    This means the device runs at 10W/hr or about 0.3 cents per hour.
                </p>
            </div>
        </div>
    </div>
    <!-- ABOUT SECTION -->
    <div id="about-section" class="section" >
        <div class="container" >
            <div class="row main-low-margin">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1" >
                    <h1>Abstract</h1>
            <p>From March 2014 to October 2014 there has been a decline in nodes from 10,000 to 7,000.  Full bitcoin nodes are critical to survival and success of bitcoin. We aim to reverse that trend in a simple and cost effective solution.</p>
            <h2>Project Goals</h2>
            <p>Our project has two goals.  1. to develop a low cost, low powered, always on hardware solution that will encourage users to always participate in a full bitcoin node.  The second is to reduce the barrier to entry for new bitcoin users.  Like today's internet routers abstract the user from how to connect to the internet,  we want to abstract users from the pain of running a full bitcoin wallet / node and provide a simple and user friendly bitcoin wallet.</p>
        <h2>Who are we?</h2>
        <p>Some bitcoin enthusiasts and software developers from Brisbane, Australia. We volunteer our time to run the local Bitcoin Brisbane meetup.  We have been involved in Bitcoin related projects since 2011.</p>
            <h2>The solution</h2>
            <p>Our product is a small 5V device that can always be left on. We hope that these boxes will make their way into users homes that would otherwise not run a full bitcoin node.<p>
            <h2>Not just a node, a wallet too!</h2>
            <p>Thats right, the device also is an open source wallet with a web interface that can be accessed from your local network.</p>
            <h2>Open</h2>
            <p>We will endeavour to choose open source projects and to contribute accordingly. Where possible, we will engage with business who support bitcoin. Our domain has been registered via NameCheap with BTC.</p>
            <h2>Other projects</h2>
            <p>We are by no means alone in this endavour and recongise the what others are doing to build the bitcoin commuity. Here are some other projects we support via donations.</p>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Url</th>
                    <th>Tips</th>
                </tr>
                <tr>
                    <td>
                        Rent a node
                    </td>
                    <td>
                        https://bitcointalk.org/index.php?topic=332679.0
                    </td> 
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        Provisioning Bitcoin Network Crawler
                    </td>
                    <td>
                        https://github.com/ayeowch/bitnodes/wiki/Provisioning-Bitcoin-Network-Crawler
                    </td> 
                    <td>
                        12Ew6bK3TjTyaeZicg4DGxM2k9JuJ9ng2c
                    </td>
                </tr>
                <tr>
                    <td>
                        Multisig address
                    </td>
                    <td>
                        http://coinb.in/multisig/
                    </td> 
                    <td>
                        145XMArsPcJYU3BPsXFX8Hd3WgDWoxCAFa
                    </td>
                </tr>
            </table>
            <p>A list of nodes can be found at <a href="https://getaddr.bitnodes.io">getaddr.bitnodes.io</a></p>
            <h2>DIY</h2>
            <p>If you would like to build the solution yourself that's great! We proivde comprehensive instructions for you to use and to peer review and provide feedback. All of the projects resources can be found in <a href="https://www.github.com/bitcoinbrisbane">GitHub</a>. If you would like to contribute then please make a pull request. Our tips for <a href="https://tip4commit.com/github/bitcoinbrisbane/website">commit programme address 1A2LcKTCLnrLfP8HFe6gHbA173VxAFJowC</a></p>
            <h2>Partners or supporters</h2>
            <p>Donations to <a href="bitcoin:1CHQ76iR3iudPzXGqAhcux1ucHTaHAfuef">1CHQ76iR3iudPzXGqAhcux1ucHTaHAfuef</a> are welcome (yes this is hosted on our own product). We will use donations to this address to tip and donate back to open source projects that we use.<p>
            <h2>Help & support</h2>
            <p>If you would like to dontate some "Lets talk Bitcoin" LTB coins so we can advertise on their programe, you can send them too this address.
            <p>Bitcointalk forum</p>
            </div>
        </div>
    </div>
    <!--PRICE SECTION -->
    <div id="price-section" class="section" >
        <div class="container" >
            <div class="row main-low-margin">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1" >
                    <h2>Products</h2>
                    <h5>
                       Our first product is a node + wallet + 32gb memory. That should last around 1 year with the current rate of block chain growth.
                    </h5>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">