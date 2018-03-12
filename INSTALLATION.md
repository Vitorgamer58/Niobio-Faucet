#Cryptonight Faucet Installation

Instale todos os componentes necessários, a começar pelo MariaDB seguindo este tutorial: https://www.liquidweb.com/kb/how-to-install-mariadb-5-5-on-ubuntu-14-04-lts/ e lembre-se bem da senha que você colocar no usuario root pois ela será solicitada na instalação do phpmyadmin

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

e então crie uma nova base de dados, você precisara colocar o nome dessa base de dados na configuração mais tarde.
![alt text](http://ap.imagensbrasil.org/images/2018/03/09/Screenshot_518.png)

Agora você deve entrar na base de dados, abrir uma linha para comandos e Digitar o seguinte comando
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
![alt text](http://ap.imagensbrasil.org/images/2018/03/09/Screenshot_519.png)
Então clique em Executar, obvio que não aprendi isso sozinho, agradecimento ao Filipe, um dos Desenvolvedores da Niobio Cash e dodo da pool 4miner

Após a criação da Database, renomeie o arquivo config.php.sample para config.php e edite config.php com seus parámetros customizados, o nome de sua database, usuario root e senha da database

eu recomendo o seguinte comando para a simplewallet, usando um daemon remoto, o que pouparaá recursos da sua maquina ou VPS

```bash
./simplewallet --wallet-file wallet.bin --pass senha --rpc-bind-port=8317 --rpc-bind-ip=127.0.0.1 --daemon-host 45.155.141.227 --daemon-port 8313
```

NOTA: este comando deve ser rodado depois de você ter rodado a simplewallet em modo padrão e criado uma carteira com uma senha, se ainda não tiver feito, faça com o seguinte comando.

```bash
./simplewallet --daemon-ip 45.155.141.227 --daemon-port 8313
```

* wallet.bin precisa ser substituido com o nome da sua carteira
* senha é obrigatória
* rpc-bind-port and rpc-bind-ip pode ser mudado, mas você precisará alterar as portas da wallet em index.php e requests.php

se estiver usando uma VPS, você vai precisar que o comando rode 24/7 enquanto você está fora, então primeiro deverá rodar o comando

```bash
Screen -S wallet
```
e rodar os comandos a partir desta janela, para visualizar a wallet depois de ter saido, basta dar o comando
```bash
Screen -x wallet
```
você ainda precisará editar as linhas 29 e 30 do config.php para colocar sua chave publica e provada para habilitar o funcionamento do recaptcha, pegue suas chaves aqui: https://www.google.com/recaptcha/intro/android.html clique em Get reCAPTCHA

Aanuncios podem ser editados na parte index.php entre essas linhas para uma melhor organização:

           <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->
           <!-- ADS ADS ADS ADS ADS ADS ADS ADS ADS -->


depois destes passos você estará pronto para ir, aqui alguns sites para uma boa monetização do seu Faucet garantindo lucratividade:

Anonymous ADS: https://a-ads.com/?partner=828285

PopADS: https://www.popads.net/users/refer/1548447

Propeller ADS (não recomendado): https://publishers.propellerads.com/#/pub/auth/signUp?refId=TL9t

e um pequeno Script para minerar XMR no site do visitante: http://www.limontec.com/2017/09/como-minerar-xmr-atraves-de-visitas-em.html

Se este tutorial te ajudou, doe para o meu Faucet: NAHwNpB9ETS1YHapFu4qDEbVTCuV2ztbzX8oZe5bB7ZTL6BYTvugV8WD2rC1pykcosE2vuwxpgfG51AUoWmS22qTFPMc71a 

estou rodando um Faucet na minha VPS do google em 1CPU compartilhada e 0.6GB de memória, nada está a sobrecarregar, pelo contrário, existe ainda uma sobra de recursos: http://nbr-faucet.ddns.net
