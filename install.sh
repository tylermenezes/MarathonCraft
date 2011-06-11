#!/bin/sh

sudo mkdir /var/minecraft
cd /var/minecraft

sudo apt-get install sun-java6-jre sun-java6-plugin sun-java6-fonts -y
sudo yum install perl-CPAN -y

sudo perl -MCPAN -e 'install HTTP::Server::Simple::CGI'

sudo wget http://www.minecraft.net/download/minecraft_server.jar
sudo wget https://raw.github.com/tylermenezes/MarathonCraft/master/AllPlayersServer.pl

sudo wget http://ci.bukkit.org/job/dev-CraftBukkit/lastSuccessfulBuild/artifact/target/craftbukkit-0.0.1-SNAPSHOT.jar

freemem=$(free -m -t | grep "Total" | tr -s ' ' | cut -d " " -f4 | sed -e "s/[^0-9]//g" | tr -d '\n')
freemem=$(echo "$freemem*.9" | bc -l | xargs printf "%1.0f")
memunit="M"

sudo cat > minecraft.sh << EOF
#!/bin/sh
nohup java -Xincgc -Xmx$freemem$memunit -jar craftbukkit-0.0.1-SNAPSHOT.jar > /dev/null 2> server.err < /dev/null &
nohup perl AllPlayersServer.pl > /dev/null 2> /dev/null < /dev/null &
EOF

sudo chmod +x minecraft.sh

sudo mkdir plugins
cd plugins
sudo wget https://github.com/downloads/kramerc/minequery/Minequery-1.5.zip
sudo unzip *.zip

sudo rm LICENSE.txt

cd ..
sudo ./minecraft.sh
