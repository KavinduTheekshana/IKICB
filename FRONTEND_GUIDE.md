# Frontend User Interface Guide - IKICB LMS

## Overview

A modern, minimal, and responsive frontend interface has been created for students to browse courses, enroll, make payments, and access their learning content.

## Design Principles

- **Modern & Minimal**: Clean design with focus on content
- **Responsive**: Mobile-first approach, works on all devices
- **Tailwind CSS**: Utility-first CSS framework for rapid development
- **Accessible**: Semantic HTML and ARIA labels
- **Fast**: Optimized for performance

## Frontend Structure

### Pages Created

#### 1. **Home Page** (`/`)
- Hero section with call-to-action
- Featured courses grid
- Features section
- Responsive layout

**Route**: `route('home')`
**File**: [resources/views/frontend/home.blade.php](resources/views/frontend/home.blade.php)

#### 2. **Courses Listing** (`/courses`)
- Grid layout of all published courses
- Course cards with thumbnails
- Pagination support
- Hover effects and transitions

**Route**: `route('courses.index')`
**File**: [resources/views/frontend/courses/index.blade.php](resources/views/frontend/courses/index.blade.php)

#### 3. **Course Details** (`/courses/{course}`)
- Course header with banner
- Module listing with lock/unlock status
- Sidebar with purchase options
- Two purchase modes:
  - Buy full course
  - Buy module-wise
- Enrollment status display

**Route**: `route('courses.show', $course)`
**File**: [resources/views/frontend/courses/show.blade.php](resources/views/frontend/courses/show.blade.php)

#### 4. **Module View** (`/courses/module/{module}`)
- Video player integration (Bunny CDN)
- PDF materials download section
- MCQ practice questions
- Theory exam papers
- Upload answer functionality
- Module navigation sidebar
- Progress tracking

**Route**: `route('courses.module', $module)`
**File**: [resources/views/frontend/courses/module.blade.php](resources/views/frontend/courses/module.blade.php)

#### 5. **Student Dashboard** (`/dashboard`)
- Quick stats (enrolled courses, unlocked modules, total spent)
- Continue learning section
- Recent payments history
- Navigation tabs
- Clean card-based layout

**Route**: `route('dashboard')`
**File**: [resources/views/frontend/dashboard/index.blade.php](resources/views/frontend/dashboard/index.blade.php)

#### 6. **Payment Checkout** (`/payment/course/{course}` or `/payment/module/{module}`)
- Order summary
- Secure payment form
- PayHere integration
- SSL security badges
- Cancel and return options

**Route**: `route('payment.course', $course)` or `route('payment.module', $module)`
**File**: [resources/views/frontend/payment/checkout.blade.php](resources/views/frontend/payment/checkout.blade.php)

#### 7. **About Page** (`/about`)
- Company information
- Mission and vision
- Benefits and features

**Route**: `route('about')`
**File**: [resources/views/frontend/about.blade.php](resources/views/frontend/about.blade.php)

#### 8. **Contact Page** (`/contact`)
- Contact information
- Support hours
- Address details

**Route**: `route('contact')`
**File**: [resources/views/frontend/contact.blade.php](resources/views/frontend/contact.blade.php)

## Layout Components

### Main Layout (`layouts/app.blade.php`)

Features:
- **Navigation Bar**
  - Logo
  - Main menu (Home, Courses, About, Contact)
  - User menu (Dashboard/Login)
  - Responsive mobile menu

- **Flash Messages**
  - Success (green)
  - Error (red)
  - Warning (yellow)
  - Info (blue)

- **Footer**
  - Quick links
  - Contact information
  - Copyright notice

## Color Scheme

Primary colors used:
- **Indigo**: Primary brand color (#4F46E5)
- **Gray**: Neutral backgrounds and text
- **Green**: Success states
- **Red**: Error states
- **Yellow**: Warning states

## Key Features

### 1. Course Browsing
- Browse all published courses
- View course details
- See module structure
- Check pricing options

### 2. Enrollment System
- View enrollment status
- Access unlocked content
- Track progress

### 3. Payment Integration
- Secure checkout flow
- PayHere gateway integration
- Order summary
- Payment confirmation

### 4. Module Access Control
- Locked/unlocked indicators
- Module-wise purchasing
- Sequential unlock system

### 5. Learning Interface
- Video player
- PDF downloads
- MCQ questions
- Theory exam uploads

### 6. Dashboard
- Overview statistics
- Recent activity
- Quick access to courses
- Payment history

## User Flows

### New Student Journey
1. Visit home page
2. Browse courses
3. View course details
4. Login/Register
5. Purchase (full or module-wise)
6. Complete payment via PayHere
7. Access enrolled course
8. Start learning

### Existing Student Journey
1. Login
2. View dashboard
3. Continue learning
4. Access unlocked modules
5. Watch videos
6. Download materials
7. Take assessments

## Responsive Breakpoints

- **Mobile**: < 640px
- **Tablet**: 640px - 1024px
- **Desktop**: > 1024px

All pages are fully responsive and optimized for all screen sizes.

## Icons

Using Heroicons (outline and solid variants) for consistent iconography throughout the interface.

## Typography

- **Headings**: Bold, clear hierarchy
- **Body**: Readable font sizes
- **Line height**: Optimized for readability

## Animations & Transitions

Subtle animations for:
- Hover states
- Button clicks
- Card interactions
- Page transitions

## Accessibility

- Semantic HTML5 elements
- ARIA labels where needed
- Keyboard navigation support
- Screen reader friendly
- Color contrast compliance

## Browser Support

- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)

