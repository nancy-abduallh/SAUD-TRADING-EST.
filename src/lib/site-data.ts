import {
    Award,
    BarChart3,
    Bot,
    Handshake,
    ShieldCheck,
    Sparkles,
    Target,
    TrendingUp,
    Users,
    Zap,
    type LucideIcon,
} from "lucide-react";

import foodSectorImage from "@/assets/food-sector.jpg";
import plasticsSectorImage from "@/assets/plastics-sector.jpg";
import digitalSectorImage from "@/assets/hero-globe.jpg";

// ---------------------------------------------------------------------------
// Types
// ---------------------------------------------------------------------------
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

/**
 * All product-category names.  Defined as an explicit union so `index.tsx`
 * (and any other lightweight consumer) can use the type without pulling in the
 * heavy product-image bundle from `product-data.ts`.
 */
export type CategoryName =
    | "بوليمرات خام"
    | "تعبئة وتغليف"
    | "حلول صناعية"
    | "الأرز والحبوب"
    | "الزيوت النباتية"
    | "البقوليات"
    | "البذور الزيتية"
    | "المكسرات"
    | "الشوكولاتة"
    | "البن والقهوة"
    | "تطوير المواقع"
    | "التسويق الرقمي"
    | "الإنتاج الإبداعي";

export type Client = { name: string; logo: string };

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
        categories: [
            "الأرز والحبوب",
            "الزيوت النباتية",
            "البقوليات",
            "البذور الزيتية",
            "المكسرات",
            "الشوكولاتة",
            "البن والقهوة",
        ],
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
// Countries + stats
// ---------------------------------------------------------------------------
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