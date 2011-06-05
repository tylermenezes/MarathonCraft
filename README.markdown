Requirements
=============

MarathonCraft requires no database. For best performance, you should install memcached.

Installation
=============

Copy all the files to a web server. Make sure you're running PHP.

On your Minecraft server, install the Minequery mod for Bukkit.

Ensure you have Perl installed, and have the HTTP::Server::Simple::CGI module installed. (If you're not sure, try running `cpan install HTTP::Server::Simple::CGI`.)

Copy the AllPlayersServer.pl script to your Minecraft server directory. Then execute it with `perl AllPlayersServer.pl`.

Configuration
==============

Configuration is specified by flatfiles in the config directory. All configuration information is stored as a key, followed by any number of whitespace characters (tabs or spaces), followed by paramaters, seperated, again, by any number of whitespace characters.

The configuration files are:

config.txt
-----------

Primary configuration information. This is where you'll set the site name, server address, etc.

streams.txt
------------

This is where you'll associate users with streams. The key is the user's Minecraft name, the first paramater is the service (currently only "jtv" is supported) and the second paramater is the stream ID (this is the user's URL segment).

team.txt, thanks.txt, [...].txt
--------------------------------
All other files are "list" files. The default template uses team.txt and thanks.txt to populate the corresponding columns up top, but you can have as many or few lists as you want. The key is the user's Minecraft username, and the first and only paramater is any additional information you want displayed.

Changing the Theme
===================
The site is very simple, with only one page. Most of the structure is contained in index.php, with the exception of the display of user blocks, which is handled in the tpl/UserBlock.php file. Styles are handled by css/main.css.

The decision to avoid using a more complete template system was made to minimize the site's footprint.