## Performance Optimizations

1. **Image Optimization**: Lazy loading for images
2. **CSS**: Tailwind CSS with PurgeCSS for minimal bundle size
3. **JavaScript**: Minimal JS usage
4. **Caching**: Browser caching enabled
5. **CDN**: Use CDN for video content

## Frontend Routes Summary

| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | Home page |
| `/courses` | GET | All courses |
| `/courses/{course}` | GET | Course details |
| `/courses/module/{module}` | GET | Module content |
| `/dashboard` | GET | Student dashboard |
| `/dashboard/my-courses` | GET | My courses |
| `/dashboard/payments` | GET | Payment history |
| `/payment/course/{course}` | POST | Initiate course payment |
| `/payment/module/{module}` | POST | Initiate module payment |
| `/payment/return` | GET | Payment success |
| `/payment/cancel` | GET | Payment cancelled |
| `/payment/notify` | POST | PayHere webhook |
| `/about` | GET | About page |
| `/contact` | GET | Contact page |

## Controllers

### HomeController
- `index()`: Display home page with featured courses
- `about()`: Display about page
- `contact()`: Display contact page

### CourseController
- `index()`: List all published courses
- `show(Course $course)`: Show course details
- `module(Module $module)`: Show module content (requires access)

### DashboardController
- `index()`: Student dashboard overview
- `myCourses()`: List enrolled courses
- `payments()`: Payment history

### PaymentController
- `initiateCoursePayment(Course $course)`: Start course payment
- `initiateModulePayment(Module $module)`: Start module payment
- `notify(Request $request)`: Handle PayHere webhook
- `return(Request $request)`: Handle successful payment
- `cancel(Request $request)`: Handle cancelled payment

## Customization Guide

### Changing Colors

Edit Tailwind config or use utility classes:
- Primary: `bg-indigo-600`, `text-indigo-600`
- Change to any Tailwind color

### Adding New Pages

1. Create route in `routes/web.php`
2. Create controller method
3. Create blade view in `resources/views/frontend/`
4. Extend `layouts/app.blade.php`

### Modifying Navigation

Edit navigation in [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php)

### Flash Messages

Use session flash in controllers:
```php
return redirect()->route('dashboard')
    ->with('success', 'Payment successful!');
```

Types: `success`, `error`, `warning`, `info`

## Security Features

1. **CSRF Protection**: All forms include CSRF tokens
2. **Authentication**: Protected routes use auth middleware
3. **Authorization**: Access control for module content
4. **Payment Security**: PayHere hash verification
5. **XSS Protection**: Laravel's blade escaping

## Testing the Frontend

### Manual Testing Checklist

- [ ] Home page loads correctly
- [ ] Courses list displays published courses
- [ ] Course details show modules
- [ ] Payment flow works end-to-end
- [ ] Dashboard displays user data
- [ ] Module content loads for unlocked modules
- [ ] Access control prevents unauthorized access
- [ ] Responsive on mobile devices
- [ ] All links work correctly
- [ ] Flash messages display properly

### Test Users

Use seeded users:
- **Student**: student@ikicb.com / password

## Common Issues & Solutions

### Issue: Images not displaying
**Solution**: Run `php artisan storage:link`

### Issue: Styles not loading
**Solution**: Run `npm run build`

### Issue: Payment fails
**Solution**: Check PayHere credentials in `.env`

### Issue: Access denied to modules
**Solution**: Ensure user has unlocked the module (payment completed)

## Future Enhancements

Potential features to add:
- Search functionality
- Course ratings and reviews
- Wishlist feature
- Course progress tracking
- Certificate generation
- Discussion forums
- Live chat support
- Video playback tracking
- Mobile app

## Support

For frontend issues:
1. Check browser console for errors
2. Verify routes are correctly defined
3. Check controller logic
4. Ensure views are properly structured
5. Review [LMS_DOCUMENTATION.md](LMS_DOCUMENTATION.md) for system architecture

## Credits

- **Design**: Modern minimal design with Tailwind CSS
- **Icons**: Heroicons
- **Framework**: Laravel 12 + Blade templating
- **Payment**: PayHere Gateway

---

**Last Updated**: December 2025
