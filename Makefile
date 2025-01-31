start:
	./vendor/bin/sail up -d

stop:
	./vendor/bin/sail stop

down:
	./vendor/bin/sail down

rebuild:
	./vendor/bin/sail build --no-cache