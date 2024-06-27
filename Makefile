.PHONY: install
install: vendor

vendor: composer.json
	composer install

.PHONY: test
test: install
	./vendor/bin/phpunit

.PHONY: validate
validate: install phpcs phpmd

.PHONY: phpcs
phpcs:
	./vendor/bin/phpcs --standard=phpcs.xml -vps

.PHONY: phpmd
phpmd:
	./vendor/bin/phpmd src,tests text phpmd.xml

.PHONY: clean
clean:
	rm -rf vendor composer.lock
