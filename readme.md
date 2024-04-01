# Test Task Setup

This guide provides instructions on how to set up and run the test task project.

## Prerequisites

Before you begin, ensure you have the following:

- Access to an open server with a domain name configured.
- Git installed on your local machine.
- A database manager tool installed for running SQL scripts.

## Getting Started

1. Add your domain to the open server where you'll host the test task project.

2. Clone the repository to your local machine:
   ```sh
   git clone https://github.com/KushnEvhenia/CinArchieve

3. Set up the database:
    Open your database manager tool and connect to your database server.
    Run the provided SQL script (database.sql) in your database manager to create the database and necessary tables.
    Double check if your db username and password are matching those!
    ```sh
    $db = mysqli_connect('localhost', 'root', '', 'Movies');
    #If no write your username in second function argument and password in third
    
4. Running the Project
    Access the project in your web browser using the configured domain:

    https://your-domain.com

