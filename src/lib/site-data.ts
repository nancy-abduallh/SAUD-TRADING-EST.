import {
    Award,
    Bean,
    BarChart3,
    Beaker,
    Bot,
    Boxes,
    Candy,
    CircleDot,
    Coffee,
    Container,
    Cookie,
    Droplet,
    Droplets,
    FlaskConical,
    Handshake,
    Layers,
    Leaf,
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
import cashew from "@/assets/products/cashew.jfif"
import AleppoPistachio from "@/assets/products/Aleppo-pistachio.jfif"
import almond from "@/assets/products/almond.jfif"
import walnut from "@/assets/products/walnut.jfif"
import hazelnut from "@/assets/products/hazelnut.jfif"
import HulledSesame from "@/assets/products/Hulled-sesame.jfif"
import unhulledSesame from "@/assets/products/unhulled-sesame.jfif"
import SunflowerSeeds from "@/assets/products/Sunflower-seeds.jfif"
import FlaxSeeds from "@/assets/products/Flax-seeds.jfif"
import BlackCumin from "@/assets/products/Black-Cumin.jfif"
import PumpkinSeeds from "@/assets/products/Pumpkin-seeds.jfif"
import DarkChocolate from "@/assets/products/Dark-Chocolate.jfif"
import MilkChocolate from "@/assets/products/Milk-chocolate.jfif"
import whiteChocolate from "@/assets/products/white-chocolate.jfif"
import CocoaPowder from "@/assets/products/Cocoa-powder.jfif"
import CocoaButter from "@/assets/products/Cocoa-butter.jfif"
import ArabicaBeans from "@/assets/products/Arabica-beans.jfif"
import RobustaBeans from "@/assets/products/Robusta-beans.jfif"
import EthiopianCoffee from "@/assets/products/Ethiopian-coffee.jfif"
import BrazilianCoffee from "@/assets/products/Brazilian-coffee.jfif"
import ColombiCoffee from "@/assets/products/Colombi-coffee.jfif"
import yemenicoffee from "@/assets/products/yemenicoffee.jfif"
import TurkishCoffee from "@/assets/products/Turkish-coffee.jfif"
import ArabicCoffeeCardamom from "@/assets/products/Arabic-coffee-cardamom.jfif"
import InstantCoffee from "@/assets/products/Instant-coffee.jfif"
import moh from "@/assets/clients/ministry-of-health.png";
import gea from "@/assets/clients/gea.png";
import sab from "@/assets/clients/sab.png";
import riyadBank from "@/assets/clients/riyad-bank.png";
import halfM from "@/assets/clients/half-m.png";
import sign from "@/assets/clients/sign.png";
import ksu from "@/assets/clients/king-saud-university.png";
import aou from "@/assets/clients/aou.png";
import alibaba from "@/assets/clients/alibaba.png";
import naqi from "@/assets/clients/naqi.png";
import kingdomSchools from "@/assets/clients/kingdom-schools.png";
import hdpe from "@/assets/products/hdpe.jfif"
import ldpe from "@/assets/products/ldpe.jfif"
import pp from "@/assets/products/pp.jfif"
import flexiblePackaging from "@/assets/products/flexible-film.jfif"
import industrialBags from "@/assets/products/industrial-bags.jfif"
import foodGradeContainers from "@/assets/products/food-containers.jfif"
import plasticCompounds from "@/assets/products/plastic-compounds.jfif"
import plasticAdditives from "@/assets/products/manufacturing-additives.jfif"
import recycledPlastics from "@/assets/products/recycled-materials.jfif"
import smartwebsites from "@/assets/products/smart-websites.jfif"
import responsiveDesign from "@/assets/products/responsive-design.jfif"



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

export const products = {
    "بوليمرات خام": [
        {
            name: "بوليثيلين عالي الكثافة (HDPE)",
            icon: Boxes,
            image: hdpe,
            blurb: "حبيبات عالية الكثافة لقولبة الحاويات والأنابيب.",
        },
        {
            name: "بوليثيلين منخفض الكثافة (LDPE)",
            icon: Layers,
            image: ldpe,
            blurb: "مرونة عالية لأفلام التغليف والأكياس الصناعية.",
        },
        {
            name: "بولي بروبلين (PP)",
            icon: CircleDot,
            image: pp,
            blurb: "مقاومة حرارية ممتازة للتطبيقات الصناعية والمنزلية.",
        },
    ],
    "تعبئة وتغليف": [
        {
            name: "أفلام تغليف مرنة",
            icon: Scroll,
            image: flexiblePackaging,
            blurb: "أفلام أحادية وثلاثية الطبقات بمواصفات تصديرية.",
        },
        {
            name: "أكياس صناعية",
            icon: ShoppingBag,
            image: industrialBags,
            blurb: "أكياس نسيجية وشبكية بأحمال تحمل متفاوتة.",
        },
        {
            name: "عبوات غذائية",
            icon: Container,
            image: foodGradeContainers,
            blurb: "عبوات آمنة غذائياً معتمدة من جهات الرقابة الدولية.",
        },
    ],
    "حلول صناعية": [
        {
            name: "مركبات بلاستيكية",
            icon: FlaskConical,
            image: plasticCompounds,
            blurb: "خلطات مخصصة حسب متطلبات خط الإنتاج.",
        },
        {
            name: "إضافات تصنيع",
            icon: Beaker,
            image: plasticAdditives,
            blurb: "إضافات تحسّن الأداء الحراري والميكانيكي للمنتج.",
        },
        {
            name: "مواد معاد تدويرها",
            icon: Recycle,
            image: recycledPlastics,
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

    ],
    "البذور الزيتية": [
        {
            name: "سمسم مقشر",
            icon: Sprout,
            image: HulledSesame,
            blurb: "نقاء عالٍ ولون موحّد لصناعات الطحينة والحلويات والمخابز.",
        },
        {
            name: "سمسم طبيعي غير مقشر",
            icon: Sprout,
            image: unhulledSesame,
            blurb: "محتوى زيتي مرتفع مناسب للعصر والتصنيع الغذائي.",
        },
        {
            name: "بذور دوار الشمس",
            icon: Leaf,
            image: SunflowerSeeds,
            blurb: "بذور مفحوصة للتسالي والتعبئة ولاستخلاص الزيوت.",
        },
        {
            name: "بذور الكتان",
            icon: Sprout,
            image: FlaxSeeds,
            blurb: "بذور غنية بالأوميغا 3 لصناعات المخابز والأغذية الصحية.",
        },
        {
            name: "حبة البركة",
            icon: Leaf,
            image: BlackCumin,
            blurb: "بذور معتمدة ونقية للاستخدام الغذائي والعشبي وعصر الزيت.",
        },
        {
            name: "بذور اليقطين",
            icon: Nut,
            image: PumpkinSeeds,
            blurb: "بذور خضراء مقشرة وغير مقشرة لأسواق المكسرات والتسالي.",
        },
    ],
    "المكسرات": [
        {
            name: "كاجو (الكاشو)",
            icon: Nut,
            image: cashew,
            blurb: "أحجام متعددة بدرجات جودة تصديرية للتجزئة والتصنيع.",
        },
        {
            name: "لوز",
            icon: Nut,
            image: almond,
            blurb: "لوز كامل ومقطّع ومبشور بمواصفات مطابقة لمعايير الجودة.",
        },
        {
            name: "فستق حلبي",
            icon: Nut,
            image: AleppoPistachio,
            blurb: "فستق بقشره أو مقشر بنكهة غنية ولون أخضر مميز.",
        },
        {
            name: "جوز",
            icon: Nut,
            image: walnut,
            blurb: "أنصاف وأرباع جوز فاتحة اللون لصناعات الحلويات والمخبوزات.",
        },
        {
            name: "بندق",
            icon: Nut,
            image: hazelnut,
            blurb: "بندق نيء ومحمّص مناسب لصناعة الشوكولاتة والحلويات.",
        },
        {
            name: "فول سوداني نيء",
            icon: Nut,
            image: peanuts,
            blurb: "دفعات مفحوصة خالية من الشوائب والرطوبة الزائدة.",
        },
    ],
    "الشوكولاتة": [
        {
            name: "شوكولاتة داكنة (كوفرتشر)",
            icon: Candy,
            image: DarkChocolate,
            blurb: "نسبة كاكاو مرتفعة مخصصة للمصانع والحلواني المحترفين.",
        },
        {
            name: "شوكولاتة بالحليب",
            icon: Cookie,
            image: MilkChocolate,
            blurb: "قوام كريمي ونكهة متوازنة لصناعات التغليف والتغطية.",
        },
        {
            name: "شوكولاتة بيضاء",
            icon: Candy,
            image: whiteChocolate,
            blurb: "زبدة كاكاو أصلية للحلويات والتزيين والتغطية.",
        },
        {
            name: "مسحوق الكاكاو",
            icon: Cookie,
            image: CocoaPowder,
            blurb: "كاكاو طبيعي ومعالج بالقلوي للمخابز والمشروبات.",
        },
        {
            name: "زبدة الكاكاو",
            icon: Droplet,
            image: CocoaButter,
            blurb: "زبدة نقية لصناعات الشوكولاتة والمستحضرات التجميلية.",
        },
    ],
    "البن والقهوة": [
        {
            name: "بن أرابيكا",
            icon: Coffee,
            image: ArabicaBeans,
            blurb: "حبوب بنكهة ناعمة وحموضة متوازنة من مزارع مرتفعة.",
        },
        {
            name: "بن روبوستا",
            icon: Coffee,
            image: RobustaBeans,
            blurb: "قوام قوي ونسبة كافيين عالية، مناسب لخلطات الإسبريسو.",
        },
        {
            name: "بن إثيوبي",
            icon: Coffee,
            image: EthiopianCoffee,
            blurb: "نكهات زهرية وفاكهية مميزة من موطن القهوة الأصلي.",
        },
        {
            name: "بن برازيلي",
            icon: Coffee,
            image: BrazilianCoffee,
            blurb: "نكهة كراميلية وجوز، الخيار الأول لخلطات التحميص.",
        },
        {
            name: "بن كولومبي",
            icon: Coffee,
            image: ColombiCoffee,
            blurb: "توازن مثالي بين الحموضة والحلاوة وقوام متوسط.",
        },
        {
            name: "بن يمني",
            icon: Coffee,
            image: yemenicoffee,
            blurb: "بن عريق بنكهة غنية وطابع خاص للأسواق الفاخرة.",
        },
        {
            name: "قهوة تركية",
            icon: Coffee,
            image: TurkishCoffee,
            blurb: "طحن ناعم جداً بنكهة عالية للتحضير بالطريقة التقليدية.",
        },
        {
            name: "قهوة عربية بالهيل",
            icon: Coffee,
            image: ArabicCoffeeCardamom,
            blurb: "محمصة خفيفة مع الهيل، جاهزة للضيافة العربية.",
        },
        {
            name: "قهوة سريعة الذوبان",
            icon: Coffee,
            image: InstantCoffee,
            blurb: "قهوة فورية بتعبئة صناعية وتجزئة بمواصفات ثابتة.",
        },

    ],
    "تطوير المواقع": [
        {
            name: "مواقع ذكية تتطور مع الزوار",
            icon: MonitorSmartphone,
            image: smartwebsites,
            blurb: "هياكل مبنية بالذكاء الاصطناعي تتكيف مع سلوك المستخدم.",
        },
        {
            name: "تصميم متجاوب وسرعة تنفيذ",
            icon: Zap,
            image: responsiveDesign,
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
// Clients ("عملاؤنا") — gold logos on transparent PNGs, shown as a static grid.
// `name` is used as the image alt text.
// ---------------------------------------------------------------------------
export type Client = { name: string; logo: string };

export const clients: Client[] = [
    { name: "وزارة الصحة", logo: moh },
    { name: "الهيئة العامة للترفيه", logo: gea },
    { name: "البنك الأول SAB", logo: sab },
    { name: "بنك الرياض", logo: riyadBank },
    { name: "1/2M", logo: halfM },
    { name: "Sign", logo: sign },
    { name: "جامعة الملك سعود", logo: ksu },
    { name: "الجامعة العربية المفتوحة", logo: aou },
    { name: "Alibaba.com", logo: alibaba },
    { name: "نقي NAQI", logo: naqi },
    { name: "مدارس المملكة", logo: kingdomSchools },
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