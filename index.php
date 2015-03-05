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
        <!-- Original bootstrap theme http://www.bootstrapstage.com/binary-parallax/ -->
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
            $error = $result['error'];
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
                            echo $error['message'];
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
         <!--PARALLAX SECTION ONE-->
        <section id="story-freext">
            <article>
               <h2><i class="glyphicon glyphicon-signal"></i> Problem</h2>
               <span>
                    From March 2014 to March 2015 there has been a decline in full nodes from 10,000 to less than 7,000. Full bitcoin nodes are critical to security and success of bitcoin.  The more full copies of the block chain there are in existance, the harder the network is to shut down, and the more reliable bitcoin becomes.
                </span>
            </article>
            <div class="parallax" data-velocity="-.3" ></div>
        </section>
        <!-- END PARALLAX SECTION ONE -->
        <!--END HEADER SECTION -->
        <div class="container">
            <div class="row main-low-margin text-center">
                <div class="col-md-4 col-sm-4" >
                    <i class="glyphicon glyphicon-off fa-5x color-yellow"></i>
                    <h3>ALWAYS ON</h3>
                    <p>
                        Our device is a 0 dBA solution. No fans means no noise, making it perfect to always leave the node running.
                    </p>
                </div>               
                    <div class="col-md-4 col-sm-4" >
                    <i class="glyphicon glyphicon-cog fa-5x color-black"></i>
                    <h3>PRE CONFIGURED</h3>
                    <p>
                        The device is pre-configured and carries a recent copy of the entire block chain*
                        Your device will only take a few minutes to sync instead of weeks.
                    </p>
                </div>
                <div class="col-md-4 col-sm-4" >
                    <i class="glyphicon glyphicon-flash fa-5x color-black"></i>
                    <h3>LOW POWER</h3>
                    <p>
                        The nodes power consumption is very low.  It uses a 5V ~2A power supply which works out to 10W/hr a few cents a day.
                    </p>
                </div>
            </div>
        </div>
        <!--PARALLAX SECTION TWO -->
        <section id="story-two">
            <article>
                <span>
                <h3>Goal</h3>
                <span>We aim to reverse that trend by providing a simple and cost effective solution.</span>
                </br>
                <ol>
                    <li>To supply a low cost and cheap to run hardware solution that will encourage users to always participate as a full bitcoin node.</li>
                    <li>To provide a simple and safe bitcoin wallet that mitigates risks associated with running a desktop wallet.</li>
                </ol>
                </br>
                <h3>Partners and supporters</h3>
                <span>We are always looking for people to assist in the project.  Donations to <a href="bitcoin:39rbPdUeCQCsFKhz8kRgD7Uo4e8uWDxAU8">39rbPdUeCQCsFKhz8kRgD7Uo4e8uWDxAU8</a> are welcome (yes this is hosted on our own product). We will use donations to this address to tip and donate back to open source projects that we use.  If you would like to dontate some "Lets talk Bitcoin" LTB coins so we can advertise on their programe, you can send them to this address.</span>
            </article>
            <div class="parallax" data-velocity="-.1"></div>
            <div class="parallax" data-velocity="-.5" data-fit="125"></div>
        </section>
        <!--END PARALLAX SECTION TWO -->
        <!--PRICE SECTION -->
        <div class="container" id="pricing-section" >         
            <div class="main-low-margin col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 margin-top-100 ">
                <div id="pricing-table" class="row">
                    <div class="col-md-4 col-sm-4">
                        <ul class="plan-main">
                            <li class="plan-name">Starter</li>
                            <li class="plan-price">$ 100</li>
                            <li>64GB Storage</li>
                            <li class="plan-action"><a href="#" class="btn btn-primary btn-lg">Buy!</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-sm-4" >
                        <ul class="plan-main featured active">
                            <li class="plan-name">Enthusisast</li>
                            <li class="plan-price">$140</li>
                            <li>128GB Storage</li>
                            <li class="plan-action"><a href="#" class="btn btn-primary btn-lg">Buy!</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <ul class="plan-main">
                            <li class="plan-name">Pro</li>
                            <li class="plan-price">$200</li>
                            <li>128GB Storage</li>
                            <li>Hardware RNG</li>
                            <li class="plan-action"><a href="#" class="btn btn-primary btn-lg">Coming soon</a></li>
                        </ul>
                    </div>
                </div>
            </div>
             <!-- ./ Row Content-->
        </div>
    <div class="space-bottom"></div>
    <!--END PRICE SECTION -->
</body>
</html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
