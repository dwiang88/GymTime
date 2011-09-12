#!/usr/bin/perl
use Perl::Version;

open VERSION, "<", "build" or die $!;
my $build;
while(<VERSION>){
	$build = $_;
}
close VERSION;

$version = Perl::Version->new($build);

open VERSION, "+>", "build" or die $1;
$version->inc_subversion;

print VERSION $version->normal;
print 'GymTime has been updated to ' . $version->normal . "\n";

close VERSION;



#print $build;

#my $version = Perl::Version->new('1.0.0');


#$version->inc_subversion;


#print $version->normal . "\n";


