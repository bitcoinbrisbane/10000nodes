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
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/bitcoinjs-min.js"></script>
    </head>
<body>
	<!-- MENU -->
	<nav class="navbar navbar-default" role="navigation">
	   <div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" 
			 data-target="#example-navbar-collapse">
			 <span class="sr-only">Toggle navigation</span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="index.php">10,000</a>
	   </div>
	   <div class="collapse navbar-collapse" id="example-navbar-collapse">
		  <ul class="nav navbar-nav">
            <li><a href="wallet.php">Home</a></li>
            <li><a href="#addresses">Addresses</a></li>
            <li><a href="#txns">Transactions</a></li>
            <li><a href="login.php">Logout</a></li>
		  </ul>
	   </div>
	</nav>
	<!-- END MENU -->
    
    <div class="container">
        <?php
            require_once('easybitcoin.php');
        
            $password = "";

            if (empty($_POST["password"]))
            {
                $password = $_SESSION["password"];
            }
            else
            {
                $password = hash('ripemd160', $_POST["password"]);
                $_SESSION["password"] = $password;
            }
                
            $bitcoin = new Bitcoin('bitcoinbrisbane', $password, 'localhost', '8332');

            try
            {
                switch ($_GET["command"])
                {
                    case "createaddress":
                        $label = $_POST["label"];
                        $address = $bitcoin->getnewaddress($label);
                        echo "<div class='container'><div class='alert alert-success' role='alert'>Address $address created</div></div>";
                        break;
                    case "send":
                        $to = $_POST["to"];
                        $amount = $_POST["amount"];
                        $txn = $bitcoin->sendtoaddress($to, (float)$amount);
                        echo "<div class='container'><div class='alert alert-success' role='alert'>Sent $txn</div></div>";
                        //echo $bitcoin->error;
                        break;
                }
            }
            catch (Exception $e) 
            {
                echo "<div class='container'><div class='alert alert-danger' role='alert'>" .$e->getMessage() ."</div></div>";
            }

            $result = $bitcoin->getinfo();
        ?>
        
        <h2><strong>Available funds: <?php echo($result['balance']) ?>BTC</strong></h2>
        <br/>
		<button type="submit" class="btn btn-primary" data-toggle="modal" data-target=".modal-createaddress">Add address</button>
		<button type="submit" class="btn btn-primary" data-toggle="modal" data-target=".modal-send">Send</button>
        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target=".modal-backup">Backup</button>
        <br/>
        <hr/>
    </div>
    
    <!-- ADDRESSES SECTION -->
    <section id="addresses">
        <div class="container">
            <div class="panel-heading" style="background-color: #6495ed;color: #fff;">
                Addresses
            </div>
            <table class="table">
                <tr>
                    <th>Account</th>
                    <th>Address</th>
                    <th>Balance</th>
                </tr>
                <?php
                    $accounts = $bitcoin->listaccounts();

                    foreach($accounts as $key => $val)
                    {
                        $address = $bitcoin->getaccountaddress($key);
                        echo "<tr><td>$key</td><td><a href='account.php?account=$key'>$address</a></td><td>$val</td><td></tr>";
                    }
                ?>
            </table>
        </div>
    </section>
    
    <hr/>
    
    <!-- TRANSACTIONS SECTION -->
    <section id="txns">
        <div class="container">
            <div class="panel-heading" style="background-color: #6495ed;color: #fff;">
                Transactions
            </div>
            <table class="table">
                <tr>
                    <th>Date</th>
                    <th>Address</th>
                    <th>Amount</th>
                    <th>ID</th>
                    <th>Confirmations</th>
                </tr>
                <?php
                    $txns = $bitcoin->listtransactions();

                    #foreach($txns as $item) 
                    #{ 
                    #    $epoch = $item['time'];
                    #    $dt = new DateTime("@$epoch"); // convert UNIX timestamp to PHP DateTime
                        //echo $dt->format('Y-m-d H:i:s'); // output = 2012-08-15 00:00:00 
                    #    echo "<tr><td>" .$dt->format('Y-m-d H:i:s') ."</td><td>" .$item['address'] ."</td><td>" .$item['amount'] ."</td><td>" .$item['txid'] ."</td><td>" .$item['confirmations'] ."</td></tr>";
                    #}
                ?>
            </table>
        </div>
    </section>
    
    <!-- CREATE ADDRESS MODAL -->
	<div class="modal fade modal-createaddress" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-createaddress">
		<div class="modal-content">
		  <div class="panel-heading" style="background-color: #6495ed;color: #fff;">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				Create a new btc address
			</div>
			<div class="panel-body">
				<form action="wallet.php?command=createaddress" method="post">
					<div class="form-group">
						<label>Label</label>
						<input type="text" id="label" name="label" class="form-control"/>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	  </div>
	</div>
	
	<!-- SEND MODAL -->
	<div class="modal fade modal-send" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-send">
		<div class="modal-content">
		  <div class="panel-heading" style="background-color: #6495ed;color: #fff;">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				Create a new btc address
		  </div>
		  <div class="panel-body">
			<div class="alert alert-danger" role="alert">Make sure the address is correct!</div>
			<form action="wallet.php?command=send" method="post">
				<div class="form-group">
					<label>Amount</label>
					<div class="input-group">
						<input type="text" id="Amount" name="amount" class="form-control"/>
						<span class="input-group-addon">BTC</span>
					</div>
				</div>
				<div class="form-group">
					<label>BTC payment address</label>
					<input type="text" id="to" name="to" data-bv-regexp-regexp="^[a-zA-Z0-9_\.]+$" class="form-control"/>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-warning">Send</button>
				</div>
			</form>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript"> $(document).ready(function() {
	var uid = "1";
	var apikey = "12345678901234567890123456789012";

	function genentropy(){
		entropy = random();
		$(document).mousemove(function(e){
			entropy += random(10)+''+(Math.random()*100)+' '+''+e.pageX+''+e.pageY;
			entropy = entropy.substr(1,2048);
		});
	}

	function random(length) {
		var r = "";
		var l = length || 25;
		var chars = "!$%^&*()_+{}:@~?><|\./;'#][=-abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		for(x=0;x<l;x++) {
			r += chars.charAt(Math.floor(Math.random() * 62));
		}
		return r;
	}

	function multiSig(rs){
		var x = Crypto.RIPEMD160(Crypto.SHA256(rs.buffer,{asBytes: true}),{asBytes: true});
		x.unshift(0x05);
		var r = x;
		r = Crypto.SHA256(Crypto.SHA256(r,{asBytes: true}),{asBytes: true});
		var checksum = r.slice(0,4);
		var redeemScript = Crypto.util.bytesToHex(rs.buffer);
		var address = Bitcoin.Base58.encode(x.concat(checksum));
		return {'address':address,'redeemScript':redeemScript};
	}

	function pubkey2address(h,v){
		var x = h;
		x.unshift(v||0x00);
		var r = x;
		r = Crypto.SHA256(Crypto.SHA256(r,{asBytes: true}),{asBytes: true});
		var checksum = r.slice(0,4);
		var address = Bitcoin.Base58.encode(x.concat(checksum));
		return address;
	}

	function validateOutputAmount(){
		$("#recipients .amount").unbind('');
		$("#recipients .amount").keyup(function(){
			if(isNaN($(this).val())){
				$(this).parent().addClass('has-error');
			} else {
				$(this).parent().removeClass('has-error');
				var f = 0;
				$.each($("#recipients .amount"),function(i,o){
					if(!isNaN($(o).val())){
						f += $(o).val()*1;
					}
				});
				$("#totalOutput").html((f).toFixed(8));
			}
			totalFee();
		});
	}

	function totalFee(){
		var fee = (($("#totalInput").html()*1) - ($("#totalOutput").html()*1)).toFixed(8);
		$("#transactionFee").val((fee>0)?fee:'0.00');
	}

	function totalInputAmount(){
		$("#totalInput").html('0.00');
		$.each($("#inputs .txIdAmount"), function(i,o){
			if(isNaN($(o).val())){
				$(o).parent().addClass('has-error');
			} else {
				$(o).parent().removeClass('has-error');
				var f = 0;
				if(!isNaN($(o).val())){
					f += $(o).val()*1;
				}
				$("#totalInput").html((($("#totalInput").html()*1) + (f*1)).toFixed(8));
			}
		});
		totalFee();
	}

	function validateAddress(){
		$("#recipients .address").unbind('');
		$("#recipients .address").keyup(function(){
			var check = parseBase58Check($(this).val());
			if(check['result']==0){
				$(this).parent().addClass('has-error');
			} else {
				$(this).parent().removeClass('has-error');
			}
		});
	}

	function decodeTransactionScript(){
		var result = false;
		try {
			var deserialized = Bitcoin.Transaction.deserialize($("#verifyTransaction").val().toLowerCase());
			$("#verifyTxData .outputs tbody").html("");
			var html = '';
			$.each(deserialized.outs, function(i,o){
				var addr = '';
				if(o.script.chunks.length==5){
					addr = pubkey2address(o.script.chunks[2]);
				} else {
					addr = pubkey2address(o.script.chunks[1],0x05);
				}
				html += '<tr>';
				html += '<td>'+(i+1)+'</td>';
				html += '<td><a href="http://www.blockchain.info/address/'+addr+'" target="_blank">'+addr+'</a></td>';
				html += '<td>'+(parseFloat(Bitcoin.Util.formatValue(o.value.reverse()))).toFixed(8)+'</td>';
				html += '</tr>';
			});

			$(html).appendTo("#verifyTxData .outputs tbody");

			html = '';
			$("#verifyTxData .inputs tbody").html("");
			$.each(deserialized.ins, function(i,o){
				var txid = (Crypto.util.bytesToHex(Crypto.util.base64ToBytes(o.outpoint.hash))).match(/.{1,2}/g).reverse().join("");
				var rs = 0;

				if(o.script.chunks[o.script.chunks.length-1]==174){
					rs = (Crypto.util.bytesToHex((o.script.buffer))).match(/.{1,2}/g);
				} else if(o.script.chunks.length>=2){
					rs = (Crypto.util.bytesToHex((o.script.chunks[o.script.chunks.length-1]))).match(/.{1,2}/g);
				}

				var rsfirst = rs[0];
				var rslast = rs[rs.length-1];

				var hasRs = ((rs && rslast=='ae') ? true : false);
				html += '<tr>';
				html += '<td>'+(i+1)+'</td>';
				html += '<td><a href="http://www.blockchain.info/tx/'+txid+'" target="_blank">'+txid+'</a><span class="text-muted">:'+o.outpoint.index+'</span></td>';
				html += '<td><span class="glyphicon '+((hasRs==true) ? 'glyphicon-ok-circle' : 'glyphicon-remove-circle')+'"></span></td>';
				html += '<td>'+((hasRs)==true?parseInt(rsfirst,16)-80:'0')+'</td>';
				html += '<td>'+(((hasRs==true) && o.script.chunks[o.script.chunks.length-1]!=174)?o.script.chunks.length-2:'0')+'</td>';
				html += '</tr>';
			});
			$(html).appendTo("#verifyTxData .inputs tbody");

			$("#verifyTxData").removeClass('hidden');
			result = true;
		} catch(e) {
			// console.log(e);
			result = false;
		}

		return result;
	}

	function decodeRedeemScript(){
		var result = false;
		try {
			var deserialized = new Bitcoin.Script(Crypto.util.hexToBytes($("#verifyTransaction").val().toLowerCase()));
			var releaseNo = '?';
			var signatureNo = '?'
			var multisigaddress = multiSig({'buffer':Crypto.util.hexToBytes($("#verifyTransaction").val())});
			if((deserialized.chunks.length>=3) && deserialized.chunks[deserialized.chunks.length-1] == 174){
				signaturesRequired = deserialized.chunks[0]-80;
				signatureNo = deserialized.chunks[deserialized.chunks.length-2]-80;
				$("#verifyRsData .signaturesRequired").html(signaturesRequired);
				$("#verifyRsData .address").val(multisigaddress['address']);
				$("#verifyRsData table tbody").html("");
				for(var i=1;i<deserialized.chunks.length-2;i++){
					$('<tr><td><input type="text" class="form-control" value="'+Crypto.util.bytesToHex(deserialized.chunks[i])+'" readonly></td></tr>').appendTo("#verifyRsData table tbody");
				}
				$("#verifyRsData").removeClass('hidden');
				result = true;
			}
		} catch(e) {
			// console.log(e);
			result = false;
		}

		return result;
	}

	function scriptListPubkey(redeemScript){
		var r = {};
		for(var i=1;i<redeemScript.chunks.length-2;i++){
			r[i] = redeemScript.chunks[i];
		}
		return r;
	}

	function scriptListSigs(scriptSig){
		var r = {};
		if (scriptSig.chunks[0]==0 && scriptSig.chunks[scriptSig.chunks.length-1][scriptSig.chunks[scriptSig.chunks.length-1].length-1]==174){
			for(var i=1;i<scriptSig.chunks.length-1;i++){				
				r[i] = scriptSig.chunks[i];
			}
		}
		return r;
	}

	function countObject(obj){
		var count = 0;
		var i;
		for (i in obj) {
			if (obj.hasOwnProperty(i)) {
				count++;
			}
		}
		return count;
	}

	$("#agentUse").click(function(){
		var count = 0;
		var len = $(".addressRemove").length;
		if(len<19){
			$.each($("#uncompressedPubKeys .pubkey"),function(i,o){
				if($(o).val()==''){
					$(o).val($("#agentPubkey").val()).fadeOut().fadeIn();
					$("#agentClose").click();
					return false;
				} else if(count==len){
					$(".addressAdd").click();
					$("#agentUse").click();
				}
				count++;
			});
		}		
	});

	$("#createMultiSigAddress").click(function(){
		var pubkeys = [];
		var curve = getSECCurveByName("secp256k1");
		var pt = false;

		$("#multiSigData").removeClass('show').addClass('hidden').fadeOut();
		$("#uncompressedPubKeys .pubkey").parent().removeClass('has-error');
		$("#releaseCoins").parent().removeClass('has-error');
		$("#multiSigErrorMsg").hide();

		if((isNaN($("#releaseCoins option:selected").html())) || ((!isNaN($("#releaseCoins option:selected").html())) && ($("#releaseCoins option:selected").html()>$("#uncompressedPubKeys .pubkey").length || $("#releaseCoins option:selected").html()*1<=0 || $("#releaseCoins option:selected").html()*1>20))){
			$("#releaseCoins").parent().addClass('has-error');
			$("#multiSigErrorMsg").html("Minimum signatures required is invalid").fadeIn();
		}

		$.each($("#uncompressedPubKeys .pubkey"),function(i,o){
			pt = ECPointFp.decodeFrom(curve.getCurve(), Crypto.util.hexToBytes($(o).val()));
			if(pt.isOnCurve()){
				pubkeys.push(Crypto.util.hexToBytes($(o).val()));
			} else {
				$(o).parent().addClass('has-error');
				$("#multiSigErrorMsg").html("One or more pubkey is invalid or missing").fadeIn();
			}
		});

		if(($("#uncompressedPubKeys .pubkey").parent().hasClass('has-error')==false) && $("#releaseCoins").parent().hasClass('has-error')==false){
			var rs = Bitcoin.Script.createMultiSigOutputScript($("#releaseCoins option:selected").html()*1, pubkeys);
			var multisig = multiSig(rs);
			$("#multiSigData .address").val(multisig['address']);
			$("#multiSigData .script").val(multisig['redeemScript']);
			$("#multiSigData").removeClass('hidden').addClass('show').fadeIn();
			$("#releaseCoins").removeClass('has-error');
		}
	});

	$("#modalMediatorAgent").on('show.bs.modal', function () {
		var agent = $("#multisigAgentSelect option:selected").html();
		$("#agentAlias").html(agent).attr('href',agents[agent]['url']);
		$("#agentEmail").html(agents[agent]['email']).attr('href','mailto:'+agents[agent]['email']);
		$("#agentPubkey").val(agents[agent]['pubkey']);
		$("#agentUse").attr('disabled',false);
		if(agents[agent]['pubkey']=='no key'){
			$("#agentUse").attr('disabled',true);
		}

		$("#agentFee").html(agents[agent]['fee']);
	});

	$(".multisigaddressQrcodeBtn").click(function(){
		var thisbtn = $(this).parent().parent();
		$("#qrcode").attr('src','https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=bitcoin:'+$('.address',thisbtn).val());
	});

	$("#uncompressedPubKeys .addressAdd").click(function(){
		if($("#uncompressedPubKeys .addressRemove").length<19){
			var clone = '<div class="form-inline">'+$(this).parent().html()+'</div>';
			$("#uncompressedPubKeys").append(clone);
			$("#uncompressedPubKeys .glyphicon-plus:last").removeClass('glyphicon-plus').addClass('glyphicon-minus');
			$("#uncompressedPubKeys .glyphicon-minus:last").parent().removeClass('addressAdd').addClass('addressRemove');
			$("#uncompressedPubKeys .addressRemove").unbind("");
			$("#uncompressedPubKeys .addressRemove").click(function(){
				$(this).parent().fadeOut().remove();
			});
		}
	});

	$("#inputs .txIdAmount").change(function(){
		totalInputAmount();
	}).keyup(function(){
		totalInputAmount();
	});

	$("#newKeysBtn").click(function(){
		genentropy();
		var hash_str = Crypto.SHA256(entropy);
		var hash = Crypto.util.hexToBytes(hash_str);
		var eckey = new Bitcoin.ECKey(hash);
		var pub = eckey.getBitcoinAddress();
		var priv = new Bitcoin.Address(hash);
		priv.version = 128;

		$("#newBitcoinAddress").val(pub.toString());
		$("#newPrivKey").val(priv.toString());
		$("#newPubKey").val(Crypto.util.bytesToHex(eckey.getPub()));
	});

	$("#newTransaction .redeemScript").keyup(function(){
		var multisig = multiSig({'buffer':Crypto.util.hexToBytes($(this).val())});
		$("#newTransaction .addressFrom").html('<a href="http://www.blockchain.info/address/'+multisig['address']+'" target="_blank">'+multisig['address']+'</a>');
		$("#addressBalanceLoading").css('display','block');
		$("#transactionCreateMsg").css('display','none');
		$.ajax ({
			type: "POST",
			url: "https://coinb.in/api/",
			data: 'uid='+uid+'&key='+apikey+'&setmodule=addresses&request=unspent&address='+$("#newTransaction .addressFrom a").html(),
			dataType: "xml",
			error: function() {
				alert('Failed to retreive unpsent inputs, please try again');
			},
			success: function(data)	{
				$("#addressBalance").html('0.00');
				$("#inputs .txidRemove, #inputs .txidClear").click();

				if ($(data).find("result:first").text() == 1) {
					var bal = 0;

					$.each($(data).find("unspent").children(), function(i, o){

						var val = (($(o).find("value").text()*1)/100000000);
						var txid = (($(o).find("tx_hash").text()).match(/.{1,2}/g).reverse()).join("")+'';

						$("#inputs .txId:last").val(txid);
						$("#inputs .txIdN:last").val($(o).find("tx_output_n").text());
						$("#inputs .txIdAmount:last").val(val.toFixed(8));
						bal += val;

						$("#inputs .row:last input").attr('disabled',true);

						if(i<($(data).find("unspent").children().length-1)){
							$("#inputs .txidAdd").click();
						}
					});
					$("#addressBalance").html(bal.toFixed(8)).fadeOut().fadeIn();
					$("#recipients .amount").keyup();
				} else {
					$("#transactionCreateMsg").html(unescape($(data).find("response").text()).replace(/\+/g," ")).fadeIn();
				}

				totalInputAmount();
			},
			complete: function(){
				$("#addressBalanceLoading").css('display','none');
			}
		});
	});

	$("#transactionCreateBtn").click(function(){
		$("#transactionCreate").removeClass('show').addClass('hidden').fadeIn();
		$("#transactionCreateMsg").fadeOut();

		var sendTx = new Bitcoin.Transaction();

		if((($("#totalOutput").html()*1)>($("#totalInput").html()*1)) || ($("#totalInput").html()*1)==0){
			$("#transactionCreateMsg").html('You are trying to send more than you have available').fadeOut().fadeIn();
			return 0;
		}

		$.each($("#inputs .row"),function(i,o){
			var txid = ($(".txId", o).val()).match(/.{1,2}/g).reverse().join("");
			if(txid.match(/^[a-f0-9]+$/i)){
				var n = $(".txIdN", o).val();
				if(n.match(/^[0-9]+$/)){
					var tx = {'hash': Crypto.util.bytesToBase64(Crypto.util.hexToBytes(txid))};
					sendTx.addInput(tx, n);
					sendTx.ins[i].script = new Bitcoin.Script(Crypto.util.hexToBytes($("#newTransaction .redeemScript").val().toLowerCase()));
				} else {
					$(".txIdN", o).parent().addClass('has-error');
					$("#transactionCreateMsg").html('One or more input is invalid or missing').fadeOut().fadeIn();
				}
			} else {
				$(".txId", o).parent().addClass('has-error');
				$("#transactionCreateMsg").html('One or more input transaction id is invalid or missing').fadeOut().fadeIn();
			}
		});

		if($("#inputs .txId, #inputs .txIdN").parent().hasClass('has-error')==true){
			return 0;
		}

		$.each($("#recipients").children(), function(i, o){
			var res = parseBase58Check($(".address",o).val());
			if(res['result']==1){
				var addr = new Bitcoin.Address($(".address",o).val());
				if(!isNaN($(".amount",o).val()) && $(".amount",o).val()*1>0){
					var amount = new BigInteger('' + Math.round(($(".amount",o).val()*1) * 1e8), 10);
					sendTx.addOutput(addr, amount);
				} else {
					$(".amount",o).parent().addClass('has-error');
					$("#transactionCreateMsg").html('One or more output amount is invalid or missing').fadeOut().fadeIn();
				}
			} else {
				$(".address",o).parent().addClass('has-error');
				$("#transactionCreateMsg").html('One or more output address is invalid or missing').fadeOut().fadeIn();
			}
		});

		if($("#recipients .address, #recipients .amount").parent().hasClass('has-error')==true){
			return 0;
		}

		$("#transactionCreate").removeClass('hidden').addClass('show').fadeIn();
		$("#transactionCreate textarea").val(Crypto.util.bytesToHex(sendTx.serialize()));
	});

	$("#signBtn").click(function(){
		var res = parseBase58Check($("#signPrivateKey").val());
		if(res['result']==1){
			$("#signPrivateKey").parent().removeClass('has-error');

			// generate a pubkey from the signing transaction (so we can check its in the redeemScript)
			var secret = Bitcoin.Base58.decode($("#signPrivateKey").val()).slice(1, 33);
			var eckey = new Bitcoin.ECKey(secret);
			var pubkey = eckey.getPub();

			// deserialize and the transation so we can manipulate it
			var deserialized = Bitcoin.Transaction.deserialize($("#signTransaction").val());
			var txNew = new Bitcoin.Transaction(deserialized);

			$.each(deserialized.ins, function(i,o){
				// each input
				var redeemScript = (o.script.chunks[o.script.chunks.length-1]==174) ? o.script : new Bitcoin.Script(o.script.chunks[o.script.chunks.length-1]);				
				var sighash = txNew.hashTransactionForSignature(redeemScript, i, 1);
				var signature = eckey.sign(sighash);
				signature.push(parseInt(1, 10));

				var s = new Bitcoin.Script();
				s.writeOp(0);

				if(o.script.chunks[o.script.chunks.length-1]==174){
					s.writeBytes(signature);
				} else if (o.script.chunks[0]==0 && o.script.chunks[o.script.chunks.length-1][o.script.chunks[o.script.chunks.length-1].length-1]==174){
					var pubkeyList = scriptListPubkey(redeemScript);
					var sigsList = scriptListSigs(o.script);
					sigsList[countObject(sigsList)+1] = signature;
					for(x in pubkeyList){
						for(y in sigsList){
							if(Bitcoin.ECDSA.verify(sighash, sigsList[y], pubkeyList[x])){
								s.writeBytes(sigsList[y]);
							}
						}
					}
				}
				s.writeBytes(redeemScript.buffer);
				txNew.ins[i].script = s;
			});
			$("#signedData textarea").val(Crypto.util.bytesToHex(txNew.serialize()));
			$("#signedData").removeClass('hidden').addClass('show').fadeIn();
		} else {
			$("#signPrivateKey").parent().addClass('has-error');
		}
	});

	$(".txidClear").click(function(){
		$("#inputs .row:first input").attr('disabled',false);
		$("#inputs .row:first input").val("");
		totalInputAmount();
	});

	$("#verifyBtn").click(function(){
		if(($("#verifyTransaction").val()).match(/[^a-f0-9]+/i)){
			$(".verifyData").addClass("hidden");
			$("#verifyStatus").removeClass('hidden').fadeOut().fadeIn();
			return false;
		}

		$(".verifyData").addClass("hidden");
		$("#verifyStatus").hide();

		if(!decodeRedeemScript()){
			if(!decodeTransactionScript()){
				$("#verifyStatus").removeClass('hidden').fadeOut().fadeIn();
			}
		}

	});

	$("#rawSubmitBtn").click(function() {
		$.ajax ({
			type: "POST",
			url: "https://coinb.in/api/",
			data: 'uid='+uid+'&key='+apikey+'&setmodule=bitcoin&request=sendrawtransaction&rawtx='+$("#rawTransaction").val(),
			dataType: "xml",
			error: function() {
				alert('Failed to submit, please try again');
			},
			success: function(data)	{
				$("#rawTransactionStatus").html(unescape($(data).find("response").text()).replace(/\+/g,' ')).removeClass('hidden');
				if($(data).find("result").text()==1){
					$("#rawTransactionStatus").addClass('alert-success').removeClass('alert-danger');
					$("#rawTransactionStatus").html('txid: '+$(data).find("txid").text());
				} else {
					$("#rawTransactionStatus").addClass('alert-danger').removeClass('alert-success');
				}
				$("#rawTransactionStatus").fadeOut().fadeIn();
			}
		});
	});

	function parseBase58Check(address) {
		var bytes = Bitcoin.Base58.decode(address);
		var end = bytes.length - 4;
		var hash = bytes.slice(0, end);
		var checksum = Crypto.SHA256(Crypto.SHA256(hash, {asBytes: true}), {asBytes: true});
		if (checksum[0] != bytes[end] || checksum[1] != bytes[end+1] || checksum[2] != bytes[end+2] || checksum[3] != bytes[end+3]){
			result = {'result':0,'response':'wrong checksum'};
		} else {
			result = {'result':1,'version':hash.shift(),'hash':hash, 'response':'valid checksum'};
		}
		return result;
	}

	$('input[title!=""], abbr[title!=""]').tooltip({'placement':'bottom'});

	if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');

	$('a[data-toggle="tab"]').on('shown', function(e) {
		return location.hash = $(e.target).attr('href').substr(1);
	});

	for(i=1;i<3;i++){
		$(".addressAdd").click();
	}

	var entropy = null;
	genentropy();

	validateOutputAmount();
	validateAddress();
});
</script>
