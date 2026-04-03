-- Sample Data for National College, Nadakakvu

-- Insert sample courses
INSERT INTO courses (name, duration, eligibility, description) VALUES 
('Bachelor of Science (B.Sc. Computer Science)', '3 Years', '10+2 with Mathematics/Computer Science', 'A comprehensive program covering software development, algorithms, data structures, web technologies, and database management. Students gain hands-on experience with modern programming languages and industry tools.'),
('Bachelor of Science (B.Sc. Mathematics)', '3 Years', '10+2 with Mathematics', 'An intensive program focusing on pure and applied mathematics including algebra, calculus, statistics, and numerical methods. Prepares students for research and careers in analytics and finance.'),
('Bachelor of Commerce (B.Com)', '3 Years', '10+2 with Commerce/Mathematics', 'Comprehensive commerce education covering accounting, economics, business law, taxation, and financial management. Ideal for students aspiring to become chartered accountants or business professionals.'),
('Bachelor of Arts (B.A. English)', '3 Years', '10+2 in any stream', 'A literature-focused program exploring English language, literature, creative writing, and communication skills. Develops critical thinking and prepares students for careers in media, teaching, and writing.'),
('Bachelor of Business Administration (BBA)', '3 Years', '10+2 in any stream', 'A business-focused degree covering management principles, marketing, human resources, entrepreneurship, and business analytics. Provides a strong foundation for leadership roles.');

-- Insert sample staff
INSERT INTO staff (name, designation, department, image) VALUES 
('Dr. Rajesh Kumar', 'Principal', 'Administration', NULL),
('Prof. Anitha Menon', 'Head of Department', 'Computer Science', NULL),
('Dr. Santhosh Nair', 'Associate Professor', 'Mathematics', NULL),
('Ms. Priya Sharma', 'Assistant Professor', 'Commerce', NULL),
('Dr. James Peter', 'Associate Professor', 'English', NULL),
('Prof. Meera Thomas', 'Assistant Professor', 'Computer Science', NULL);

-- Insert sample gallery images (using placeholder URLs - in production these would be local files)
INSERT INTO gallery (image_path, category, title) VALUES 
('college1.jpg', 'college', 'Main Building'),
('college2.jpg', 'college', 'Library'),
('college3.jpg', 'college', 'Computer Lab'),
('event1.jpg', 'events', 'Annual Day'),
('event2.jpg', 'events', 'Sports Day'),
('arts1.jpg', 'arts', 'Cultural Festival'),
('arts2.jpg', 'arts', 'Art Exhibition');

-- Create admin user (username: admin, password: admin123)
-- Using bcrypt hash
INSERT INTO admin (username, password) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE username = username;