# HomeFix Engineers

A PHP & MySQL household services platform with role-based access control.

## Features

- **Admin Dashboard**: Manage engineers, clients, and service requests
- **Client Portal**: View assigned engineers and service requests
- **Engineer Dashboard**: Manage assigned clients and tasks
- **Role-Based Access Control**: Secure role-based authentication
- **Responsive Design**: Built with Tailwind CSS for a professional layout

## Technology Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS (Tailwind CSS), JavaScript
- **Authentication**: PHP Sessions with secure password hashing

## Project Structure

```
├── admin/          # Admin dashboard and management pages
├── client/         # Client-side pages
├── engineer/       # Engineer-side pages
├── config/         # Database configuration
├── database/       # Database schema
├── includes/       # Reusable components (header, footer, auth)
├── assets/         # CSS and static files
└── [root files]    # Authentication and main pages
```

## Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/household-services.git
   cd household-services
   ```

2. Configure the database:
   - Update `config/db.php` with your database credentials

3. Import the database schema:
   ```bash
   mysql -u username -p database_name < database/schema.sql
   ```

4. Set up a local web server (PHP 7.0+):
   ```bash
   php -S localhost:8000
   ```

5. Access the application at `http://localhost:8000`

## Default Login Credentials

- **Username**: `admin` / **Password**: `admin123` (Admin)
- **Username**: `client1` / **Password**: `pass123` (Client)
- **Username**: `engineer1` / **Password**: `pass123` (Engineer)

## File Structure

- `index.php` - Home page
- `login.php` - User login
- `signup.php` - User registration
- `contact.php` - Contact page
- `admin/` - Admin panel pages
- `client/` - Client pages
- `engineer/` - Engineer pages
- `includes/` - Reusable PHP components
- `config/` - Configuration files
- `database/` - Database schema and setup

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

Created as a household services management system.
