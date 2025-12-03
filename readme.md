# School Management System

[![license](https://img.shields.io/badge/license-AGPL-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)
[![php](https://img.shields.io/badge/php-7.2-brightgreen.svg?logo=php)](https://www.php.net)
[![laravel](https://img.shields.io/badge/laravel-6.x-orange.svg?logo=laravel)](https://laravel.com)

A comprehensive School Management System built with Laravel and PHP 7. This project helps educational institutions manage their daily operations including student admissions, attendance, exams, results, employee management, and much more.

## 📋 Index

- [Features](#features)
- [Installation](#installation)
  - [Prerequisites](#prerequisites)
  - [Setup Instructions](#setup-instructions)
  - [Running the Application](#running-the-application)
- [Usage](#usage)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)
- [Credits](#credits)

## ✨ Features

### Academic Management

- **Academic Year Management**: Setup and manage academic years
- **Academic Calendar**: Configure and view academic calendars
- **Institute Setup**: Configure institute/school details
- **Class & Section Management**: Organize classes and sections
- **Subject & Teacher Management**: Assign subjects and teachers

### Student Management

- **Student Admission**: Handle new student registrations
- **Student Attendance**: Track daily attendance
- **Student Promotion**: Promote students to next classes
- **Exam & Grading**: Configure exam rules and grading systems
- **Marks & Results**: Record and manage student marks and results

### Staff Management

- **Employee Management**: Maintain employee records
- **Employee Attendance**: Track staff attendance
- **Employee Leave Management**: Handle leave requests and approvals

### System Features

- **User & Role Management**: ACL with permission grid
- **User-wise Dashboard**: Customized dashboards based on roles
- **Report Settings**: Configure various reports
- **Dynamic Front Website**: Public-facing website with CMS
- **Photo Gallery**: Manage and display photos
- **Event Management**: Create and manage school events
- **Google Analytics Integration**: Track website analytics
- **User Notifications**: System-wide notification system

## 🚀 Installation

### Prerequisites

- PHP >= 7.2
- MySQL >= 5.6 or MariaDB >= 10.1
- Composer
- Node.js & npm
- Required PHP Extensions:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON

### Setup Instructions

1. **Clone the repository**

   ```bash
   git clone https://github.com/mohammedbelmekki01/school-management-system.git
   cd school-management-system
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Configure environment**

   ```bash
   cp .env.example .env
   ```

   Edit `.env` file and configure your database settings:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=school_db
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Setup the application**

   **Option 1: Quick setup with demo data**

   ```bash
   php artisan fresh-install --with-data
   ```

   **Option 2: Setup without demo data**

   ```bash
   php artisan fresh-install
   ```

   **Option 3: Manual setup**

   ```bash
   php artisan storage:link
   php artisan key:generate --ansi
   php artisan migrate
   php artisan db:seed

   # Optional: Load demo data
   php artisan db:seed --class DemoSiteDataSeeder
   php artisan db:seed --class DemoAppDataSeeder
   ```

5. **Install and compile frontend assets**

   ```bash
   npm install
   npm run backend-prod
   npm run frontend-prod
   ```

### Running the Application

Start the development server:

```bash
php artisan serve
```

The application will be available at:

- **Website**: http://localhost:8000
- **Admin Login**: http://localhost:8000/login

#### Default Credentials

| Username   | Password |
| ---------- | -------- |
| superadmin | super99  |
| admin      | demo123  |

## 💡 Usage

After logging in, you can:

1. **Configure Institute Settings**: Set up your school/institute details
2. **Create Academic Year**: Define the current academic year
3. **Add Classes & Sections**: Create class structures
4. **Register Students**: Add new student admissions
5. **Manage Attendance**: Track daily attendance for students and staff
6. **Conduct Exams**: Set up exams and record marks
7. **Generate Reports**: Access various academic and administrative reports

## 📸 Screenshots

![Dashboard](screenshot/ce/dashboard.png)

More screenshots available in the `screenshot/ce/` directory.

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.

**Why AGPL?** [Read Here](https://www.gnu.org/licenses/why-affero-gpl.html)

## 🙏 Credits

This project is a fork of the CloudSchool project originally created by [H.R. Shadhin](https://github.com/hrshadhin).

Special thanks to all contributors of the original project:

- [H.R. Shadhin](https://github.com/hrshadhin)
- [Ashutosh Das](https://github.com/pyprism)
- [order4adwriter](https://github.com/order4adwriter)
- [Zahid Irfan](https://github.com/zahidirfan)
- [Oshane Bailey](https://github.com/b4oshany)

## 📞 Contact

Mohammed Belmekki - [@mohammedbelmekki01](https://github.com/mohammedbelmekki01)

Project Link: [https://github.com/mohammedbelmekki01/school-management-system](https://github.com/mohammedbelmekki01/school-management-system)

---

**Note**: This is a fork and modification of the original CloudSchool project. All credit for the original work goes to the original authors and contributors.
