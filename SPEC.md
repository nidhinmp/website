# National College Website Specification

## Project Overview
- **Project Name**: National College, Nadakakvu - Educational Website
- **Type**: WordPress-based Dynamic Website
- **Core Functionality**: A comprehensive educational institution website with public-facing pages and secure admin panel for content management
- **Target Users**: Prospective students, current students, parents, faculty, and administrators

## UI/UX Specification

### Layout Structure
- **Header**: Fixed navigation with logo, menu links, and quick contact buttons
- **Hero Section**: Full-width hero with college name, tagline, and CTA buttons
- **Content Sections**: Cards-based layout for courses, staff, gallery
- **Footer**: Contact info, quick links, social media icons
- **Floating Buttons**: WhatsApp chat and click-to-call phone buttons

### Responsive Breakpoints
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

### Visual Design

#### Color Palette
- **Primary**: #003366 (Deep Navy Blue)
- **Secondary**: #1a5c99 (Academic Blue)
- **Accent**: #f4a024 (Golden Yellow)
- **Background**: #ffffff (White)
- **Light Background**: #f8f9fa (Off-white)
- **Text Primary**: #333333 (Dark Gray)
- **Text Secondary**: #666666 (Medium Gray)

#### Typography
- **Headings**: 'Poppins', sans-serif
- **Body**: 'Open Sans', sans-serif
- **Hero Title**: 48px (desktop), 32px (mobile)
- **Section Title**: 36px (desktop), 28px (mobile)
- **Card Title**: 20px
- **Body Text**: 16px

#### Spacing System
- Section Padding: 80px vertical (desktop), 40px (mobile)
- Card Padding: 24px
- Container Max Width: 1200px
- Grid Gap: 30px

### Components

#### Navigation
- Logo with college name
- Menu items: Home, About Us, Courses, Staff, Gallery, Contact
- Mobile hamburger menu

#### Hero Section
- Background image with overlay
- College name: "National College, Nadakakvu"
- Tagline: "Empowering Future Leaders"
- CTA Buttons: "Apply Now", "Contact Us"

#### Course Cards
- Course icon/image
- Course name (title)
- Duration badge
- Eligibility info
- Brief description
- Hover: lift effect with shadow

#### Staff Cards
- Photo placeholder
- Name
- Designation
- Department
- Hover: scale effect

#### Gallery
- Category tabs: All, College, Events
- Image grid with lightbox effect

#### Contact Section
- Address card
- Phone number with click-to-call
- Email link
- Embedded Google Map placeholder

#### Floating Buttons
- WhatsApp button (green)
- Phone call button (blue)

## Functionality Specification

### Public Website Pages

#### 1. Home Page
- Hero section with college branding
- Brief intro (dynamic from DB)
- Highlights: courses count, facilities, achievements
- CTA buttons linking to courses/contact

#### 2. About Us Page
- College history section
- Mission statement
- Vision statement
- Principal/management message

#### 3. Courses Page
- Grid of course cards
- Each course shows: name, duration, eligibility, description
- Data fetched from database

#### 4. Staff Page
- Grid of staff cards
- Each staff shows: photo, name, designation, department
- Data fetched from database

#### 5. Gallery Page
- Category filter tabs
- Image gallery with lightbox
- Data fetched from database

#### 6. Contact Page
- College address
- Phone number (click-to-call)
- Email address
- Contact form (stored in DB)

### Admin Panel

#### Authentication
- Login page with username/password
- Session-based authentication
- Password hashing with bcrypt
- Logout functionality

#### Dashboard
- Statistics overview
- Quick links

#### Courses Management (CRUD)
- Add new course form
- Edit existing course
- Delete course
- List all courses

#### Staff Management (CRUD)
- Add new staff with image upload
- Edit staff details
- Delete staff
- List all staff

#### Gallery Management (CRUD)
- Upload images with category
- Edit image category
- Delete images
- List all images

### Database Tables

```sql
-- Admin table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Courses table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    duration VARCHAR(100),
    eligibility VARCHAR(200),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Staff table
CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    designation VARCHAR(100),
    department VARCHAR(100),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Gallery table
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    category VARCHAR(50) DEFAULT 'college',
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact enquiries table
CREATE TABLE enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Acceptance Criteria

### Public Website
- [ ] Home page displays hero with college name and tagline
- [ ] Navigation works on all pages
- [ ] Courses are displayed from database
- [ ] Staff are displayed from database
- [ ] Gallery displays images with category filter
- [ ] Contact page shows all contact information
- [ ] Floating WhatsApp and phone buttons are visible
- [ ] Responsive design works on mobile/tablet/desktop
- [ ] All hover effects and transitions work smoothly

### Admin Panel
- [ ] Login page with authentication
- [ ] Session-based login protection
- [ ] Dashboard with statistics
- [ ] Add/Edit/Delete courses works
- [ ] Add/Edit/Delete staff works
- [ ] Add/Edit/Delete gallery images works
- [ ] All changes reflect on public website in real-time
- [ ] Form validations work properly
- [ ] Image uploads work correctly

### Security
- [ ] Prepared statements used for all queries
- [ ] Passwords hashed with bcrypt
- [ ] Session-based authentication
- [ ] Input validation and sanitization
- [ ] SQL injection prevention

### Performance
- [ ] Pages load quickly
- [ ] Images are optimized
- [ ] Database queries are efficient