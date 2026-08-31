# Secure PHP/MySQL Web Application - MKR Motors Website
This was originally a group project for a university module, but I decided to improve it myself with a focus on OWASP vulnerability mitigation techniques.

A security-focused PHP/MySQL web application demonstrating secure coding practices and OWASP vulnerability mitigation techniques.

## Project Overview

This project was developed to showcase:
- Secure database interaction
- SQL Injection prevention
- XSS mitigation
- Input validation
- Secure credential handling
- Defensive web development principles

## Features

### Core Functionality
- **Vehicle Listings** - Browse new and pre-owned cars with detailed information
- **Advanced Search** - Filter vehicles by make, model, condition, price range, and fuel type
- **Test Drive Bookings** - Customers can book test drives directly through the website
- **Contact Form** - Manage customer inquiries and messages
- **Responsive Design** - Works seamlessly on desktop, tablet, and mobile devices

### Security Features
- **Prepared Statements** - SQL injection protection on all database queries
- **Input Validation** - Server-side validation for all user inputs
- **Output Escaping** - XSS protection using `htmlspecialchars()`
- **Environment Variables** - Secure credential storage
- **UTF-8 Encoding** - Prevents character encoding attacks

## Project Structure

```
project/
├── README.md                     # This file
├── SECURITY_FIXES.md            # Detailed security documentation
├── .env.example                 # Environment variables template
├── .gitignore                   # Git ignore rules
├── composer.json                # PHP dependencies (PHPUnit)
│
├── database/
│   └── database.sql             # Database schema and sample data
│
├── includes/
│   ├── connect.php              # Database connection
│   ├── header.php               # Navigation header
│   └── csrf.php                 # CSRF token handling
│
├── public/
│   ├── index.php                # Homepage with featured cars
│   ├── new-cars.php             # New cars listing page
│   ├── preowned-cars.php        # Pre-owned cars listing page
│   ├── search-results.php       # Search results page
│   ├── contact.php              # Contact form
│   ├── book-testdrive.php       # Test drive booking page
│   └── submit-testdrive.php     # Test drive submission handler
│
├── assets/
│   ├── css/
│   │   └── styles.css           # Unified stylesheet
│   ├── js/
│   │   └── form-validation.js   # Client-side form validation
│   └── images/
│       ├── hero.jpg             # Hero banner image
│       ├── banner3.jpg          # Additional banner image
│       └── cars/                # Vehicle images
│
└── tests/
    └── CsrfTest.php             # CSRF protection unit tests
```

## Getting Started

### Prerequisites
- PHP 7.4+ with MySQLi extension
- MySQL 5.7+ or MariaDB
- A local web server (Apache, Nginx, or PHP built-in server)

### Installation

1. **Clone or download the project** to your web server directory

2. **Create the environment file:**
   ```bash
   cp .env.example .env
   ```

3. **Configure database credentials in `.env`:**
   ```
   DB_HOST=localhost
   DB_USER=your_db_user
   DB_PASS=your_db_password
   DB_NAME=mkr_database
   ```

4. **Set up the database:**

   **Option A: Using phpMyAdmin**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `mkr_database`
   - Click "Import" and select `database.sql`
   - Click "Go" to import all tables and data

   **Option B: Using MySQL Command Line**
   ```bash
   mysql -u your_db_user -p < database.sql
   ```

   **Option C: Using MySQL Client**
   ```bash
   mysql -u root -p
   > CREATE DATABASE mkr_database;
   > USE mkr_database;
   > SOURCE database.sql;
   ```

5. **Start your web server** and navigate to `http://localhost/project/public/`

### Testing
This project includes unit tests for core security features.

1. **Install PHPUnit:**
   ```bash
   composer install
   ```
2. **Run Tests:**
   ```bash
   ./vendor/bin/phpunit tests
   ```

## Security

This project has been secured against common web vulnerabilities:

- **SQL Injection** - All queries use prepared statements
- **XSS Attacks** - All output is properly escaped
- **CSRF** - Protected using synchronized tokens in sessions
- **Credential Exposure** - Credentials stored in environment variables

See [SECURITY_FIXES.md](SECURITY_FIXES.md) for detailed information about security implementations.

## Usage

### Browsing Vehicles
1. Navigate to "New Cars" or "Pre-Owned Cars"
2. Use filters to narrow down your search
3. Click "Book Test Drive" on any vehicle

### Booking a Test Drive
1. Select a vehicle and click "Book Test Drive"
2. Fill in your details and preferred date/time
3. Submit the form
4. Confirmation message appears

### Contacting the Dealership
1. Go to the "Contact" page
2. Fill in your name, email, and message
3. Submit the form
4. Your message is stored in the database

### Running a Local Server
```bash
# Using PHP built-in server (run from project root)
php -S localhost:8000 -t public

# Then visit http://localhost:8000
```

## Development

### Key Technologies
- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript
- **Security:** Prepared statements, HTML escaping, environment variables

### Code Standards
- All database queries use prepared statements
- All user input is validated on the server
- All output to HTML is escaped using `htmlspecialchars()`
- CSS is organized by page functionality

### Adding New Features
1. Always use prepared statements for database queries
2. Validate input before use
3. Escape output before displaying in HTML
4. Test with various inputs, including special characters

## Database Schema

The `database.sql` file contains the complete database setup including all tables, relationships, and sample data.

### Tables Included:

**cars** - Vehicle inventory
- car_id (Primary Key)
- licence_plate, make, model, year
- price, fuel_type, status (new/pre-owned)
- description, image
- Includes 15 sample vehicles (9 new, 6 pre-owned)

**customers** - Customer contact information
- customer_id (Primary Key)
- name, email (unique), phone

**test_drives** - Test drive booking requests
- drive_id (Primary Key)
- car_id (Foreign Key → cars)
- full_name, email, phone
- preferred_date, preferred_time, message
- created_at timestamp
- Includes 1 sample test drive

**employees** - Staff management (for future expansion)
- employee_id (Primary Key)
- name, role, email

**sales** - Sales transaction tracking (for future expansion)
- sale_id (Primary Key)
- car_id, customer_id, sold_by (Foreign Keys)
- sale_date, sale_price

## 🐛 Troubleshooting

### "Connection failed" error
- Verify `.env` file has correct database credentials
- Check MySQL server is running
- Ensure database user has correct permissions

### "No cars available" message
- Verify cars table has data
- Check your database connection

### Forms not submitting
- Check browser console for JavaScript errors
- Verify `form-validation.js` is loaded
- Check server error logs


## 📜 License

This project is provided as-is for educational and portfolio purposes.

## ✅ Quality Checklist

- [x] SQL Injection protection
- [x] XSS protection
- [x] CSRF protection via validation
- [x] Input validation (server-side)
- [x] Secure credential storage
- [x] Error handling
- [x] Responsive design
- [x] Code documentation
- [x] README documentation
- [x] Security documentation

---

**Last Updated:** August 31 2026 
