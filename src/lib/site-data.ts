import {
    Award,
    Bean,
    BarChart3,
    Beaker,
    Bot,
    Boxes,
    CircleDot,
    Container,
    Droplet,
    Droplets,
    FlaskConical,
    Handshake,
    Layers,
    Megaphone,
    MessageSquare,
    MonitorSmartphone,
    Nut,
    Palette,
    Radar,
    Recycle,
    Scroll,
    ShieldCheck,
    ShoppingBag,
    Sparkles,
    Sprout,
    Target,
    TrendingUp,
    Users,
    Video,
    Wand2,
    Wheat,
    Zap,
    type LucideIcon,
} from "lucide-react";

import foodSectorImage from "@/assets/food-sector.jpg";
import plasticsSectorImage from "@/assets/plastics-sector.jpg";
import digitalSectorImage from "@/assets/hero-globe.jpg";
import redLentils from "@/assets/products/red-lentils.jfif"
import yellowLentils from "@/assets/products/yellow-lentils.jfif"
import chickpeas from "@/assets/products/chickpeas.jfif"
import basmatiRice from "@/assets/products/basmati-rice.jfif"
import peanuts from "@/assets/products/peanuts.jfif"
import wheatFlour from "@/assets/products/wheat-flour.jfif"
import whiteBeans from "@/assets/products/white-beans.jfif"
import barley from "@/assets/products/barley.jfif"
import egyptianRice from "@/assets/products/egyptian-rice.jfif"
import oliveOil from "@/assets/products/olive-oil.jfif"
import sunflowerOil from "@/assets/products/sunflower-oil.jfif"
import cornOil from "@/assets/products/corn-oil.jfif"
import soybeanOil from "@/assets/products/soybean-oil.jfif"
import palmOil from "@/assets/products/palm-oil.jfif"


export type Product = {
    name: string;
    icon: LucideIcon;
    blurb: string;
    image?: string;
};

export type Sector = {
    title: string;
    english: string;
    description: string;
    image: string;
    imageAlt: string;
    categories: string[];
};

// ---------------------------------------------------------------------------
// Sectors — the three pillars of the business: physical trade in plastics and
// food commodities, plus the AI-powered digital services line described in
// the company profile.
// ---------------------------------------------------------------------------
export const sectors = {
    plastics: {
        title: "قطاع اللدائن والبلاستيك",
        english: "INDUSTRIAL MATERIALS",
        description: "مواد خام موثقة المواصفات للصناعات التحويلية وحلول التعبئة.",
        image: plasticsSectorImage,
        imageAlt: "حبيبات بلاستيكية خام شفافة وخضراء",
        categories: ["بوليمرات خام", "تعبئة وتغليف", "حلول صناعية"],
    },
    food: {
        title: "قطاع المواد الغذائية",
        english: "FOOD COMMODITIES",
        description: "سلع غذائية مختارة بعناية من مصادر دولية معتمدة.",
        image: foodSectorImage,
        imageAlt: "أرز بسمتي فاخر في وعاء تقليدي",
        categories: ["الأرز والحبوب", "الزيوت النباتية", "البقوليات"],
    },
    digital: {
        title: "قطاع الحلول الرقمية",
        english: "DIGITAL & CREATIVE SERVICES",
        description:
            "منظومة رقمية متكاملة مدعومة بالذكاء الاصطناعي لبناء حضورك التجاري وتنميته.",
        image: digitalSectorImage,
        imageAlt: "شبكة رقمية عالمية مضيئة",
        categories: ["تطوير المواقع", "التسويق الرقمي", "الإنتاج الإبداعي"],
    },
} satisfies Record<string, Sector>;

export type SectorKey = keyof typeof sectors;

