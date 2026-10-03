/**
 * Product images + product data — split out from site-data.ts so these ~57
 * image imports are NOT in the main bundle.  They load on demand when the
 * Catalogue section enters the viewport (via React.lazy + LazySection).
 */

import {
    Bean,
    Beaker,
    Boxes,
    Candy,
    CircleDot,
    Coffee,
    Container,
    Cookie,
    Droplet,
    Droplets,
    FlaskConical,
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
    ShoppingBag,
    Sprout,
    Target,
    Video,
    Wand2,
    Wheat,
    Zap,
} from "lucide-react";

import type { Product } from "./site-data";

// ── Product images ──────────────────────────────────────────────────────────
import redLentils from "@/assets/products/red-lentils.jfif";
import yellowLentils from "@/assets/products/yellow-lentils.jfif";
import chickpeas from "@/assets/products/chickpeas.jfif";
import basmatiRice from "@/assets/products/basmati-rice.jfif";
import peanuts from "@/assets/products/peanuts.jfif";
import wheatFlour from "@/assets/products/wheat-flour.jfif";
import whiteBeans from "@/assets/products/white-beans.jfif";
import barley from "@/assets/products/barley.jfif";
import egyptianRice from "@/assets/products/egyptian-rice.jfif";
import oliveOil from "@/assets/products/olive-oil.jfif";
import sunflowerOil from "@/assets/products/sunflower-oil.jfif";
import cornOil from "@/assets/products/corn-oil.jfif";
import soybeanOil from "@/assets/products/soybean-oil.jfif";
import palmOil from "@/assets/products/palm-oil.jfif";
import cashew from "@/assets/products/cashew.jfif";
import AleppoPistachio from "@/assets/products/Aleppo-pistachio.jfif";
import almond from "@/assets/products/almond.jfif";
import walnut from "@/assets/products/walnut.jfif";
import hazelnut from "@/assets/products/hazelnut.jfif";
import HulledSesame from "@/assets/products/Hulled-sesame.jfif";
import unhulledSesame from "@/assets/products/unhulled-sesame.jfif";
import SunflowerSeeds from "@/assets/products/Sunflower-seeds.jfif";
import FlaxSeeds from "@/assets/products/Flax-seeds.jfif";
import BlackCumin from "@/assets/products/Black-Cumin.jfif";
import PumpkinSeeds from "@/assets/products/Pumpkin-seeds.jfif";
import DarkChocolate from "@/assets/products/Dark-Chocolate.jfif";
import MilkChocolate from "@/assets/products/Milk-chocolate.jfif";
import whiteChocolate from "@/assets/products/white-chocolate.jfif";
import CocoaPowder from "@/assets/products/Cocoa-powder.jfif";
import CocoaButter from "@/assets/products/Cocoa-butter.jfif";
import ArabicaBeans from "@/assets/products/Arabica-beans.jfif";
import RobustaBeans from "@/assets/products/Robusta-beans.jfif";
import EthiopianCoffee from "@/assets/products/Ethiopian-coffee.jfif";
import BrazilianCoffee from "@/assets/products/Brazilian-coffee.jfif";
import ColombiCoffee from "@/assets/products/Colombi-coffee.jfif";
import yemenicoffee from "@/assets/products/yemenicoffee.jfif";
import TurkishCoffee from "@/assets/products/Turkish-coffee.jfif";
import ArabicCoffeeCardamom from "@/assets/products/Arabic-coffee-cardamom.jfif";
import InstantCoffee from "@/assets/products/Instant-coffee.jfif";
import hdpe from "@/assets/products/hdpe.jfif";
import ldpe from "@/assets/products/ldpe.jfif";
import pp from "@/assets/products/pp.jfif";
import flexiblePackaging from "@/assets/products/flexible-film.jfif";
import industrialBags from "@/assets/products/industrial-bags.jfif";
import foodGradeContainers from "@/assets/products/food-containers.jfif";
import plasticCompounds from "@/assets/products/plastic-compounds.jfif";
import plasticAdditives from "@/assets/products/manufacturing-additives.jfif";
import recycledPlastics from "@/assets/products/recycled-materials.jfif";
import smartwebsites from "@/assets/products/smart-websites.jfif";
import responsiveDesign from "@/assets/products/responsive-design.jfif";
import seo from "@/assets/products/seo.jfif";
import socialMedia from "@/assets/products/social-media.jfif";
import paidAds from "@/assets/products/paid-ads.jfif";
import microTargeting from "@/assets/products/micro-targeting.jfif";
import visualIdentity from "@/assets/products/visual-identity.jfif";
import aiLogos from "@/assets/products/ai-logos.jfif";
import videoVr from "@/assets/products/video-vr.jfif";

// ── Products map ────────────────────────────────────────────────────────────
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
            image: seo,
            blurb: "محتوى محسّن تلقائياً لضمان ظهور قوي في نتائج البحث.",
        },
    ],
    "التسويق الرقمي": [
        {
            name: "إدارة تواصل اجتماعي 24/7",
            icon: MessageSquare,
            image: socialMedia,
            blurb: "تواجد دائم وتفاعل ذكي بجودة بشرية على مدار الساعة.",
        },
        {
            name: "إعلانات ممولة بدقة استهداف",
            icon: Target,
            image: paidAds,
            blurb: "أقصى عائد على الاستثمار عبر استهداف آلي دقيق.",
        },
        {
            name: "استهداف دقيق Micro-Targeting",
            icon: Megaphone,
            image: microTargeting,
            blurb: "تحديد الجمهور الأكثر احتمالاً للشراء من بين الملايين.",
        },
    ],
    "الإنتاج الإبداعي": [
        {
            name: "تصميم هوية بصرية",
            icon: Palette,
            image: visualIdentity,
            blurb: "هويات تدمج الحس الفني بتحليل اتجاهات السوق.",
        },
        {
            name: "شعارات ذكية بالذكاء الاصطناعي",
            icon: Wand2,
            image: aiLogos,
            blurb: "تصاميم فريدة تعكس هوية علامتك بسرعة إنتاج عالية.",
        },
        {
            name: "فيديو وواقع افتراضي",
            icon: Video,
            image: videoVr,
            blurb: "إنتاج ضخم بتقنية الواقع الافتراضي لمحتوى استثنائي.",
        },
    ],
} satisfies Record<string, Product[]>;
