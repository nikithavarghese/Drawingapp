# Drawing App

A web-based drawing application that allows users to create, save, and manage their digital artwork through a simple and intuitive interface.

## Description

Drawing App is a PHP-based web application that enables users to create digital drawings using various shapes and colors. Users can register for an account, log in, create drawings with different shapes (rectangles, squares, circles, triangles, and lines), save their artwork, view their collection, and manage their creations.

## Features

- **User Authentication**
  - User registration with email
  - Secure login system
  - Password hashing for security

- **Drawing Interface**
  - Multiple shape options (Line, Rectangle, Square, Circle, Triangle)
  - Color picker for customization
  - Canvas for drawing
  - Clear and undo functionality

- **Drawing Management**
  - Save drawings with custom names
  - View all saved drawings
  - Delete unwanted drawings
  - View individual drawings in detail

- **Responsive Design**
  - Mobile-friendly interface
  - Adapts to different screen sizes

## Technologies Used

- **Frontend**
  - HTML5
  - CSS3
  - JavaScript
  - Canvas API

- **Backend**
  - PHP
  - MySQL

- **Tools & Environment**
  - Visual Studio Code
  - XAMPP
  - phpMyAdmin

## Requirements

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Web server (Apache/Nginx)
- Modern web browser

## Installation and Setup

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/yourusername/drawingapp.git
   ```

2. **Database Setup:**
   - Start XAMPP and ensure Apache and MySQL services are running
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `drawing`
   - The application will automatically create the required tables on first run

3. **Configure Database Connection:**
   - Open `db_config.php` and verify the database settings:
     ```php
     $db_host = "localhost";
     $db_user = "root";
     $db_pass = "";
     $db_name = "drawing";
     ```
   - Update these settings if needed for your environment

4. **Deploy Files:**
   - Move all files to your web server's document root (e.g., htdocs folder in XAMPP)
   - Alternatively, create a subdirectory and configure your web server accordingly

5. **Access the Application:**
   - Open your browser and navigate to `http://localhost/drawingapp`
   - You should see the home page of the Drawing App

## Usage

1. **Register and Login:**
   - Create a new account from the registration page
   - Log in with your credentials

2. **Creating a Drawing:**
   - Select a shape from the dropdown menu
   - Choose a color using the color picker
   - Click and drag on the canvas to create shapes
   - Use the "Undo" button to remove the last shape
   - Use the "Clear" button to start over

3. **Saving and Viewing Drawings:**
   - Enter a name for your drawing
   - Click "Save Drawing" to store your creation
   - View all your drawings in the "View My Drawings" section
   - Click on a drawing to view it in detail
   - Delete unwanted drawings as needed

## Project Structure

```
drawing-app/
├── index.php          # Home page
├── register.php       # User registration
├── login.php         # User authentication
├── draw.php          # Drawing interface
├── view_drawing.php  # View and manage drawings
├── confirmation.php  # Drawing save confirmation
├── delete_drawing.php # Delete drawings
├── db_config.php     # Database configuration
├── script.js         # Drawing functionality
├── style.css         # Application styling
└── logout.php        # User logout
```

## Author

Nikitha Varghese

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.