#Niobio Cash Faucet Installation

instale todos os componentes necessários, a copmeçar pelo MariaDB seguindo este tutorial: https://www.liquidweb.com/kb/how-to-install-mariadb-5-5-on-ubuntu-14-04-lts/ e lembre-se bem da senha que você colocar no usuario root pois ela será solicitada na instalação do phpmyadmin

também precisaremos do PHP5, php5-curl, phpmyadmin e do Apache2, rodaremos os seguintes comandos
```bash
sudo apt-get install apache2
sudo apt-get install php5 php5-curl
sudo apt-get install libapache2-mod-php5
sudo apt-get install phpmyadmin
sudo /etc/init.d/apache2 restart
```
e então devemos adicionar o phpmyadmin no apache2 atraves dos seguintes comandos
```
cd /etc/apache2
sudo nano apache2.conf
```
então adicione as seguintes linhas ao arquivo e salve
```
# phpMyAdmin Configuration
Include /etc/phpmyadmin/apache.conf
```
agora entre no phpmyadmin usando 
```
127.0.0.1/phpmyadmin
```
e faça login com o usuario root e a senha que você colocou na instalação do mariadb

First of all you need to create a new database and create this table on it for the faucet to save all requests:
```
CREATE TABLE IF NOT EXISTS `payouts` (
`id` bigint(20) unsigned NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `payout_amount` double NOT NULL,
  `payout_address` varchar(100) NOT NULL,
  `payment_id` varchar(75) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
```

After you create database, copy config.php.sample to config.php and edit config.php with all your custom parameters and also database information.


Now for faucet to communicate with bytecoin wallet you need to run simplewallet as this:

```bash
./simplewallet --wallet-file=wallet.bin --pass=password --rpc-bind-port=8317 --rpc-bind-ip=127.0.0.1
```

Note: Run this command after you already created a wallet with simplewallet commands.

* wallet.bin needs to be the wallet file name that you enter when you created your wallet.
* password needs to be the password to open your wallet
* rpc-bind-port and rpc-bind-ip can be changed if so, you need to edit index.php and request.php (Please don't edit, as you may end opening the wallet rpc to the public)


And bytecoin daemon as this:

```bash
./bytecoind --rpc-bind-ip=127.0.0.1
```

To keep bytecoind and simplewallet on background you can use screen command.

Advertisements can be edited on the index.php they are between this lines for an easy location:

           <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
           <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->


After all this steps you should be ready to go ;)
