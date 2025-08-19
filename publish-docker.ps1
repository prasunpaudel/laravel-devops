# PowerShell script to build and push a Docker image to Docker Hub
# Usage: .\publish-docker.ps1 -Username <dockerhub-username> -Image <image-name> -Tag <tag>

param(
    [Parameter(Mandatory=$true)]
    [string]$Username,
    [Parameter(Mandatory=$true)]
    [string]$Image,
    [Parameter(Mandatory=$true)]
    [string]$Tag
)

# Build the Docker image
$imageTag = "${Username}/${Image}:${Tag}"
Write-Host "Building Docker image: $imageTag"
docker build -t $imageTag .

# Log in to Docker Hub
Write-Host "Logging in to Docker Hub as $Username..."
docker login --username $Username

# Push the image
Write-Host "Pushing image to Docker Hub: $imageTag"
docker push $imageTag

Write-Host "Image pushed: $imageTag"
