-- WARNING: importing this file DROPS and recreates every table (all data is reset).
CREATE DATABASE IF NOT EXISTS saud_trading_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE saud_trading_db;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS activity_log, contact_messages, contact_info, about_content, site_settings,
  faqs, testimonials, brands, clients, countries, stats, comparison_rows, digital_ecosystem,
  site_values, products, categories, sectors, hero_slides, admins;
SET FOREIGN_KEY_CHECKS = 1;

-- ============ SCHEMA ============
CREATE TABLE admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  email VARCHAR(150) NOT NULL DEFAULT '',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE hero_slides (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  subtitle VARCHAR(255) NOT NULL DEFAULT '',
  description TEXT NULL,
  image_url VARCHAR(500) NOT NULL DEFAULT '',
  cta_text VARCHAR(100) NOT NULL DEFAULT '',
  cta_link VARCHAR(255) NOT NULL DEFAULT '',
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE sectors (            -- the 3 business pillars (= "services")
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(50) NOT NULL UNIQUE,
  title VARCHAR(255) NOT NULL,
  english VARCHAR(255) NOT NULL DEFAULT '',
  description TEXT NULL,
  image VARCHAR(500) NOT NULL DEFAULT '',
  image_alt VARCHAR(255) NOT NULL DEFAULT '',
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  sector_id INT UNSIGNED NOT NULL,
  name VARCHAR(255) NOT NULL UNIQUE,
  sort_order INT NOT NULL DEFAULT 0,
  CONSTRAINT fk_cat_sector FOREIGN KEY (sector_id) REFERENCES sectors(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NOT NULL,
  name VARCHAR(255) NOT NULL,
  icon VARCHAR(60) NOT NULL DEFAULT '',
  blurb TEXT NULL,
  image VARCHAR(500) NOT NULL DEFAULT '',
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT fk_prod_cat FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE site_values (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  icon VARCHAR(60) NOT NULL DEFAULT '',
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE digital_ecosystem (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  icon VARCHAR(60) NOT NULL DEFAULT '',
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE comparison_rows (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  label VARCHAR(255) NOT NULL,
  traditional VARCHAR(255) NOT NULL DEFAULT '',
  smart VARCHAR(255) NOT NULL DEFAULT '',
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE clients (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  logo_url VARCHAR(500) NOT NULL DEFAULT '',
  description TEXT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE brands (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  logo_url VARCHAR(500) NOT NULL DEFAULT '',
  website_url VARCHAR(500) NOT NULL DEFAULT '',
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE countries (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  english VARCHAR(255) NOT NULL DEFAULT '',
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE stats (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `value` VARCHAR(100) NOT NULL,
  label VARCHAR(255) NOT NULL,
  icon VARCHAR(60) NOT NULL DEFAULT '',
  suffix VARCHAR(30) NOT NULL DEFAULT '',
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE testimonials (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_name VARCHAR(255) NOT NULL,
  client_position VARCHAR(255) NOT NULL DEFAULT '',
  client_company VARCHAR(255) NOT NULL DEFAULT '',
  content TEXT NULL,
  avatar_url VARCHAR(500) NOT NULL DEFAULT '',
  rating TINYINT NOT NULL DEFAULT 5,
  is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE faqs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  question VARCHAR(500) NOT NULL,
  answer TEXT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE about_content (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL DEFAULT '',
  description TEXT NULL,
  image_url VARCHAR(500) NOT NULL DEFAULT '',
  mission TEXT NULL,
  vision TEXT NULL
) ENGINE=InnoDB;

CREATE TABLE contact_info (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  phone VARCHAR(100) NOT NULL DEFAULT '',
  email VARCHAR(150) NOT NULL DEFAULT '',
  address TEXT NULL,
  map_url VARCHAR(1000) NOT NULL DEFAULT '',
  working_hours VARCHAR(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(50) NOT NULL DEFAULT '',
  subject VARCHAR(255) NOT NULL DEFAULT '',
  message TEXT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE site_settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) NOT NULL UNIQUE,
  setting_value TEXT NULL
) ENGINE=InnoDB;

CREATE TABLE activity_log (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  admin_id INT UNSIGNED NULL,
  action VARCHAR(100) NOT NULL,
  details VARCHAR(500) NOT NULL DEFAULT '',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_log_admin FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============ SEED: everything from site-data ============
INSERT INTO sectors (id, slug, title, english, description, image, image_alt, sort_order) VALUES
(1,'plastics','قطاع اللدائن والبلاستيك','INDUSTRIAL MATERIALS','مواد خام موثقة المواصفات للصناعات التحويلية وحلول التعبئة.','uploads/sectors/plastics-sector.jpg','حبيبات بلاستيكية خام شفافة وخضراء',1),
(2,'food','قطاع المواد الغذائية','FOOD COMMODITIES','سلع غذائية مختارة بعناية من مصادر دولية معتمدة.','uploads/sectors/food-sector.jpg','أرز بسمتي فاخر في وعاء تقليدي',2),
(3,'digital','قطاع الحلول الرقمية','DIGITAL & CREATIVE SERVICES','منظومة رقمية متكاملة مدعومة بالذكاء الاصطناعي لبناء حضورك التجاري وتنميته.','uploads/sectors/hero-globe.jpg','شبكة رقمية عالمية مضيئة',3);

INSERT INTO categories (id, sector_id, name, sort_order) VALUES
(1,1,'بوليمرات خام',1),(2,1,'تعبئة وتغليف',2),(3,1,'حلول صناعية',3),
(4,2,'الأرز والحبوب',1),(5,2,'الزيوت النباتية',2),(6,2,'البقوليات',3),(7,2,'البذور الزيتية',4),
(8,2,'المكسرات',5),(9,2,'الشوكولاتة',6),(10,2,'البن والقهوة',7),
(11,3,'تطوير المواقع',1),(12,3,'التسويق الرقمي',2),(13,3,'الإنتاج الإبداعي',3);

INSERT INTO products (category_id, name, icon, blurb, image, sort_order) VALUES
-- بوليمرات خام
(1,'بوليثيلين عالي الكثافة (HDPE)','Boxes','حبيبات عالية الكثافة لقولبة الحاويات والأنابيب.','uploads/products/hdpe.jfif',1),
(1,'بوليثيلين منخفض الكثافة (LDPE)','Layers','مرونة عالية لأفلام التغليف والأكياس الصناعية.','uploads/products/ldpe.jfif',2),
(1,'بولي بروبلين (PP)','CircleDot','مقاومة حرارية ممتازة للتطبيقات الصناعية والمنزلية.','uploads/products/pp.jfif',3),
-- تعبئة وتغليف
(2,'أفلام تغليف مرنة','Scroll','أفلام أحادية وثلاثية الطبقات بمواصفات تصديرية.','uploads/products/flexible-film.jfif',4),
(2,'أكياس صناعية','ShoppingBag','أكياس نسيجية وشبكية بأحمال تحمل متفاوتة.','uploads/products/industrial-bags.jfif',5),
(2,'عبوات غذائية','Container','عبوات آمنة غذائياً معتمدة من جهات الرقابة الدولية.','uploads/products/food-containers.jfif',6),
-- حلول صناعية
(3,'مركبات بلاستيكية','FlaskConical','خلطات مخصصة حسب متطلبات خط الإنتاج.','uploads/products/plastic-compounds.jfif',7),
(3,'إضافات تصنيع','Beaker','إضافات تحسّن الأداء الحراري والميكانيكي للمنتج.','uploads/products/manufacturing-additives.jfif',8),
(3,'مواد معاد تدويرها','Recycle','حلول مستدامة بمعايير جودة تعادل المواد الخام.','uploads/products/recycled-materials.jfif',9),
-- الأرز والحبوب
(4,'أرز بسمتي ملكي','Wheat','حبة طويلة وعطر مميز من أجود مصادر الاستيراد.','uploads/products/basmati-rice.jfif',10),
(4,'أرز مصري قصير الحبة','Sprout','مثالي للأطباق التقليدية بقوام متماسك.','uploads/products/egyptian-rice.jfif',11),
(4,'قمح وطحين فاخر','Wheat','قمح مطحون بمعايير صارمة لصناعات المخابز.','uploads/products/wheat-flour.jfif',12),
(4,'شعير علف وتصنيع','Sprout','دفعات كبيرة لصناعات الأعلاف والتصنيع الغذائي.','uploads/products/barley.jfif',13),
-- الزيوت النباتية
(5,'زيت زيتون بكر ممتاز','Droplet','استخلاص بارد ونسبة حموضة منخفضة.','uploads/products/olive-oil.jfif',14),
(5,'زيت دوار الشمس','Droplets','نقاء عالٍ ومناسب للاستخدام المنزلي والصناعي.','uploads/products/sunflower-oil.jfif',15),
(5,'زيت الذرة','Droplet','خيار اقتصادي بثبات حراري جيد للقلي.','uploads/products/corn-oil.jfif',16),
(5,'زيت الصويا','Droplets','توريد بالجملة لمصانع التعبئة وإعادة التكرير.','uploads/products/soybean-oil.jfif',17),
(5,'زيت النخيل','Droplet','مواصفات تصديرية لصناعات الأغذية والتصنيع.','uploads/products/palm-oil.jfif',18),
-- البقوليات
(6,'عدس أحمر مصري','Bean','تدرّج لوني موحّد وزمن طبخ قصير.','uploads/products/red-lentils.jfif',19),
(6,'عدس أصفر مقشر','Bean','منتج مقشور بالكامل جاهز للتعبئة الاستهلاكية.','uploads/products/yellow-lentils.jfif',20),
(6,'حمص فاخر','Nut','حبة كاملة ومنتظمة الحجم لأسواق التجزئة.','uploads/products/chickpeas.jfif',21),
(6,'فاصوليا بيضاء','Bean','توريد منتظم بأحجام تعبئة مرنة.','uploads/products/white-beans.jfif',22),
-- البذور الزيتية
(7,'سمسم مقشر','Sprout','نقاء عالٍ ولون موحّد لصناعات الطحينة والحلويات والمخابز.','uploads/products/Hulled-sesame.jfif',23),
(7,'سمسم طبيعي غير مقشر','Sprout','محتوى زيتي مرتفع مناسب للعصر والتصنيع الغذائي.','uploads/products/unhulled-sesame.jfif',24),
(7,'بذور دوار الشمس','Leaf','بذور مفحوصة للتسالي والتعبئة ولاستخلاص الزيوت.','uploads/products/Sunflower-seeds.jfif',25),
(7,'بذور الكتان','Sprout','بذور غنية بالأوميغا 3 لصناعات المخابز والأغذية الصحية.','uploads/products/Flax-seeds.jfif',26),
(7,'حبة البركة','Leaf','بذور معتمدة ونقية للاستخدام الغذائي والعشبي وعصر الزيت.','uploads/products/Black-Cumin.jfif',27),
(7,'بذور اليقطين','Nut','بذور خضراء مقشرة وغير مقشرة لأسواق المكسرات والتسالي.','uploads/products/Pumpkin-seeds.jfif',28),
-- المكسرات
(8,'كاجو (الكاشو)','Nut','أحجام متعددة بدرجات جودة تصديرية للتجزئة والتصنيع.','uploads/products/cashew.jfif',29),
(8,'لوز','Nut','لوز كامل ومقطّع ومبشور بمواصفات مطابقة لمعايير الجودة.','uploads/products/almond.jfif',30),
(8,'فستق حلبي','Nut','فستق بقشره أو مقشر بنكهة غنية ولون أخضر مميز.','uploads/products/Aleppo-pistachio.jfif',31),
(8,'جوز','Nut','أنصاف وأرباع جوز فاتحة اللون لصناعات الحلويات والمخبوزات.','uploads/products/walnut.jfif',32),
(8,'بندق','Nut','بندق نيء ومحمّص مناسب لصناعة الشوكولاتة والحلويات.','uploads/products/hazelnut.jfif',33),
(8,'فول سوداني نيء','Nut','دفعات مفحوصة خالية من الشوائب والرطوبة الزائدة.','uploads/products/peanuts.jfif',34),
-- الشوكولاتة
(9,'شوكولاتة داكنة (كوفرتشر)','Candy','نسبة كاكاو مرتفعة مخصصة للمصانع والحلواني المحترفين.','uploads/products/Dark-Chocolate.jfif',35),
(9,'شوكولاتة بالحليب','Cookie','قوام كريمي ونكهة متوازنة لصناعات التغليف والتغطية.','uploads/products/Milk-chocolate.jfif',36),
(9,'شوكولاتة بيضاء','Candy','زبدة كاكاو أصلية للحلويات والتزيين والتغطية.','uploads/products/white-chocolate.jfif',37),
(9,'مسحوق الكاكاو','Cookie','كاكاو طبيعي ومعالج بالقلوي للمخابز والمشروبات.','uploads/products/Cocoa-powder.jfif',38),
(9,'زبدة الكاكاو','Droplet','زبدة نقية لصناعات الشوكولاتة والمستحضرات التجميلية.','uploads/products/Cocoa-butter.jfif',39),
-- البن والقهوة
(10,'بن أرابيكا','Coffee','حبوب بنكهة ناعمة وحموضة متوازنة من مزارع مرتفعة.','uploads/products/Arabica-beans.jfif',40),
(10,'بن روبوستا','Coffee','قوام قوي ونسبة كافيين عالية، مناسب لخلطات الإسبريسو.','uploads/products/Robusta-beans.jfif',41),
(10,'بن إثيوبي','Coffee','نكهات زهرية وفاكهية مميزة من موطن القهوة الأصلي.','uploads/products/Ethiopian-coffee.jfif',42),
(10,'بن برازيلي','Coffee','نكهة كراميلية وجوز، الخيار الأول لخلطات التحميص.','uploads/products/Brazilian-coffee.jfif',43),
(10,'بن كولومبي','Coffee','توازن مثالي بين الحموضة والحلاوة وقوام متوسط.','uploads/products/Colombi-coffee.jfif',44),
(10,'بن يمني','Coffee','بن عريق بنكهة غنية وطابع خاص للأسواق الفاخرة.','uploads/products/yemenicoffee.jfif',45),
(10,'قهوة تركية','Coffee','طحن ناعم جداً بنكهة عالية للتحضير بالطريقة التقليدية.','uploads/products/Turkish-coffee.jfif',46),
(10,'قهوة عربية بالهيل','Coffee','محمصة خفيفة مع الهيل، جاهزة للضيافة العربية.','uploads/products/Arabic-coffee-cardamom.jfif',47),
(10,'قهوة سريعة الذوبان','Coffee','قهوة فورية بتعبئة صناعية وتجزئة بمواصفات ثابتة.','uploads/products/Instant-coffee.jfif',48),
-- تطوير المواقع
(11,'مواقع ذكية تتطور مع الزوار','MonitorSmartphone','هياكل مبنية بالذكاء الاصطناعي تتكيف مع سلوك المستخدم.','uploads/products/smart-websites.jfif',49),
(11,'تصميم متجاوب وسرعة تنفيذ','Zap','واجهات تتكيف مع كل زائر وتحسّن معدلات التحويل.','uploads/products/responsive-design.jfif',50),
(11,'تحسين محركات البحث SEO','Radar','محتوى محسّن تلقائياً لضمان ظهور قوي في نتائج البحث.','uploads/products/seo.jfif',51),
-- التسويق الرقمي
(12,'إدارة تواصل اجتماعي 24/7','MessageSquare','تواجد دائم وتفاعل ذكي بجودة بشرية على مدار الساعة.','uploads/products/social-media.jfif',52),
(12,'إعلانات ممولة بدقة استهداف','Target','أقصى عائد على الاستثمار عبر استهداف آلي دقيق.','uploads/products/paid-ads.jfif',53),
(12,'استهداف دقيق Micro-Targeting','Megaphone','تحديد الجمهور الأكثر احتمالاً للشراء من بين الملايين.','uploads/products/micro-targeting.jfif',54),
-- الإنتاج الإبداعي
(13,'تصميم هوية بصرية','Palette','هويات تدمج الحس الفني بتحليل اتجاهات السوق.','uploads/products/visual-identity.jfif',55),
(13,'شعارات ذكية بالذكاء الاصطناعي','Wand2','تصاميم فريدة تعكس هوية علامتك بسرعة إنتاج عالية.','uploads/products/ai-logos.jfif',56),
(13,'فيديو وواقع افتراضي','Video','إنتاج ضخم بتقنية الواقع الافتراضي لمحتوى استثنائي.','uploads/products/video-vr.jfif',57);

INSERT INTO site_values (title, description, icon, sort_order) VALUES
('احترافية عالية','نلتزم بأعلى معايير الجودة في كل ما نقدمه.','Award',1),
('ثقة وشفافية','نتعامل بوضوح ومصداقية في جميع تعاملاتنا.','ShieldCheck',2),
('حلول مبتكرة','نستخدم أحدث التقنيات لتحقيق أفضل النتائج.','Sparkles',3),
('نمو مستدام','ندعم تطور أعمال عملائنا ونساهم في نجاحهم.','TrendingUp',4),
('شراكات طويلة الأمد','نؤمن بأهمية بناء علاقات قائمة على الثقة.','Handshake',5),
('فريق متخصص','نضم نخبة من الخبراء لخدمتكم بأفضل كفاءة.','Users',6);

INSERT INTO digital_ecosystem (title, description, icon, sort_order) VALUES
('استهداف ذكي','دقة في الوصول لجمهورك المثالي.','Target',1),
('ذكاء اصطناعي متقدم','تحليل ذكي وتعلم مستمر لأفضل النتائج.','Bot',2),
('أتمتة العمليات','توفير الوقت والجهد وزيادة الإنتاجية.','Zap',3),
('تحليلات دقيقة','تقارير لحظية لقرارات مبنية على بيانات.','BarChart3',4);

INSERT INTO comparison_rows (label, traditional, smart, sort_order) VALUES
('المدة','إنجاز يستغرق أسابيع','إنجاز في أيام أسرع 10 مرات',1),
('القرار','قرارات مبنية على التخمين','قرارات مبنية على تحليل البيانات',2),
('التكلفة','تكاليف تشغيلية عالية','تقليل التكاليف حتى 80%',3),
('الأداء','أداء ثابت لا يتطور','أنظمة تتعلم وتتحسن مع كل مشروع',4);

INSERT INTO clients (name, logo_url, sort_order) VALUES
('وزارة الصحة','uploads/clients/ministry-of-health.png',1),
('الهيئة العامة للترفيه','uploads/clients/gea.png',2),
('البنك الأول SAB','uploads/clients/sab.png',3),
('بنك الرياض','uploads/clients/riyad-bank.png',4),
('1/2M','uploads/clients/half-m.png',5),
('Sign','uploads/clients/sign.png',6),
('جامعة الملك سعود','uploads/clients/king-saud-university.png',7),
('الجامعة العربية المفتوحة','uploads/clients/aou.png',8),
('Alibaba.com','uploads/clients/alibaba.png',9),
('نقي NAQI','uploads/clients/naqi.png',10),
('مدارس المملكة','uploads/clients/kingdom-schools.png',11);

INSERT INTO countries (name, english, sort_order) VALUES
('السعودية','Saudi Arabia',1),('مصر','Egypt',2),('الإمارات','United Arab Emirates',3);

INSERT INTO stats (`value`, label, sort_order) VALUES
('+٤٥','سوقاً دولياً',1),('١٢٠ ألف','طن سنوياً',2),('٣','قطاعات رئيسية',3),('٢٤/٧','متابعة التوريد',4);

INSERT INTO about_content (id, title, description, image_url, mission, vision) VALUES
(1,'رؤيتنا','','','','نسعى لأن نكون من الجهات الرائدة في تقديم الخدمات التجارية باحترافية وثقة مع بناء علاقات طويلة المدى مع عملائنا.');

INSERT INTO contact_info (id, phone, email, address, map_url, working_hours) VALUES (1,'','','','','');

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name','SAUD TRADING EST.'),('tagline',''),('facebook',''),('twitter',''),
('linkedin',''),('instagram',''),('whatsapp','');
-- The admin user (admin / admin123) is created automatically on first visit to login.php.