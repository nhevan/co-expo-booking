pipeline {
	agent { docker 'php' }
	stages {
		stage('build') {
			steps {
				sh '''
					cp .env.travis .env
					mysql -e 'create database expo_booking_test;'
					composer self-update
					composer install --no-interaction
					php artisan key:generate
					php artisan config:cache
					php artisan migrate --database mysql_test
				'''
			}
		}
	}
}