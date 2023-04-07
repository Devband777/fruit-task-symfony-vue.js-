# Fruit Test
- git clone https://github.com/Devband777/fruit-task-symfony-vue.js-.git
## BackEnd Installation:

### Installation
```
cd backend
composer install
```

### Configuring the Database

Open .env file and  customize this line!
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

Now that your connection parameters are setup, Doctrine can create the db_name database for you:
    ```
    php bin/console doctrine:database:create
    ```
### Migrations: Creating the Database Tables/Schema
    To create the database Tables/Schema, run this command from terminal.
        
        php bin/console make:migration
        
    If everything worked, you should see something like this:

        SUCCESS!

        Next: Review the new migration "migrations/Version20211116204726.php"
        Then: Run the migration with php bin/console doctrine:migrations:migrate

    If you open this file, it contains the SQL needed to update your database! To run that SQL, execute your migrations:
        
        php bin/console doctrine:migrations:migrate
        
    This command executes all migration files that have not already been run against your database. You should run this command on production when you deploy to keep your production database up-to-date.

    Now, for getting all fruits from https://fruityvice.com/ and saving them into local DB (MySQL or PostgreSQL), We will run this command from terminal. 
        
        php bin/console fruits:fetch
        
### Run server
    
    php bin/console server:run
    
## FrontEnd Installation and running:
    
    cd frontend
    npm install
    npm run serve
    
