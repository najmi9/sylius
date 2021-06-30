.PHONY: start-mercure help cs-fixer php-stan lintjs install-mercure run-supervisor server update push test composer-install composer-update yarn-build yarn-install yarn-add

.DEFAULT_GOAL=help

COM_COLOR   = \033[0;34m
OBJ_COLOR   = \033[0;36m
OK_COLOR    = \033[0;32m
ERROR_COLOR = \033[0;31m
WARN_COLOR  = \033[0;33m
NO_COLOR    = \033[m

CURRENT_DIR=$(shell pwd)

DIR=$(CURRENT_DIR)/mercure_binary


##
help: ## Help
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
##
start-mercure: ## Start mercure server on port 30 
	echo  "mercure server started on $(OK_COLOR)http://localhost:3000$(NO_COLOR)"
	$(DIR)/mercure --jwt-key='!ChangeMe!' --debug=1 --addr='localhost:3000' --allow-anonymous --cors-allowed-origins='https://localhost:8000'

##
cs-fixer: ## Run php-cs-fixer command to Check if the my php is correct
	echo  "Runig $(WARN_COLOR)./php-cs-fixer --diff --dry-run -v --allow-risky=yes fix$(NO_COLOR)"
	./php-cs-fixer --diff --dry-run -v --allow-risky=yes fix

##
php-stan: ## Run the php-stan command : vendor/bin/phpstan analyse src --level 5
	echo  "Run the php-stan command: $(COM_COLOR)vendor/bin/phpstan analyse src --level 5$(NO_COLOR)"
	vendor/bin/phpstan analyse src --level 5 --memory-limit=-1

##
lintjs: ## Run eslint command : yarn run eslint assets/js/pages/
	echo  "Run eslint command : $(OBJ_COLOR)yarn run eslint assets/js/pages/$(NO_COLOR)"
	yarn run eslint assets/js/pages/ --fix
##
##Download Mercure Hub And Extract It in mercure_binary folder
install-mercure: ##  make install-mercure DIR="/path/when/mercure/willbe/installed"
	echo "Creating $(COM_COLOR) $(DIR) $(NO_COLOR) Folder"
	rm -rf $(DIR)
	mkdir $(DIR)
	echo "$(OK_COLOR)Downloading..$(NO_COLOR)"
	wget https://github.com/dunglas/mercure/releases/download/v0.10.4/mercure_0.10.4_Linux_x86_64.tar.gz -P $(DIR)
	echo "$(OK_COLOR) Extracting the downloads$(NO_COLOR)"
	cd $(DIR) && tar -xvzf mercure_0.10.4_Linux_x86_64.tar.gz

##
##Install Supervisor
run-supervisor: ## take configuration from 'config' folder and run supervisor
	sudo apt-get update
	sudo apt-get install supervisor 
	echo "$(OBJ_COLOR)create symlink to the configuration$(NO_COLOR)"
	sudo ln -s ./config/messenger-worker.conf /etc/supervisor/conf.d
	sudo supervisorctl reread
	sudo supervisorctl update
	sudo supervisor start messenger-consume:*
##
##Run php server
server: ## http://127.0.0.1:8000
	symfony serve --no-tls

##
##Installation
install: ## What I have to install to run the project
	sudo apt-get install php7.4-gd php-mysql php7.4-xml php7.4-mbstring php-redis php7.4-intl
	sudo apt-get install -y jpegoptim
	sudo apt-get install wkhtmltopdf

##
##Run the worker
worker: ## php bin/console messenger:consume async -vvv 
	php bin/console messenger:consume async -vvv

##
##Update Project
update: ## Update the projects dependences
	php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
	php composer-phar update
	yarn install

##
##Update Beta Server
beta-deploy: ## Deploy fast in the beta server
	git checkout -- .
	git pull
	composer update --no-dev --optimize-autoloader
	php bin/console doctrine:schema:update -f
	yarn install
	yarn run encore production
	composer dump-env prod
	php bin/console cache:clear

##
##Install Weasy
weasyprint: ## Install WeasyPrint By PIP3
	sudo apt-get update
	sudo apt-get install libxml2-dev libxslt-dev libpango1.0-dev python3-pip build-essential python3-dev python3-pip python3-setuptools python3-wheel python3-cffi libcairo2 libpango-1.0-0 libpangocairo-1.0-0 libgdk-pixbuf2.0-0 libffi-dev shared-mime-info
	sudo pip3 install WeasyPrint 
	sudo mv -fr ~/.local/bin/weasyprint /usr/bin

##
##List Twig files
twig: ## Lint *.twig
	php bin/console lint:twig templates/

##Stop Installed Services.
stop: ## So we can use thier ports with docker, otherwise we will get an error of port already in use.
	sudo service mysql stop
	sudo service redis stop
	sudo service apache2 stop

##
##Run containers
docker-up: ##  docker-compose up
	docker-compose -f docker-compose2.yaml --env-file .env up -d

##
##Stop containers
docker-down: ##  docker-compose down
	docker-compose -f docker-compose2.yaml down

##
docker-restart: ## docker-compose up && docker-compose down
	docker-compose -f docker-compose2.yaml down
	docker-compose -f docker-compose2.yaml --env-file .env up -d

##
##Build Images
docker-build: ## docker-compose build
	docker-compose -f docker-compose2.yaml --env-file .env build
	sudo chown -R 1001 ./tools/docker/redisinsight
##
##Yarn Installation
yarn-install: ##  yarn install
	docker exec node-container yarn install

##
##Add Yarn
yarn-add: ## Ex: make yarn-add package=jquery
	docker exec node-container yarn add $(package)

##
##Build Yarn assets
yarn-build: ## yarn build
	docker exec node-container yarn build

##
##Symfony cli
sf: ## Ex: make sf command=cache:clear
	docker exec php7.4-container php -d memory_limit=-1 bin/console $(command)

##
##Install PHP Packages
composer-install: ## Ex: make composer-install package=encore
	docker exec php7.4-container composer install $(package)

##
##Composer Update
composer-update: ##  composer update
	docker exec php7.4-container composer update

##
##Profiling and Analyzing the project by blckfire.io
blackfire: ## blackfire curl nginx-service
	docker exec blackfire-container blackfire curl nginx-service

##
##Lanch Tests
test: ## make test filter=HomeControllerTest
	APP_ENV=test ./vendor/bin/phpunit --filter=$(filter)
