# IKICB Learning Management System (LMS)

A comprehensive Learning Management System built with Laravel 12 and Filament 3.3 for IKICB.

## Table of Contents

- [Features](#features)
- [System Architecture](#system-architecture)
- [Installation](#installation)
- [User Roles](#user-roles)
- [Core Features](#core-features)
- [Payment Integration](#payment-integration)
- [Database Schema](#database-schema)
- [API Endpoints](#api-endpoints)

## Features

### User Management
- **Three User Roles**: Admin, Instructor, and Student
- Admins can create Instructor and Admin users
- Instructors can create and manage courses

### Course Management
- Create courses with title, description, price, and thumbnail
- Assign instructors to courses
- Publish/unpublish courses
- Support for both full course and module-wise purchases

### Module System
- Each course can have multiple modules
- Modules include:
  - Video content (Bunny video links)
  - PDF materials
  - MCQ questions
  - Theory exams
- Modules have individual pricing for module-wise purchases
- Module ordering for structured learning paths

### Question Bank
- Question Categories for organization
- Two question types:
  - **MCQ (Multiple Choice Questions)**: With options and correct answers
  - **Theory Questions**: Open-ended questions
- Questions can be reused across multiple modules
- Marks allocation per question

### Theory Exams
- Upload PDF exam papers
- Students can upload their answers
- Instructors/Admins can grade submissions
- Feedback system for student submissions

### Payment System
- Integrated with PayHere (http://payhere.lk)
- Currency: LKR (Sri Lankan Rupees)
- Two purchase options:
  - **Full Course**: One-time payment for complete access
  - **Module-wise**: Pay per module to unlock content sequentially
- Payment tracking and transaction history

### Enrollment & Access Control
- Track student enrollments
- Module unlock system for module-wise purchases
- Payment verification and validation

## System Architecture

### Technology Stack
- **Backend**: Laravel 12
- **Admin Panel**: Filament 3.3
- **Database**: MySQL
- **Payment Gateway**: PayHere
- **Video Hosting**: Bunny CDN

### Models & Relationships

```
User (Admin/Instructor/Student)
├── Courses (as instructor)
├── Enrollments
├── Payments
├── ModuleUnlocks
└── TheoryExamSubmissions

Course
├── Instructor (User)
├── Modules
├── Enrollments
└── Payments

Module
├── Course
├── Materials (PDFs)
├── Questions (MCQ/Theory)
├── TheoryExams
├── Unlocks
└── Payments

Question
├── Category
└── Modules (many-to-many)

TheoryExam
├── Module
└── Submissions

Payment
├── User
├── Course
└── Module (optional)
```

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Node.js & NPM

### Setup Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd IKICB
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment configuration**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database in `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ikicb
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Configure PayHere in `.env`**
```env
PAYHERE_MERCHANT_ID=your_merchant_id
PAYHERE_MERCHANT_SECRET=your_merchant_secret
PAYHERE_SANDBOX=true
```

6. **Run migrations**
```bash
php artisan migrate
```

7. **Seed admin users**
```bash
php artisan db:seed --class=AdminUserSeeder
```

8. **Build assets**
```bash
npm run build
```

9. **Start the application**
```bash
php artisan serve
```

10. **Access admin panel**
Navigate to: `http://localhost:8000/admin`

## User Roles

### Default Users (Created by Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ikicb.com | password |
| Instructor | instructor@ikicb.com | password |
| Student | student@ikicb.com | password |

### Role Permissions

#### Admin
- Create users (Instructors and Admins)
- Create and manage all courses
- Manage question bank
- View all enrollments and payments
- Grade theory exam submissions
- Access all system features

#### Instructor
- Create and manage their own courses
- Create modules for their courses
- Upload materials and exam papers
- Grade student submissions
- View enrollments for their courses

#### Student
- Browse and enroll in courses
- Purchase courses (full or module-wise)
- Access unlocked modules
- Take MCQ tests
- Upload theory exam answers
- View grades and feedback

## Core Features

### 1. Course Creation

Admins and Instructors can create courses with:
- Title and description
- Course thumbnail image
- Full course price (LKR)
- Publish status
- Instructor assignment

Navigate to: **Admin Panel → Course Management → Courses → Create**

### 2. Module Management

For each course, create modules with:
- Module title and description
- Order/sequence
- Bunny video URL
- Module price (for module-wise purchases)
- PDF materials
- Questions (MCQ/Theory)
- Theory exams

Navigate to: **Course Edit Page → Modules Tab**

### 3. Question Bank

Create reusable questions:
- Select or create category
- Choose question type (MCQ/Theory)
- Enter question text
- For MCQ: Add options and specify correct answer
- Assign marks

Navigate to: **Admin Panel → Question Bank → Questions → Create**

### 4. Theory Exams

Add theory exams to modules:
- Upload PDF exam paper
- Set total marks
- Students upload answer PDFs
- Instructor grades and provides feedback

Navigate to: **Admin Panel → Course Management → Theory Exams**

### 5. Enrollments

Track student enrollments:
- View enrollment status
- Purchase type (full course/module-wise)
- Enrollment date
- Payment history

Navigate to: **Admin Panel → Enrollments & Payments → Enrollments**

## Payment Integration

### PayHere Configuration

1. **Sign up for PayHere** at https://www.payhere.lk
2. **Get credentials**:
   - Merchant ID
   - Merchant Secret
3. **Configure in `.env`**:
```env
PAYHERE_MERCHANT_ID=your_merchant_id
PAYHERE_MERCHANT_SECRET=your_merchant_secret
PAYHERE_SANDBOX=true  # Set to false for production
```

### Payment Flow

#### Full Course Purchase
1. Student selects "Buy Full Course"
2. System creates payment record
3. Redirects to PayHere
4. After successful payment:
   - Enrollment created
   - All modules unlocked
   - Payment status updated

#### Module-wise Purchase
1. Student selects "Buy This Module"
2. System creates payment record for specific module
3. Redirects to PayHere
4. After successful payment:
   - Module unlocked
   - Can proceed to next module
   - Payment recorded

### Payment Service Usage

```php
use App\Services\PayHereService;

$payHereService = new PayHereService();

// Create course payment
$paymentData = $payHereService->createCoursePayment($userId, $course);

// Create module payment
$paymentData = $payHereService->createModulePayment($userId, $module);

// Handle successful payment notification
$payHereService->handleSuccessfulPayment($payment);
```

## Database Schema

### Key Tables

#### users
- id, name, email, password, role (admin/instructor/student)

#### courses
- id, title, description, instructor_id, full_price, is_published, thumbnail

#### modules
- id, course_id, title, description, order, video_url, module_price

#### questions
- id, question_category_id, type (mcq/theory), question, mcq_options (JSON), correct_answer, marks

#### question_categories
- id, name, description

#### module_materials
- id, module_id, title, file_path, type

#### module_questions (pivot)
- id, module_id, question_id, order

#### theory_exams
- id, module_id, title, description, exam_paper_path, total_marks

#### theory_exam_submissions
- id, theory_exam_id, user_id, submission_file_path, marks_obtained, feedback, status

#### enrollments
- id, user_id, course_id, purchase_type (full_course/module_wise), status

#### payments
- id, user_id, course_id, module_id, amount, currency, payment_gateway, transaction_id, status, payment_details (JSON)

#### module_unlocks
- id, user_id, module_id, payment_id, unlocked_at

## File Storage

### Storage Structure
```
storage/app/public/
├── course-thumbnails/      # Course thumbnail images
├── module-materials/        # PDF materials for modules
├── theory-exam-papers/      # Exam paper PDFs
└── theory-exam-submissions/ # Student answer PDFs
```

### Link Storage
```bash
php artisan storage:link
```

## Admin Panel Navigation

### Course Management
- **Courses**: Create and manage courses
- **Modules**: Manage course modules
- **Theory Exams**: Manage theory exam papers

### Question Bank
- **Question Categories**: Organize questions
- **Questions**: Create MCQ and Theory questions

### Enrollments & Payments
- **Enrollments**: View student enrollments
- **Payments**: Track all transactions

### User Management
- **Users**: Manage all system users

## Development Notes

### Adding New Features

1. **Model**: Create model in `app/Models`
2. **Migration**: Create migration in `database/migrations`
3. **Resource**: Create Filament resource
```bash
php artisan make:filament-resource ModelName --generate
```

### Customizing Filament Resources

Edit files in `app/Filament/Resources/` to customize:
- Form fields
- Table columns
- Filters
- Actions
- Relation managers

## Security Notes

1. **Change default passwords** in production
2. **Set `PAYHERE_SANDBOX=false`** in production
3. **Configure proper file permissions** for storage
4. **Enable HTTPS** for payment processing
5. **Regularly backup database**
6. **Keep Laravel and packages updated**

## Support & Maintenance

### Common Issues

**Issue**: PayHere payment not working
**Solution**: Check merchant credentials and sandbox mode setting

**Issue**: Files not uploading
**Solution**: Run `php artisan storage:link` and check permissions

**Issue**: Can't access admin panel
**Solution**: Run seeder to create admin user

### Logs
Check logs in `storage/logs/laravel.log`

## Future Enhancements

- Student progress tracking
- Certificate generation
- Email notifications
- Assignment submissions
- Discussion forums
- Live classes integration
- Mobile app support
- Advanced reporting

## License

Proprietary - IKICB

## Contact

For support, contact IKICB technical team.
