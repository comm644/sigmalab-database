BEGIN{ 
	prefix = "objects/Database/"
	filename = prefix"schema.php"
	FS=" ";
}
/@kphp-serializable/{ next;}
/@kphp-serialized-field/{ next;}
/\/\/@class \w+/ {
	filename = prefix$2".php";
	system("test -e "filename " && rm "filename)
	print "file = " filename
	print "<?php" > filename
	# print "<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */" > filename
	# print " /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */" > filename
	# print " /** @noinspection PhpUnused */\n" > filename
	print "namespace Database;\n" > filename
	next;
}
{
	print $0 > filename
}