// ---------------------------------------------------------------------------
// Products per category. Food expanded from 3 → 5 items per category per
// request; plastics kept at 3; the new digital sector mirrors the same
// category → product shape using the service line-up from the profile.
// ---------------------------------------------------------------------------
export const products = {
    "بوليمرات خام": [
        {
            name: "بوليثيلين عالي الكثافة (HDPE)",
            icon: Boxes,
            blurb: "حبيبات عالية الكثافة لقولبة الحاويات والأنابيب.",
        },
        {
            name: "بوليثيلين منخفض الكثافة (LDPE)",
            icon: Layers,
            blurb: "مرونة عالية لأفلام التغليف والأكياس الصناعية.",
        },
        {
            name: "بولي بروبلين (PP)",
            icon: CircleDot,
            blurb: "مقاومة حرارية ممتازة للتطبيقات الصناعية والمنزلية.",
        },
    ],
    "تعبئة وتغليف": [
        {
            name: "أفلام تغليف مرنة",
            icon: Scroll,
            blurb: "أفلام أحادية وثلاثية الطبقات بمواصفات تصديرية.",
        },
        {
            name: "أكياس صناعية",
            icon: ShoppingBag,
            blurb: "أكياس نسيجية وشبكية بأحمال تحمل متفاوتة.",
        },
        {
            name: "عبوات غذائية",
            icon: Container,
            blurb: "عبوات آمنة غذائياً معتمدة من جهات الرقابة الدولية.",
        },
    ],
    "حلول صناعية": [
        {
            name: "مركبات بلاستيكية",
            icon: FlaskConical,
            blurb: "خلطات مخصصة حسب متطلبات خط الإنتاج.",
        },
        {
            name: "إضافات تصنيع",
            icon: Beaker,
            blurb: "إضافات تحسّن الأداء الحراري والميكانيكي للمنتج.",
        },
        {
            name: "مواد معاد تدويرها",
            icon: Recycle,
            blurb: "حلول مستدامة بمعايير جودة تعادل المواد الخام.",
        },
    ],
    "الأرز والحبوب": [
        {
            name: "أرز بسمتي ملكي",
            icon: Wheat,
            image: basmatiRice,
            blurb: "حبة طويلة وعطر مميز من أجود مصادر الاستيراد.",
        },

        {
            name: "أرز مصري قصير الحبة",
            icon: Sprout,
            image: egyptianRice,
            blurb: "مثالي للأطباق التقليدية بقوام متماسك.",
        },
        {
            name: "قمح وطحين فاخر",
            icon: Wheat,
            image: wheatFlour,
            blurb: "قمح مطحون بمعايير صارمة لصناعات المخابز.",
        },
        {
            name: "شعير علف وتصنيع",
            icon: Sprout,
            image: barley,
            blurb: "دفعات كبيرة لصناعات الأعلاف والتصنيع الغذائي.",
        },
    ],
    "الزيوت النباتية": [
        {
            name: "زيت زيتون بكر ممتاز",
            icon: Droplet,
            image: oliveOil,
            blurb: "استخلاص بارد ونسبة حموضة منخفضة.",
        },
        {
            name: "زيت دوار الشمس",
            icon: Droplets,
            image: sunflowerOil,
            blurb: "نقاء عالٍ ومناسب للاستخدام المنزلي والصناعي.",
        },
        {
            name: "زيت الذرة",
            icon: Droplet,
            image: cornOil,
            blurb: "خيار اقتصادي بثبات حراري جيد للقلي.",
        },
        {
            name: "زيت الصويا",
            icon: Droplets,
            image: soybeanOil,
            blurb: "توريد بالجملة لمصانع التعبئة وإعادة التكرير.",
        },
        {
            name: "زيت النخيل",
            icon: Droplet,
            image: palmOil,
            blurb: "مواصفات تصديرية لصناعات الأغذية والتصنيع.",
        },
    ],
    البقوليات: [
        {
            name: "عدس أحمر مصري",
            icon: Bean,
            image: redLentils,
            blurb: "تدرّج لوني موحّد وزمن طبخ قصير.",
        },
        {
            name: "عدس أصفر مقشر",
            icon: Bean,
            image: yellowLentils,
            blurb: "منتج مقشور بالكامل جاهز للتعبئة الاستهلاكية.",
        },
        {
            name: "حمص فاخر",
            icon: Nut,
            image: chickpeas,
            blurb: "حبة كاملة ومنتظمة الحجم لأسواق التجزئة.",
        },
        {
            name: "فاصوليا بيضاء",
            icon: Bean,
            image: whiteBeans,
            blurb: "توريد منتظم بأحجام تعبئة مرنة.",
        },
        {
            name: "فول سوداني نيء",
            icon: Nut,
            image: peanuts,
            blurb: "دفعات مفحوصة خالية من الشوائب والرطوبة الزائدة.",
        },
    ],
    "تطوير المواقع": [
        {
            name: "مواقع ذكية تتطور مع الزوار",
            icon: MonitorSmartphone,
            blurb: "هياكل مبنية بالذكاء الاصطناعي تتكيف مع سلوك المستخدم.",
        },
        {
            name: "تصميم متجاوب وسرعة تنفيذ",
            icon: Zap,
            blurb: "واجهات تتكيف مع كل زائر وتحسّن معدلات التحويل.",
        },
        {
            name: "تحسين محركات البحث SEO",
            icon: Radar,
            blurb: "محتوى محسّن تلقائياً لضمان ظهور قوي في نتائج البحث.",
        },
    ],
    "التسويق الرقمي": [
        {
            name: "إدارة تواصل اجتماعي 24/7",
            icon: MessageSquare,
            blurb: "تواجد دائم وتفاعل ذكي بجودة بشرية على مدار الساعة.",
        },
        {
            name: "إعلانات ممولة بدقة استهداف",
            icon: Target,
            blurb: "أقصى عائد على الاستثمار عبر استهداف آلي دقيق.",
        },
        {
            name: "استهداف دقيق Micro-Targeting",
            icon: Megaphone,
            blurb: "تحديد الجمهور الأكثر احتمالاً للشراء من بين الملايين.",
        },
    ],
    "الإنتاج الإبداعي": [
        {
            name: "تصميم هوية بصرية",
            icon: Palette,
            blurb: "هويات تدمج الحس الفني بتحليل اتجاهات السوق.",
        },
        {
            name: "شعارات ذكية بالذكاء الاصطناعي",
            icon: Wand2,
            blurb: "تصاميم فريدة تعكس هوية علامتك بسرعة إنتاج عالية.",
        },
        {
            name: "فيديو وواقع افتراضي",
            icon: Video,
            blurb: "إنتاج ضخم بتقنية الواقع الافتراضي لمحتوى استثنائي.",
        },
    ],
} satisfies Record<string, Product[]>;

