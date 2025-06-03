# Property Stocking Quick Installation Guide

This guide will help you get the Property Stocking application running on your local computer for development.

## 1. Software You Need First

Make sure you have these installed:

*   **PHP**: A recent version (like 8.2 or newer).
*   **Composer**: To install PHP packages. You can download it from [getcomposer.org](https://getcomposer.org).
*   **Node.js** and **npm**: For frontend parts. You can download them from [nodejs.org](https://nodejs.org) (npm comes with Node.js).
*   **Git**: To get the project code. If you don\'t have it, search for "install git".

## 2. Get the Project Code

1.  Open your terminal or command prompt.
2.  Go to the folder where you want to put the project.
3.  Run this command to copy the project:
    ```bash
    git clone https://github.com/ajchrstnosias/property_stocking.git
    ```
4.  Go into the project folder:
    ```bash
    cd property_stocking
    ```

## 3. Install Project Packages

1.  **Install PHP packages:**
    ```bash
    composer install
    ```
2.  **Install JavaScript packages:**
    ```bash
    npm install
    ```

## 4. Basic Environment Setup

1.  **Copy the example environment file:**
    ```bash
    cp .env.example .env
    ```
    (On Windows, you might use `copy .env.example .env`)

2.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

## 5. Prepare the Database and Assets

1.  **Set up the database tables:**
    ```bash
    php artisan migrate
    ```
2.  **Add initial data(Location, Categories):**
    ```bash
    php artisan db:seed
    ```
3.  **Build frontend assets for development:**
    ```bash
    npm run dev
    ```
    Keep this command running in a terminal. If it asks about a "vite" process, that\'s okay.

## 6. Start the Application

1.  Open a **new** terminal or command prompt in the project folder.
2.  Run this command:
    ```bash
    php artisan serve
    ```
3.  Look for a message like `Server running on [http://127.0.0.1:8000]`. Open this address in your web browser.

You should now see the application! When you are done, you can stop the `npm run dev` and `php artisan serve` commands by pressing `Ctrl+C` in their terminals.