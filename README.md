#📘 OBS-LMS — Online Learning & Management System

A complete, full-featured Learning Management System built with Laravel, designed for universities, schools, and educational institutions.
It includes dashboards for Admin, Teachers, and Students, with powerful features such as courses, enrollment, attendance, assignments, exams, grades, and notifications.

🚀 Features
🔐 Authentication & Roles
Secure login and registration
3 main roles:
- Admin — Full access & system management
- Teacher — Manage courses, exams, attendance, assignments
- Student — View courses, submit assignments, view grades

🏫 Admin Dashboard
- Manage Departments
- Manage Students
- Manage Teachers
- Manage Courses
- Manage Course Offerings
- Manage Notifications
- Admin analytics dashboard

👨‍🏫 Teacher Dashboard
- View and manage assigned courses
- Upload learning materials
- Create assignments
- Create exams
- Record attendance
- Enter exam results
- View student submissions

👨‍🎓 Student Dashboard
- View enrolled courses
- View assignments and submit solutions
- Take exams
- View grades and exam results
- Track attendance records
- Receive notifications

🧩 System Structure

Models:
- Department, Teacher, Student, Course, CourseOffering, Assignment, Submission, Exam, ExamResult, AttendanceRecord, AttendanceSession, Material, Notification
Controllers:
- Separated by roles → Admin / Teacher / Student
Middleware:
- Role-based authorization
Views:
- Blade templates for all dashboards
Migrations:
- Full database schema (20+ migrations)

🛠️ Technologies Used:
- Laravel 11 | Blade | MySQL | Laravel Breeze | GitHub.

📦 Installation & Setup:
- git clone https://github.com/al-bceriny/OBS-LMS.git
- cd OBS-LMS
- composer install
- npm install
- cp .env.example .env
- DB_DATABASE=obs_system
- DB_USERNAME=root
- DB_PASSWORD=
- php artisan key:generate
- php artisan migrate --seed
- Email: mr@adnan.com
- Password: moHaks
- npm run build
- npm run dev
- php artisan serve
- Open your browser:
👉 http://127.0.0.1:8000
