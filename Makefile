
test:
	./vendor/bin/sail artisan test

test-coverage:
	composer phpunit tests -- --coverage-clover build/logs/clover.xml

install:
	composer install

run:
	./vendor/bin/sail up

lint:
	composer run-script phpcs

lint-fix:
	composer run-script phpcbf

setup: install
	cp -n .env.example .env || true
	./vendor/bin/sail artisan key:generate
	touch database/database.sqlite
	./vendor/bin/sail artisan migrate

npm:
	npm install && npm run dev

seed:
	./vendor/bin/sail artisan db:seed

clear:
	./vendor/bin/sail artisan optimize:clear
	npm cache clean --force
	composer dump-autoload


