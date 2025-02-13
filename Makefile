install:
	docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

start:
	./vendor/bin/sail up -d

stop:
	./vendor/bin/sail stop

down:
	./vendor/bin/sail down

rebuild:
	./vendor/bin/sail build --no-cache