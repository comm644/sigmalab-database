
PHP_OUTDIR = objects
SQL_OUTDIR = objects

SRCFILES = schema.xml

PHP_FILES := $(SRCFILES:.xml=.php)
SQL_FILES := $(SRCFILES:.xml=.sql)
SQLITE_FILES := $(SRCFILES:.xml=.sqlite)
PGSQL_FILES := $(SRCFILES:.xml=.psql)

OUT_FILES := $(foreach file, ${PHP_FILES},${PHP_OUTDIR}/$(file)) 
OUT_FILES += $(foreach file, ${SQL_FILES},${SQL_OUTDIR}/$(file))
OUT_FILES += $(foreach file, ${SQLITE_FILES},${SQL_OUTDIR}/$(file))
OUT_FILES += $(foreach file, ${PGSQL_FILES},${SQL_OUTDIR}/$(file))


TESTS = $(wildcard test*.php)
PHP   = php


.SUFFIXES: .php .xml .sql .sqlite
.PHONY: $(TESTS)

CDIR=../compiler/

${PHP_OUTDIR}/%.php: %.xml ${CDIR}genphp.xsl
	xsltproc -o $@ ${CDIR}genphp.xsl $< 
	awk -f ../compiler/genclasses.awk $@

${SQL_OUTDIR}/%.sql: %.xml
	xsltproc -o $@ ${CDIR}gensql.xsl $< 

${SQL_OUTDIR}/%.sqlite: %.xml ${CDIR}gensqlite.xsl
	xsltproc -o $@ ${CDIR}gensqlite.xsl $< 

${SQL_OUTDIR}/%.psql: %.xml ${CDIR}genpgsql.xsl
	xsltproc -o $@ ${CDIR}genpgsql.xsl $< 



all: ${OUT_FILES}
	php testRunner.php

clean:
	${RM} ${OUT_FILES}


$(TESTS):
	$(PHP) testRunner.php $@

kphp=kphp
kphp=../../../../kphp-test/src/kphp/objs/bin/kphp2cpp 

.PHONY: ffi kphp_FfiSqliteDatasource.php kphp_FfiPostgreDatasource.php

ffi: kphp_FfiSqliteDatasource.php
kphp_FfiSqliteDatasource.php kphp_FfiPostgreDatasource.php: gen
	$(kphp) -M cli \
		-I ../src \
		-I ../ \
		-I ../../ \
		-I ../../logger \
		-I ./objects \
		--enable-ffi \
		--extra-linker-flags "-lsqlite3 -l:libre2.a -lpq -L${KPHP_PATH}/objs/flex -ggdb -no-pie" $@ \
		&& echo "Done!" && ./kphp_out/cli --Xkphp-options --disable-sql
	
php:
	php -d ffi.enable=preload -d opcache.preload=sqlite-preload.php testSqliteFFI.php

ffi-pgsql: kphp_FfiPostgreDatasource.php

php-pgsql:
	php -d ffi.enable=preload -d opcache.preload=pgsql-preload.php kphp_FfiPostgreDatasource.php

gen:
	php tools/genAdoTestReflection.php