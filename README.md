# Hostel Management System

## Installation

### Prerequisites

* PHP 7.4+
* MySQL 5.7+
* Apache  web server

### 1. Clone the repository

```bash
git clone https://github.com/khadka-123/Hostel_management_System.git
cd Hostel_management_System
```

### 2. Configure the database

1. Create a MySQL database named `hostel_db`.
2. Import the schema:

   ```bash
   mysql -u root -p hostel_db < schema.sql
   ```

### 3. Update configuration

* Open `connection.php` and set your MySQL credentials:

  ```php
  <?php
  $dbHost = 'localhost';
  $dbUser = 'root';
  $dbPass = 'your_password';
  $dbName = 'hostel_db';
  $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
  ?>
  ```

### 4. Deploy to web server

* Place the project folder in your server's document root (e.g., `/var/www/html/`).
* Ensure file permissions allow server read/write for session storage and uploads.

### 5. Access the application

* Student portal: `http://localhost/Hostel_management_System/student/login.php`
* Admin portal: `http://localhost/Hostel_management_System/admin/login.php`

## Usage

### User Dashboard:

* Student registration and login
* View and update personal details
* Track parcel status
* Submit leave requests

### Admin Dashboard:

* Manage student records and profiles
* Review and approve leave requests
* Track and update parcel delivery
* Assign rooms and manage room vacancies


## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m 'Add feature'`)
4. Push to branch (`git push origin feature/YourFeature`)
5. Open a Pull Request

## License

© 2024 Khadka Baniya
