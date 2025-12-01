# Quick Start Guide - IKICB LMS

## Getting Started in 5 Minutes

### 1. Access Admin Panel
```
URL: http://localhost:8000/admin
Email: admin@ikicb.com
Password: password
```

### 2. Create Your First Course

1. Go to **Course Management → Courses**
2. Click **New Course**
3. Fill in:
   - Title: "Introduction to Web Development"
   - Description: Course overview
   - Instructor: Select from dropdown
   - Full Price: 5000.00 (LKR)
   - Upload thumbnail image
   - Toggle "Published" to ON
4. Click **Create**

### 3. Add Modules to Course

1. After creating course, go to **Modules** tab
2. Click **Create Module**
3. Fill in:
   - Title: "Module 1: HTML Basics"
   - Description: Module overview
   - Order: 1
   - Video URL: Your Bunny video URL
   - Module Price: 1000.00 (for module-wise purchases)
4. Click **Create**

### 4. Add PDF Materials

1. In Module edit page, go to **Materials** section
2. Upload PDF files
3. Each module can have multiple PDFs

### 5. Create Questions

1. Go to **Question Bank → Question Categories**
2. Create category: "HTML Questions"
3. Go to **Question Bank → Questions**
4. Create MCQ:
   - Select category
   - Type: Multiple Choice (MCQ)
   - Question: "What does HTML stand for?"
   - Add 4 options
   - Correct Answer: "HyperText Markup Language"
   - Marks: 1
5. Create Theory Question:
   - Type: Theory
   - Question: "Explain the importance of semantic HTML"
   - Marks: 5

### 6. Assign Questions to Module

1. Edit your module
2. In **Questions** section
3. Select questions from question bank
4. Set order for each question

### 7. Add Theory Exam

1. Go to **Course Management → Theory Exams**
2. Create new exam:
   - Select module
   - Title: "Module 1 Final Exam"
   - Upload PDF exam paper
   - Total marks: 100
3. Students can upload their answers
4. Instructors can grade and provide feedback

### 8. Configure PayHere

1. Get PayHere credentials from https://www.payhere.lk
2. Update `.env`:
```env
PAYHERE_MERCHANT_ID=your_merchant_id
PAYHERE_MERCHANT_SECRET=your_merchant_secret
PAYHERE_SANDBOX=true
```

### 9. Test Enrollments

1. Login as student (student@ikicb.com / password)
2. Browse courses
3. Purchase course or module
4. Access unlocked content

## Important Commands

### Reset Database (Fresh Start)
```bash
php artisan migrate:fresh
php artisan db:seed --class=AdminUserSeeder
```

### Create New User
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'John Instructor',
    'email' => 'john@example.com',
    'password' => Hash::make('password'),
    'role' => 'instructor'
]);
```

### Link Storage
```bash
php artisan storage:link
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## File Upload Limits

If you need to upload large files, update `php.ini`:
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
```

## Common Workflows

### For Admins
1. Create instructors
2. Assign courses to instructors
3. Monitor enrollments
4. View payment reports
5. Manage question bank

### For Instructors
1. Create courses
2. Add modules with videos
3. Upload materials
4. Create/assign questions
5. Grade theory exam submissions

### For Students
1. Browse courses
2. Purchase (full or module-wise)
3. Watch videos
4. Download materials
5. Take MCQ tests
6. Upload theory exam answers
7. View grades

## Next Steps

1. **Customize UI**: Edit Filament resources in `app/Filament/Resources/`
2. **Add Features**: Create new models and resources
3. **Email Notifications**: Configure mail settings
4. **Production Deploy**: Set up on production server with HTTPS

## Support

Check [LMS_DOCUMENTATION.md](LMS_DOCUMENTATION.md) for detailed information.

## Default Users

| Role | Email | Password | Access |
|------|-------|----------|--------|
| Admin | admin@ikicb.com | password | Full system access |
| Instructor | instructor@ikicb.com | password | Course management |
| Student | student@ikicb.com | password | Learning access |

**Remember to change these passwords in production!**
