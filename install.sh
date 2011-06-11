#!/bin/sh

if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi

mkdir /var/minecraft
cd /var/minecraft

apt-add-repository "http://archive.canonical.com/ubuntu partner"
apt-get update
apt-get install sun-java6-bin sun-java6-plugin unzip build-essential -y
yum install perl-CPAN -y


perl -MCPAN -e 'install Bundle::CPAN;install HTTP::Server::Simple::CGI;'

wget http://www.minecraft.net/download/minecraft_server.jar
wget https://raw.github.com/tylermenezes/MarathonCraft/master/AllPlayersServer.pl

wget http://ci.bukkit.org/job/dev-CraftBukkit/lastSuccessfulBuild/artifact/target/craftbukkit-0.0.1-SNAPSHOT.jar

freemem=$(free -m -t | grep "Total" | tr -s ' ' | cut -d " " -f4 | sed -e "s/[^0-9]//g" | tr -d '\n')
freemem=$(echo "$freemem*.9" | bc -l | xargs printf "%1.0f")
memunit="M"

cat > minecraft.sh << EOF
#!/bin/sh
nohup java -Xincgc -Xmx$freemem$memunit -jar craftbukkit-0.0.1-SNAPSHOT.jar > /dev/null 2> server.err < /dev/null &
nohup perl AllPlayersServer.pl > /dev/null 2> /dev/null < /dev/null &
EOF

chmod +x minecraft.sh

mkdir plugins
cd plugins
wget https://github.com/downloads/kramerc/minequery/Minequery-1.5.zip
unzip *.zip

rm LICENSE.txt

cd ..
./minecraft.sh
