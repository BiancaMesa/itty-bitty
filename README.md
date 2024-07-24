<p align="center">
<img src="./public/itty_bitty_logo.png" width="400">
</p>

## Itty Bitty 
# A Laravel URL Shortener with Vue and Inertia.js

Welcome to the URL Shortener project! This project is a web application built using Laravel, Vue.js, and Inertia.js. It allows users to shorten URLs, manage their shortened URLs, and view analytics on URL clicks. Users must be registered and logged in to use the URL shortening service.


## Table of Contents

- [Features] (#features)
- [Installation] (#installation)
- [Usage] (#Usage)
- [Project Structure] (#project-structure)
- [Contributing] (#contributing)
- [License] (#license)


## Features
- **User Authentication:** Users can register, log in, and manage their profiles.
- **URL Shortening:** Authenticated users can shorten URLs.
- **URL Management:** Users can view and delete their shortened URLs.
- **Analytics:** Users can view click analytics for their shortened URLs.


## Installation
To get started with this project, follow these steps:
1. **Clone the repository:**   
```git clone https://github.com/BiancaMesa/itty-bitty.git```
2. **Install dependencies:**  
```composer install```
```npm install``
3. **Set up environment variables**
```cp .env.example .env```
```php artisan key:generate```
4. **Configure your database in `.env` file:**  
    ```env
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```
5. **Run migrations:**  
```php artisan migrate```
6. **Build assets:**  
```npm run dev```
7. **Start the development server:**  
```php artisan serve```
8. **Access the application in your browser:**  
    ```
    http://localhost:8000
    ```


## Usage
1. **Register/Login:** Create a new account or log in with existing credentials.
2. **Shorten a URL:** Navigate to the dashboard and enter the original URL and a title to generate a shortened URL.
3. **Manage URLs:** View, copy, or delete your shortened URLs from the dashboard.
4. **View Analytics:** Access the analytics section to see the number of clicks each URL has received.

## Project Structure 
I have build the project with the Laravel starter kit with Vue.js and Inertia.js. 

# Backend 
To develop this project we have decided to create two tables in the database. One with the information of the user and another one with the information of the URLs: the original URL, the title, the shortened URL and its unique key, the number of clicks, and the user_id (which relates both tables). The relation between those tables has been one to many, so one user can have many URLs but each URL is linked to one user. 

A regex has been included in form request to validate that the user puts a valid URL. 



