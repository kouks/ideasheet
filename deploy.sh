rsync --exclude vendor --exclude .env --exclude node_modules -r -e "ssh -i deploy_rsa -o 'StrictHostKeyChecking no'" $TRAVIS_BUILD_DIR/. root@46.101.45.168:/var/www/sub/idea
ssh -i deploy_rsa -o 'StrictHostKeyChecking no' root@46.101.45.168 "cd /var/www/sub/idea && composer install"
