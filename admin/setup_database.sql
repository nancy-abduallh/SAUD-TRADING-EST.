CREATE DATABASE IF NOT EXISTS saud_trading_db;
USE saud_trading_db;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(100),
    full_name VARCHAR(100),
    avatar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS hero_slides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    subtitle VARCHAR(255),
    description TEXT,
    image_url VARCHAR(500),
    cta_text VARCHAR(100),
    cta_link VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    icon VARCHAR(100),
    image_url VARCHAR(500),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    logo_url VARCHAR(500),
    website_url VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    logo_url VARCHAR(500),
    description TEXT,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100),
    client_position VARCHAR(100),
    client_company VARCHAR(100),
    content TEXT,
    avatar_url VARCHAR(500),
    rating TINYINT DEFAULT 5,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT,
    answer TEXT,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(100),
    value VARCHAR(50),
    icon VARCHAR(100),
    suffix VARCHAR(50),
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS about_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    image_url VARCHAR(500),
    mission TEXT,
    vision TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contact_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(50),
    email VARCHAR(100),
    address TEXT,
    map_url TEXT,
    working_hours VARCHAR(255),
    whatsapp VARCHAR(50),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(50),
    subject VARCHAR(255),
    message TEXT,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT,
    action VARCHAR(100),
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS sectors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    english_name VARCHAR(100),
    description TEXT,
    image_url VARCHAR(500),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sector_id INT,
    category VARCHAR(100),
    name VARCHAR(255),
    description TEXT,
    image_url VARCHAR(500),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sector_id) REFERENCES sectors(id) ON DELETE CASCADE
);

-- Insert default admin
INSERT IGNORE INTO admins (username, password, email, full_name) VALUES
('admin', '$2y$10$8K1p/a0dL1LXMIgoEDFrwOfMQbLgch7tMQc3POeRaOb3pV1m6qUHa', 'admin@saud-trading.com', 'System Administrator');

-- Insert sample sectors
INSERT INTO sectors (title, english_name, description, sort_order) VALUES
('الغذاء', 'food', 'توفير منتجات غذائية عالية الجودة', 1),
('البلاستيك', 'plastics', 'حلول بلاستيكية مبتكرة ومستدامة', 2),
('الحلول الرقمية', 'digital', 'أحدث التقنيات والحلول الرقمية للأعمال', 3);

-- Insert sample stats
INSERT INTO stats (label, value, icon, suffix, sort_order) VALUES
('سوقاً دولياً', '45', 'fa-solid fa-globe', '+', 1),
('ألف طن سنوياً', '120', 'fa-solid fa-weight-scale', '', 2),
('قطاعات رئيسية', '3', 'fa-solid fa-layer-group', '', 3),
('متابعة التوريد', '24/7', 'fa-solid fa-clock-rotate-left', '', 4);

-- Insert about content
INSERT INTO about_content (title, description, mission, vision) VALUES
('مؤسسة سعود التجارية', 'نحن رواد في مجال التجارة والتوريد', 'مهمتنا تقديم أفضل المنتجات', 'رؤيتنا أن نكون الخيار الأول في المنطقة');

-- Insert contact info
INSERT INTO contact_info (phone, email, address, working_hours, whatsapp) VALUES
('+966 123 456 789', 'info@saud-trading.com', 'المملكة العربية السعودية، الرياض', 'من الأحد إلى الخميس: 8 صباحاً - 5 مساءً', '+966 123 456 789');

-- Insert site settings
INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'مؤسسة سعود التجارية'),
('site_tagline', 'الريادة في التجارة والتوريد'),
('seo_description', 'مؤسسة سعود التجارية - رائدة في مجال الاستيراد والتصدير والمقاولات العامة والحلول التقنية المبتكرة على مستوى المنطقة.'),
('seo_keywords', 'تجارة, مقاولات, حلول تقنية, استيراد, تصدير, السعودية'),
('facebook_url', '#'),
('twitter_url', '#'),
('linkedin_url', '#'),
('instagram_url', '#');

-- Insert sample hero slides
INSERT INTO hero_slides (title, subtitle, description, cta_text, cta_link, sort_order) VALUES
('مؤسسة سعود التجارية', 'الريادة في التجارة', 'نقدم أفضل الحلول لعملائنا في مختلف القطاعات.', 'اكتشف خدماتنا', '#services', 1),
('قطاع الأغذية', 'جودة عالمية', 'نوفر أفضل المنتجات الغذائية بأعلى معايير الجودة والتخزين.', 'المزيد', '#sectors', 2),
('الحلول الرقمية', 'مستقبل الأعمال', 'نواكب التطور التقني لتقديم حلول مبتكرة تدعم نمو أعمالك.', 'تواصل معنا', '#contact', 3);
