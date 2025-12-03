# 🎓 EduManage Pro - Modern School Management Platform

[![license](https://img.shields.io/badge/license-AGPL-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)
[![php](https://img.shields.io/badge/php-8.1+-brightgreen.svg?logo=php)](https://www.php.net)
[![laravel](https://img.shields.io/badge/laravel-10.x-orange.svg?logo=laravel)](https://laravel.com)
[![tailwind](https://img.shields.io/badge/tailwind-3.x-38bdf8.svg?logo=tailwind-css)](https://tailwindcss.com)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](http://makeapullrequest.com)

**EduManage Pro** is a next-generation, enterprise-grade school management platform built with modern web technologies. Designed for educational institutions seeking a comprehensive, secure, and user-friendly solution to manage all aspects of school operations.

## 🌟 What Makes This Different

This is not just another school management system. **EduManage Pro** has been completely reimagined and rebuilt from the ground up with:

- 🏗️ **Modern Architecture** - Service-Repository pattern, Event-Driven design
- 🎨 **Beautiful UI/UX** - Tailwind CSS, Alpine.js, responsive design
- 📱 **Mobile-First** - PWA support, works offline
- 🔐 **Enterprise Security** - 2FA, Role-based access, audit logs
- 📊 **Advanced Analytics** - Predictive insights, performance tracking
- 💬 **Real-Time Communication** - Messaging, notifications, parent portal
- 🚀 **High Performance** - Redis caching, optimized queries, queue jobs
- 🧪 **Well Tested** - Unit tests, feature tests, browser tests

## ✨ Key Features Overview

### 👥 Multi-Role Dashboards

#### 🎯 Super Admin Dashboard

- **Real-time Analytics** - Live statistics, enrollment trends, financial overview
- **System Management** - User management, role configuration, system settings
- **Performance Monitoring** - Teacher effectiveness, student progress, attendance rates
- **Report Generation** - Custom reports, data exports, scheduled reports

#### 👨‍🏫 Teacher Dashboard

- **Class Management** - Attendance tracking, grade entry, assignment management
- **Student Analytics** - Performance trends, at-risk student alerts
- **Communication Hub** - Messages, announcements, parent meetings
- **Schedule View** - Daily timetable, upcoming events, exam calendar

#### 👨‍🎓 Student Dashboard

- **Academic Progress** - Grades, assignments, exam schedule
- **Attendance Tracker** - Personal attendance percentage, history
- **Resource Center** - Study materials, assignments, announcements
- **Communication** - Messages from teachers, notifications

#### 👨‍👩‍👧 Parent Portal ⭐ NEW

- **Children Progress** - Real-time updates for multiple children
- **Attendance Monitoring** - Daily attendance notifications
- **Fee Management** - Payment history, pending fees, online payment
- **Direct Communication** - Message teachers, schedule meetings
- **Event Calendar** - School events, parent-teacher meetings, holidays

### 🎓 Academic Management

#### Student Information System

- **Smart Admission** - Online application, document verification, bulk import
- **Profile Management** - Complete student profiles, photos, documents
- **Promotion System** - Automated class promotion, history tracking
- **Performance Analytics** - Grade trends, subject-wise analysis, predictions

#### Examination & Grading

- **Flexible Exam System** - Multiple exam types, custom grading rules
- **Online Examinations** ⭐ NEW - Timed tests, auto-grading, question banks
- **Mark Entry** - Fast grade entry, validation, bulk operations
- **Result Generation** - Automated result processing, rank calculation
- **Report Cards** - Professional templates, multi-language support

### 📊 Advanced Analytics & Reporting ⭐ NEW

- **Attendance Heatmaps** - Visual attendance patterns over time
- **Performance Trends** - Subject-wise progress tracking
- **Predictive Analytics** - At-risk student identification
- **Comparative Analysis** - Class comparisons, teacher effectiveness
- **Custom Dashboards** - Build your own analytics views
- **Export Engine** - PDF, Excel, CSV exports with templates

### 💬 Communication System ⭐ NEW

- **Real-Time Messaging** - Teacher ↔ Student, Teacher ↔ Parent
- **Group Announcements** - Class-wide, school-wide broadcasts
- **File Attachments** - Share documents, images, videos
- **Read Receipts** - Track message delivery and reading
- **Push Notifications** - Email, SMS, in-app notifications
- **Message Archive** - Search, filter, export conversations

### 👔 Human Resource Management

#### Employee Management

- **Complete Profiles** - Personal info, qualifications, documents
- **Attendance Tracking** - Daily attendance, late arrivals, overtime
- **Leave Management** - Leave requests, approval workflow, balance tracking
- **Payroll Integration** - Salary calculation, payment history

### 📅 Smart Timetable Generator ⭐ NEW

- **Automated Scheduling** - AI-powered timetable generation
- **Conflict Detection** - Prevent scheduling conflicts
- **Teacher Availability** - Manage working hours, leave
- **Room Management** - Classroom allocation, resource booking

### 💰 Fee Management

- **Fee Structure** - Flexible fee types, installments, discounts
- **Payment Tracking** - Multiple payment methods, receipts
- **Reminders** - Automated payment reminders via email/SMS
- **Financial Reports** - Collection reports, pending fees, analysis

### 📚 Additional Modules

- **Library Management** - Book catalog, issue/return, fines
- **Transport Management** - Route planning, student assignments, GPS tracking
- **Hostel Management** - Room allocation, mess management, visitor logs
- **Event Management** - School events, calendar, RSVP tracking
- **Gallery** - Photo albums, event galleries
- **Website CMS** - Dynamic front-facing website

## 📸 Screenshots

<div align="center">

### Modern Dashboard Design

![Dashboard](screenshot/ce/dashboard.png)

### Student Profile

![Profile](screenshot/ce/profile-st.png)

### Menu Navigation

![Menu](screenshot/ce/menu.png)

</div>

> More screenshots available in the `screenshot/` directory

## 🚀 Installation

### Prerequisites

Ensure you have the following installed:

- **PHP** >= 8.1
- **Composer** >= 2.0
- **Node.js** >= 16.x & npm
- **MySQL** >= 5.7 or **MariaDB** >= 10.3
- **Redis** (recommended for caching)

**Required PHP Extensions:**

- OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo

### Quick Start (5 minutes)

#### 1. Clone the Repository

```bash
git clone https://github.com/MohammedBelmekki01/school-management-system.git
cd school-management-system
```

#### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

#### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit `.env` and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edumanage_pro
DB_USERNAME=root
DB_PASSWORD=your_password

# Redis (optional but recommended)
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

# Mail settings
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

#### 4. Database Setup

**Option A: Quick Setup with Demo Data** (Recommended for testing)

```bash
php artisan fresh-install --with-data
```

**Option B: Clean Installation**

```bash
php artisan fresh-install
```

**Option C: Manual Setup**

```bash
php artisan storage:link
php artisan migrate
php artisan db:seed

# Optional: Load demo data
php artisan db:seed --class DemoSiteDataSeeder
php artisan db:seed --class DemoAppDataSeeder
```

#### 5. Build Frontend Assets

```bash
# Development build
npm run backend-dev
npm run frontend-dev

# Production build (recommended)
npm run backend-prod
npm run frontend-prod
```

#### 6. Start the Application

```bash
# Development server
php artisan serve

# For queue workers (in another terminal)
php artisan queue:work
```

**Access the application:**

- **Frontend:** http://localhost:8000
- **Admin Panel:** http://localhost:8000/login

### 🔑 Default Credentials

| Role        | Username   | Password |
| ----------- | ---------- | -------- |
| Super Admin | superadmin | super99  |
| Admin       | admin      | demo123  |
| Teacher     | teacher    | demo123  |
| Student     | student    | demo123  |
| Parent      | parent     | demo123  |

**⚠️ IMPORTANT:** Change these passwords immediately in production!

## 🎯 Usage Guide

### For Administrators

1. **Setup Institution** - Configure school details, academic year
2. **Manage Users** - Create teachers, students, parents accounts
3. **Configure Classes** - Setup classes, sections, subjects
4. **Define Roles** - Customize permissions and access levels
5. **Monitor System** - View analytics, generate reports

### For Teachers

1. **Take Attendance** - Mark daily attendance quickly
2. **Enter Grades** - Record exam marks, assignments
3. **Communicate** - Send messages to students/parents
4. **Track Progress** - Monitor student performance
5. **Generate Reports** - Export class reports

### For Students

1. **View Dashboard** - Check grades, attendance, assignments
2. **Download Materials** - Access study materials, notes
3. **Submit Assignments** - Upload homework online
4. **Check Schedule** - View timetable, exam dates
5. **Message Teachers** - Ask questions, seek help

### For Parents

1. **Monitor Children** - Track attendance, grades in real-time
2. **Pay Fees** - Online fee payment and history
3. **Communicate** - Message teachers directly
4. **View Reports** - Download report cards, certificates
5. **Stay Updated** - Receive notifications about events

## 🏗️ Architecture

### Design Patterns Used

```
┌─────────────────────────────────────────┐
│           Presentation Layer            │
│  (Controllers, Views, Livewire)         │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│          Business Logic Layer           │
│  (Services, Actions, DTOs)              │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│           Data Access Layer             │
│  (Repositories, Models)                 │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│              Database                   │
│  (MySQL/MariaDB)                        │
└─────────────────────────────────────────┘
```

### Key Design Principles

- **Service-Repository Pattern** - Separation of concerns
- **Event-Driven Architecture** - Decoupled components
- **SOLID Principles** - Clean, maintainable code
- **RESTful API** - Standard API design
- **Queue Jobs** - Asynchronous processing

## 🔌 API Documentation

### Authentication

```http
POST /api/v2/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

### Endpoints

```http
# Students
GET    /api/v2/students
POST   /api/v2/students
GET    /api/v2/students/{id}
PUT    /api/v2/students/{id}
DELETE /api/v2/students/{id}

# Attendance
POST   /api/v2/attendance/mark
GET    /api/v2/attendance/report

# Analytics
GET    /api/v2/analytics/dashboard
GET    /api/v2/analytics/student/{id}

# Messaging
POST   /api/v2/messages/send
GET    /api/v2/messages/conversations
```

**Full API documentation:** Coming soon with Swagger UI

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage

# Run browser tests
php artisan dusk
```

## 📦 Deployment

### Using Docker

```bash
# Build image
docker build -t edumanage-pro .

# Run container
docker-compose up -d
```

### Using Laravel Forge

1. Connect your server to Forge
2. Create new site
3. Deploy from Git repository
4. Configure environment variables
5. Run deployment script

### Manual Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed instructions.

## 🤝 Contributing

Contributions are welcome and appreciated! Here's how you can contribute:

### Ways to Contribute

1. **Report Bugs** - Open an issue with detailed steps to reproduce
2. **Suggest Features** - Share your ideas for improvements
3. **Submit Pull Requests** - Fix bugs or add features
4. **Improve Documentation** - Help make docs clearer
5. **Write Tests** - Increase test coverage

### Development Workflow

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Write/update tests
5. Commit changes (`git commit -m 'Add amazing feature'`)
6. Push to branch (`git push origin feature/amazing-feature`)
7. Open a Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation
- Keep code DRY and SOLID

## 📋 Roadmap

### Version 2.1 (Q1 2026)

- [ ] Mobile applications (iOS & Android)
- [ ] AI-powered student performance predictions
- [ ] Advanced plagiarism detection
- [ ] Video conferencing integration
- [ ] Blockchain certificates

### Version 2.2 (Q2 2026)

- [ ] Multi-tenant architecture
- [ ] LMS integration (Moodle, Canvas)
- [ ] Biometric attendance
- [ ] Advanced reporting with ML insights
- [ ] WhatsApp notifications integration

### Version 3.0 (Q3 2026)

- [ ] Microservices architecture
- [ ] GraphQL API
- [ ] Real-time collaboration tools
- [ ] Advanced gamification
- [ ] AI chatbot assistant

## 🐛 Known Issues

- [ ] Email notifications may delay during high traffic
- [ ] Report generation for large datasets (>10k records) needs optimization
- [ ] Dark mode needs refinement in some components

See [Issues](https://github.com/MohammedBelmekki01/school-management-system/issues) for the complete list.

## 📄 License

This program is free software: you can redistribute it and/or modify it under the terms of the **GNU Affero General Public License** as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see https://www.gnu.org/licenses/.

**Why AGPL?** [Learn more](https://www.gnu.org/licenses/why-affero-gpl.html)

## 🙏 Credits & Acknowledgments

### Inspiration

This project was inspired by and built upon concepts from various open-source school management systems. The original codebase has been extensively refactored, redesigned, and enhanced with modern features and architecture.

### Special Thanks To

- **Original Contributors** - For providing the foundation to build upon
- **Laravel Community** - For the amazing framework and packages
- **Open Source Community** - For tools, libraries, and inspiration
- **Beta Testers** - For valuable feedback and bug reports

### Built With

- [Laravel](https://laravel.com) - The PHP Framework
- [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS framework
- [Alpine.js](https://alpinejs.dev) - Lightweight JavaScript framework
- [Chart.js](https://www.chartjs.org) - Simple yet flexible charting
- [Livewire](https://laravel-livewire.com) - Full-stack framework for Laravel
- And many more amazing open-source projects

## 💬 Support & Community

- **Documentation:** [Read the Docs](https://github.com/MohammedBelmekki01/school-management-system/wiki)
- **Issues:** [GitHub Issues](https://github.com/MohammedBelmekki01/school-management-system/issues)
- **Discussions:** [GitHub Discussions](https://github.com/MohammedBelmekki01/school-management-system/discussions)
- **Email:** mohammedbelmekki01@example.com

## 📞 Contact

**Mohammed Belmekki**

- GitHub: [@MohammedBelmekki01](https://github.com/MohammedBelmekki01)
- Project Link: [https://github.com/MohammedBelmekki01/school-management-system](https://github.com/MohammedBelmekki01/school-management-system)

---

<div align="center">

### ⭐ Star this repository if you find it helpful!

**Made with ❤️ by Mohammed Belmekki**

</div>

---

## 📚 Additional Resources

- [Installation Guide](docs/INSTALLATION.md)
- [User Manual](docs/USER_MANUAL.md)
- [API Documentation](docs/API.md)
- [Developer Guide](docs/DEVELOPMENT.md)
- [Deployment Guide](docs/DEPLOYMENT.md)
- [Contribution Guidelines](CONTRIBUTING.md)
- [Changelog](CHANGELOG.md)
- [FAQ](docs/FAQ.md)

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
