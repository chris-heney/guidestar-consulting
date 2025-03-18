#!/bin/bash
# Replace <your-github-username> with your GitHub username
IMAGE_NAME=ghcr.io/chris-heney/guidestar-consulting:latest

# Build the docker image
docker build -t $IMAGE_NAME .

# Push the docker image to GitHub Container Registry
docker push $IMAGE_NAME
