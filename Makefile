up:
	php -S 127.0.0.1:3000 -t ./public
up:
    symfony server:start
    docker compose up

user:
    symfony console make:user

entity:
    symfony console make:entity


db-create:
    symfony console doctrine:database:create

migration:
	symfony console make:migration

update:
	symfony console d:s:u -f

import:
symfony console d:m:m

admin-symfony:
symfony console make:admin:crud