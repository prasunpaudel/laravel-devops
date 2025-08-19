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
