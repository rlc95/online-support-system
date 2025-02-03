<<<<<<< HEAD
# Project Setup Guide

## Prerequisites
Ensure you have the following installed on your system:
- **Git**
- **Node.js** and **npm** (Node Package Manager) or **Yarn**
- **PHP** >= 7.4
- **Node.js** >= 12.x

## Backend Setup

### Clone the Repository
```sh
git clone https://github.com/rlc95/online-support-system
#Open the Project in VS Code.

#Run XAMPP Apache and MySQL Server
#Install PHP Dependencies using Composer

composer install

# Copy the .env.example file to .env and configure your environment variables:
 cp .env.example .env

# Generate the Application Key:
 php artisan key:generate

# Create a Database:
Create a database named online_support_system.
# Update your .env file to use the new database:
DB_DATABASE='online_support_system'

# Import the Database:
# In the project directory, locate the sql folder.
# Use phpMyAdmin to import the SQL file into the online_support_system database.

# Start the Development Server:
 php artisan serve

# Open your Browser and Navigate to:
 http://localhost:8000

# Support Agent want to login using admin-button on nav bar header   http://localhost:8000/login
php artisan db:seed  #you can run the seeder 
Admin username : admin@mail.com
Admin password : 87654321

#if you want, you can register as support ageny 
 http://localhost:8000/register


=======
# online-support-system
>>>>>>> e64a11e2f7b53482e747f4c6e8f5d64b2ab5d5fd
