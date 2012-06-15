use strict;
use warnings;

my $input = '';

while(my $in = <>){

	$input .= $in;


	$input =~ s/Problem/Item/g;
	$input =~ s/problem/item/g;

	$input =~ s/Test_ProQuestion/Test_IteQuestion/g;
	$input =~ s/test_proQuestion/test_iteQuestion/g;
	$input =~ s/TestProQuestion/TestIteQuestion/g;
	$input =~ s/testProQuestion/testIteQuestion/g;

	$input =~ s/Test_ProQueChoice/Test_IteQueChoice/g;
	$input =~ s/test_proQueChoice/test_iteQueChoice/g;
	$input =~ s/TestProQueChoice/TestIteQueChoice/g;
	$input =~ s/testProQueChoice/testIteQueChoice/g;

	$input =~ s/Test_ProQueType/Test_IteQueType/g;
	$input =~ s/test_proQueType/test_iteQueType/g;
	$input =~ s/TestProQueType/TestIteQueType/g;
	$input =~ s/testProQueType/testIteQueType/g;

	last if(eof());
}

print $input;
