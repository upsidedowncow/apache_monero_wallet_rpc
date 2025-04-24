# STEPS TO RECREATE:
## 1. Install Apache
`apt install apache2 php php-curl`

## 2. Enable Apache
`systemctl enable apache2`
`systemctl start apache2`

test default page: 
`curl http://localhost`

some handy files to know:
Default Page: /var/www/html/index.html
Documentation: /usr/share/doc/apache2/README.Debian.gz

## 4. Install Monero Command Line Interface
`apt install monero`

## 5. Create a Wallet File (Unnecessary if you already have one, and it is recommended to test with a new wallet to avoid compromising your main wallet)
`monero-wallet-cli`

## 6. Run a monero node (Unecessary if you wish to use a public one, running a monero node will require you to download over 200 but you can be sure your node is not compromised)
`monerod --rpc-bind-ip 127.0.0.1 --rpc-bind-port 18081 --confirm-external-bind > monerod.log 2>&1 &`
(Reboot after downloading the blockchain, ENSURE YOU HAVE OVER 250 GB of storage)

## 7. (VERY IMPORTANT FOR SECURITY) Ensure port 18083 will be closed to outside traffic
`sudo ufw allow from 127.0.0.1 to any port 18083`
`sudo ufw deny 18083`

## 8. Run monero-wallet-rpc to interact with your wallet
`monero-wallet-rpc \
    --wallet-file path/to/wallet
    --prompt-for-password
    --rpc-bind-port 18083 \
    --rpc-login myuser:mypass \
    --rpc-bind-ip 127.0.0.1 \
    --daemon-address http://xmr.stormycloud.org:18089 \
    --log-file ~/wallet-rpc.log \
    > ~/apache_monero/monero-wallet-rpc.log 2>&1 &`

alternatively use --disable-rpc-login to bypass login
THIS TAKES A SECOND TO START, IT WILL LOG "Starting wallet RPC server" when done

## 9. Copy monero.php into /var/www/html/
## 10. Test the script by going to http://ipaddress/monero.php

# Features
The Monero Wallet Balance and its transactions can be retrieved by querying the monero-wallet-rpc. Subaddresses can be created for each client, and you can track exactly how much each subaddress has received in atomic units.
