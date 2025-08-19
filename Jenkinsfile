pipeline {
    agent any

    environment {
        DOCKERHUB_CREDENTIALS = credentials('dockerhub-credentials')
        DOCKERHUB_IMAGE = 'prasun277/devops-setup:latest'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        stage('Build Docker Image') {
            steps {
                script {
                    docker.build(env.DOCKERHUB_IMAGE)
                }
            }
        }
        stage('Prepare Laravel App') {
            steps {
                bat 'docker-compose run --rm app git config --global --add safe.directory /var/www'
                bat 'docker-compose run --rm app sh -c "chown -R www-data:www-data /var/www/vendor || true"'
                bat 'docker-compose run --rm app sh -c "chmod -R 777 /var/www/vendor || true"'
                bat 'docker-compose run --rm app composer install'
                bat 'if not exist .env copy .env.example .env'
                bat 'docker-compose run --rm app php artisan key:generate'
                bat 'docker-compose run --rm app php artisan migrate --force'
            }
        }
        stage('Run Laravel Tests') {
            steps {
                bat 'docker-compose run --rm app php artisan test'
            }
        }
        stage('Push to Docker Hub') {
            steps {
                script {
                    docker.withRegistry('https://index.docker.io/v1/', env.DOCKERHUB_CREDENTIALS) {
                        docker.image(env.DOCKERHUB_IMAGE).push()
                    }
                }
            }
        }
    }
}
