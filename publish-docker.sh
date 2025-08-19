
USERNAME=prasun277
IMAGE=devops-setup
TAG=latest

# Build the Docker image
docker build -t $USERNAME/$IMAGE:$TAG .

# Log in to Docker Hub
echo "Please enter your Docker Hub password:"
docker login --username $USERNAME

# Push the image
docker push $USERNAME/$IMAGE:$TAG

echo "Image pushed: $USERNAME/$IMAGE:$TAG"
