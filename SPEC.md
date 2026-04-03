# National College, Nadakakvu - Website Specification

## 1. Project Overview

**Project Name:** National College, Nadakakvu  
**Project Type:** Educational Institution Website with Admin Panel  
**Core Functionality:** A responsive educational website showcasing college information, courses, staff, gallery, and contact details. Includes a secure admin panel for CRUD operations on all dynamic content.  
**Target Users:** Prospective students, current students, parents, and college administrators

## 2. UI/UX Specification

### Layout Structure

**Public Pages:**
- Fixed Navigation Bar (sticky)
- Hero Section (Home page)
- Content Sections (variable based on page)
- Footer with college info

**Admin Panel:**
- Sidebar navigation
- Top header with admin info
- Content area with forms/tables

### Responsive Breakpoints
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

### Visual Design

**Color Palette:**
- Primary: #1e3a5f (Deep Navy Blue)
- Secondary: #2c5282 (Medium Blue)
- Accent: #f6993f (Warm Orange)
- Light: #f7fafc (Off-white)
- Dark: #1a202c (Dark Gray)
- Success: #38a169 (Green)
- Danger: #e53e3e (Red)

**Typography:**
- Headings: 'Playfair Display', serif
- Body: 'Open Sans', sans-serif
- Font sizes: h1: 2.5rem, h2: 2rem, h3: 1.5rem, body: 1rem

**Spacing:**
- Section padding: 80px vertical
- Card padding: 24px
- Container max-width: 1200px

**Visual Effects:**
- Card shadows: 0 4px 20px rgba(0,0,0,0.1)
- Hover transitions: 0.3s ease
- Button hover: darken 10%

### Components

**Navigation:**
- Logo + College name
- Menu items: Home, About, Courses, Staff, Gallery, Contact
- Admin login button
- Mobile: hamburger menu

**Hero Section:**
- Full-width background with overlay
- College name in large text
- Tagline
- CTA buttons (Apply Now, Contact Us)

**Cards (Courses/Staff):**
- Image at top
- Title and subtitle
- Description
- Hover: slight lift effect

**Gallery Grid:**
- Masonry-style or grid layout
- Category tabs
- Lightbox on click

**Floating Buttons:**
- WhatsApp: green button, bottom-right
- Phone: blue button, bottom-right

**Admin Tables:**
- Striped rows
- Action buttons (Edit, Delete)
- Pagination

**Forms:**
- Floating labels
- Validation feedback
- File upload with preview

## 3. Functionality Specification

### Public Website Features

**Home Page:**
- Hero with college name, tagline, and CTAs
- About section with brief intro
- Highlights grid (courses, facilities, achievements)
- Quick contact section

**About Page:**
- College history
- Mission and vision statements
- Principal's message with photo

**Courses Page:**
- Grid of course cards
- Each card shows: name, duration, eligibility, description
- Data fetched from database

**Staff Page:**
- Grid of staff cards
- Photo, name, designation, department
- Data fetched from database

**Gallery Page:**
- Category filter (College, Events, Arts)
- Image grid with lightbox
- Data fetched from database

**Contact Page:**
- Address, email, phone
- Embedded map
- Contact form (optional - stores in DB)

### Admin Panel Features

**Login:**
- Username/password authentication
- Session-based
- Password hashed with bcrypt

**Dashboard:**
- Statistics (total courses, staff, gallery items)
- Quick actions

**Courses Management:**
- List all courses
- Add new course form
- Edit existing course
- Delete course

**Staff Management:**
- List all staff
- Add staff with image upload
- Edit staff details
- Delete staff

**Gallery Management:**
- List all images
- Upload new image with category
- Delete image

### Data Handling
- All data stored in MySQL database
- PDO prepared statements for security
- Images stored in /uploads folder
- Database tables: admin, courses, staff, gallery, contacts

## 4. Database Schema

```sql
-- Admin table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Courses table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    duration VARCHAR(50) NOT NULL,
    eligibility VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Staff table
CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    designation VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Gallery table
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    category ENUM('college', 'events', 'arts') NOT NULL,
    title VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contacts table (for enquiry form)
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 5. Acceptance Criteria

### Visual Checkpoints
- [ ] Navigation is fixed and responsive
- [ ] Hero section displays with overlay and CTAs
- [ ] Cards have hover effects
- [ ] Colors match the blue/white theme
- [ ] Floating WhatsApp and Phone buttons visible
- [ ] Footer displays correctly

### Functional Checkpoints
- [ ] All pages load without errors
- [ ] Courses display from database
- [ ] Staff displays from database with images
- [ ] Gallery shows images by category
- [ ] Admin login works with session
- [ ] CRUD operations work for all entities
- [ ] Images upload correctly
- [ ] Form validation works

### Security Checkpoints
- [ ] PDO prepared statements used
- [ ] Passwords hashed with bcrypt
- [ ] Sessions validated
- [ ] File uploads validated
- [ ] SQL injection prevented