export type CategoryName = keyof typeof products;

// ---------------------------------------------------------------------------
// Vision + values ("رؤيتنا") — from the company profile.
// ---------------------------------------------------------------------------
export const visionStatement =
    "نسعى لأن نكون من الجهات الرائدة في تقديم الخدمات التجارية باحترافية وثقة مع بناء علاقات طويلة المدى مع عملائنا.";

export const values = [
    {
        title: "احترافية عالية",
        description: "نلتزم بأعلى معايير الجودة في كل ما نقدمه.",
        icon: Award,
    },
    {
        title: "ثقة وشفافية",
        description: "نتعامل بوضوح ومصداقية في جميع تعاملاتنا.",
        icon: ShieldCheck,
    },
    {
        title: "حلول مبتكرة",
        description: "نستخدم أحدث التقنيات لتحقيق أفضل النتائج.",
        icon: Sparkles,
    },
    {
        title: "نمو مستدام",
        description: "ندعم تطور أعمال عملائنا ونساهم في نجاحهم.",
        icon: TrendingUp,
    },
    {
        title: "شراكات طويلة الأمد",
        description: "نؤمن بأهمية بناء علاقات قائمة على الثقة.",
        icon: Handshake,
    },
    {
        title: "فريق متخصص",
        description: "نضم نخبة من الخبراء لخدمتكم بأفضل كفاءة.",
        icon: Users,
    },
] satisfies { title: string; description: string; icon: LucideIcon }[];

// ---------------------------------------------------------------------------
// "منظومة رقمية متكاملة .. عقلها واحد" — the four-pillar digital ecosystem band.
// ---------------------------------------------------------------------------
export const digitalEcosystem = [
    {
        title: "استهداف ذكي",
        description: "دقة في الوصول لجمهورك المثالي.",
        icon: Target,
    },
    {
        title: "ذكاء اصطناعي متقدم",
        description: "تحليل ذكي وتعلم مستمر لأفضل النتائج.",
        icon: Bot,
    },
    {
        title: "أتمتة العمليات",
        description: "توفير الوقت والجهد وزيادة الإنتاجية.",
        icon: Zap,
    },
    {
        title: "تحليلات دقيقة",
        description: "تقارير لحظية لقرارات مبنية على بيانات.",
        icon: BarChart3,
    },
] satisfies { title: string; description: string; icon: LucideIcon }[];

// ---------------------------------------------------------------------------
// "الفارق بين الجيد والاستثنائي" — traditional methods vs. AI-driven delivery.
// ---------------------------------------------------------------------------
export const comparisonRows = [
    {
        label: "المدة",
        traditional: "إنجاز يستغرق أسابيع",
        smart: "إنجاز في أيام أسرع 10 مرات",
    },
    {
        label: "القرار",
        traditional: "قرارات مبنية على التخمين",
        smart: "قرارات مبنية على تحليل البيانات",
    },
    {
        label: "التكلفة",
        traditional: "تكاليف تشغيلية عالية",
        smart: "تقليل التكاليف حتى 80%",
    },
    {
        label: "الأداء",
        traditional: "أداء ثابت لا يتطور",
        smart: "أنظمة تتعلم وتتحسن مع كل مشروع",
    },
];

// ---------------------------------------------------------------------------
// Clients ("عملاؤنا") — rendered as typographic badges (no logo files were
// supplied for these third parties).
// ---------------------------------------------------------------------------
export const clients = [
    "وزارة الصحة",
    "الهيئة العامة للترفيه",
    "البنك الأول SAB",
    "بنك الرياض",
    "1/2M",
    "Sign",
    "جامعة الملك سعود",
    "الجامعة العربية المفتوحة",
    "Alibaba.com",
    "نقي NAQI",
    "مدارس المملكة",
];

export const countries = [
    { name: "السعودية", english: "Saudi Arabia" },
    { name: "مصر", english: "Egypt" },
    { name: "الإمارات", english: "United Arab Emirates" },
];

export const stats: [string, string][] = [
    ["+٤٥", "سوقاً دولياً"],
    ["١٢٠ ألف", "طن سنوياً"],
    ["٣", "قطاعات رئيسية"],
    ["٢٤/٧", "متابعة التوريد"],
];
