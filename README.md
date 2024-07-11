# Call Log App

This repository contains a Dockerized PHP application for managing call logs.

## Requirements

- **Docker Desktop for Windows:** Requires Microsoft Hyper-V to be installed and enabled.
- **Docker Desktop for Mac:** Uses HyperKit instead of VirtualBox for virtualization, so there's no need to install VirtualBox separately.

## Installation

1. **Start Containers:**

   - From the root folder, navigate to the `docker` directory:
     ```
     cd docker
     ```
   - Run the following command to start the containers:
     ```
     docker-compose up -d
     ```

2. **Install Dependencies:**

   - Access the `call-log-app` container:
     ```
     docker exec -it call-log-app /bin/bash
     ```
   - Inside the container, install dependencies using Composer:
     ```
     composer install
     ```

3. **Configure Database:**

   - Create a `.env` file in the src directory with the following database settings:
     ```
     DB_HOST=db
     DB_USER=root
     DB_PASS=root
     DB_DATABASE=my_db
     ```

4. **Set Up Database:**

   - Open a database management application and connect to MySQL using:
     - **Username:** root
     - **Password:** root
     - **Port:** 3306
     - **Hostname:** localhost
   - Create a database named `my_db` and import the `call-log.sql` file to create tables.

5. **Run the Application:**
   - Navigate to [http://localhost:8000](http://localhost:8000) in your web browser to access the application.
