# copy this file to /var/www/shop and execute

git clone https://github.com/lotcz/zshop.git zShop
git clone https://github.com/lotcz/zEngine.git zEngine

cd zEngine
chmod +x upgrade.sh
chmod +x update.sh
./upgrade.sh 1.02

cd ..
cd zShop
chmod +x upgrade.sh
chmod +x update.sh
./upgrade.sh 1.03