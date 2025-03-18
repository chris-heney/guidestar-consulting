# guidestar-consulting
Guidestar Consulting Repo

This repository provides a robust Docker-based development environment for WordPress. It integrates:
- **WordPress & MySQL** via Docker Compose.
- **X-Debug** for PHP debugging.
- **WordPress Stubs** installed via Composer for enhanced IDE support in VSCode.
- A straightforward setup for local development, testing, version tracking, and deployment.

## Table of Contents
- [Features](#features)
- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
- [Configuration](#configuration)
- [Usage](#usage)
- [Publishing to GitHub Container Registry](#publishing-to-github-container-registry)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## Features
- **Docker Compose Setup:** Spins up WordPress and MySQL containers.
- **Custom Dockerfile:** Builds a WordPress image with X-Debug enabled.
- **VSCode Integration:** WordPress stubs are installed via Composer for improved auto-completion.
- **Local Volume Mounting:** Mounts `wp-content` for live editing.
- **Custom PHP Configuration:** Easily adjust X-Debug settings with `custom-php.ini`.
- **Deployment Ready:** A `publish.sh` script to build and push your image to GitHub Container Registry.

## Prerequisites
- [Docker](https://docs.docker.com/get-docker/) (Ensure Docker is installed and running)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Visual Studio Code (VSCode)](https://code.visualstudio.com/) with PHP extensions for debugging
- Basic knowledge of Docker and PHP development

## Getting Started

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/<your-github-username>/<repository-name>.git
   cd <repository-name>
   ```
2. Create a .env File:

A sample .env file is provided. Ensure the file is in the repository root (this file contains simple development credentials):

```dotenv
MYSQL_ROOT_PASSWORD=guidestar
MYSQL_DATABASE=wordpress
MYSQL_USER=guidestar
MYSQL_PASSWORD=guidestar
```

3. Build and Start the Containers:

Run the following command to build the custom WordPress image and start the containers:

```bash
docker-compose up --build
```

4. Access the WordPress Site:

Once the containers are running, access your WordPress installation at http://localhost:8000.

## Configuration

### Docker Compose & Dockerfile

- docker-compose.yml: Defines the wordpress and db (MySQL) services. It maps local directories (like wp-content) for real-time development and includes environment variables from the .env file.
Dockerfile: Extends the official WordPress image by installing X-Debug and Composer. It also installs WordPress stubs (via composer.json) to aid development in VSCode.
custom-php.ini: Contains PHP and X-Debug settings. Adjust the xdebug.client_host as needed (e.g., use host.docker.internal for Docker for Mac/Windows).
VSCode Debugging Setup
Install the PHP Debug extension.
Ensure your VSCode launch configuration (.vscode/launch.json) is set to listen on port 9003 (or adjust according to your custom-php.ini).
Composer Dependencies
composer.json: Defines the requirement for WordPress stubs (php-stubs/wordpress) to enable autocompletion and inline documentation in your IDE.
Run composer install during the Docker build to fetch the stubs.
Usage
Editing Code
Edit your themes or plugins in the mounted wp-content folder. Changes will be reflected immediately in the container.
Debugging with X-Debug
With the container running and X-Debug enabled, set breakpoints in VSCode and start a debugging session.
Make sure that the xdebug.client_host in custom-php.ini points to your development machine.
Database Persistence
The MySQL container uses a Docker volume (db_data) to persist data between container restarts.
Publishing to GitHub Container Registry
A helper script (publish.sh) is provided to build and push your Docker image to the GitHub Container Registry.

Ensure You Are Logged In:

```bash
docker login ghcr.io
```

@TODO: Complete Formatting & README file


Update the Script:

Open publish.sh and replace <your-github-username> with your actual GitHub username.

Build and Push the Image:

bash
Copy
./publish.sh
This script builds the Docker image tagged as ghcr.io/<your-github-username>/wordpress-xdebug:latest and pushes it to the registry.

Troubleshooting
Container Build Issues:
Ensure Docker is running and you have internet access to pull the necessary base images.

X-Debug Connection Issues:
Verify that the xdebug.client_host setting in custom-php.ini is correctly configured to point to your host machine.
Check that VSCode is listening on the same port defined in your configuration.

Volume Issues:
If changes to wp-content aren’t showing up, confirm that the volume mapping in docker-compose.yml is correct and that you are editing the correct directory.

Contributing
Contributions are welcome! Please fork the repository and submit pull requests. For any major changes, please open an issue first to discuss what you would like to change.

License
This project is licensed under the MIT License.

yaml
Copy

---

This **README.md** should help developers get up-and-running quickly with the WordPress development environment, detailing both setup and usage steps while referencing each component in the repository.


## Resources ## 

1. https://moruralwater.org/calculator/app/home
