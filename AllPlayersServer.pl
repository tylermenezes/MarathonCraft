 #!/usr/bin/perl
 {
 package MinecraftPlayerListServer;
 
 use HTTP::Server::Simple::CGI;
 use base qw(HTTP::Server::Simple::CGI);
 
 sub handle_request {
     my $self = shift;
     my $cgi  = shift;
   
     my $path = $cgi->path_info();
 
    print "HTTP/1.0 200 OK\nContent-type: text/plain\n\n";

    my @files = </world/players/*.dat>;
    foreach $file (@files) {
      $file =~ s/.*\/(.*)?\.dat/\1/g;
      print $file . "\n";
    }
 }
 
 } 
 
 my $pid = MinecraftPlayerListServer->new(9898)->background();
 print "Use 'kill $pid' to stop server.\n";