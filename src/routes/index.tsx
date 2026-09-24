import { createFileRoute } from "@tanstack/react-router";
import { ArrowLeft, ChevronDown, Menu, PackageCheck, Ship, X } from "lucide-react";
import { useState } from "react";

import foodSector from "@/assets/food-sector.jpg";
import plasticsSector from "@/assets/plastics-sector.jpg";
import productCollection from "@/assets/product-collection.jpg";
import heroImage from "@/assets/saoud-port-hero.jpg";
import { Button } from "@/components/ui/button";

// No head() here: the home route inherits title/description/og/twitter from
// __root.tsx, and ships no og:image so serve-time hosting can inject the
// project's social preview (explicit og:image or latest screenshot).
export const Route = createFileRoute("/")({
  head: () => ({
    meta: [
      { title: "سعود التجارية | تجارة عالمية برؤية سعودية" },
      { name: "description", content: "حلول سعودية موثوقة لتوريد المواد الغذائية والبلاستيكية وإدارة سلاسل الإمداد." },
      { property: "og:title", content: "سعود التجارية | تجارة عالمية برؤية سعودية" },
      { property: "og:description", content: "اكتشف قطاعات سعود التجارية ومنتجات الغذاء والبلاستيك المختارة." },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary_large_image" },
    ],
  }),
  component: Index,
});

const sectors = {
  plastics: {
    title: "قطاع اللدائن والبلاستيك",
    english: "INDUSTRIAL MATERIALS",
    description: "مواد خام موثقة المواصفات للصناعات التحويلية وحلول التعبئة.",
    image: plasticsSector,
    categories: ["بوليمرات خام", "تعبئة وتغليف", "حلول صناعية"],
  },
  food: {
    title: "قطاع المواد الغذائية",
    english: "FOOD COMMODITIES",
    description: "سلع غذائية مختارة بعناية من مصادر دولية معتمدة.",
    image: foodSector,
    categories: ["الأرز والحبوب", "الزيوت النباتية", "البقوليات"],
  },
} as const;

const products = {
  "بوليمرات خام": ["بوليثيلين عالي الكثافة", "بوليثيلين منخفض الكثافة", "بولي بروبلين"],
  "تعبئة وتغليف": ["أفلام تغليف مرنة", "أكياس صناعية", "عبوات غذائية"],
  "حلول صناعية": ["مركبات بلاستيكية", "إضافات تصنيع", "مواد معاد تدويرها"],
  "الأرز والحبوب": ["أرز بسمتي ملكي", "أرز طويل الحبة", "قمح وحبوب"],
  "الزيوت النباتية": ["زيت زيتون بكر", "زيت دوار الشمس", "زيت الذرة"],
  البقوليات: ["عدس أحمر", "حمص فاخر", "فاصوليا بيضاء"],
} as const;

function Index() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [sectorKey, setSectorKey] = useState<keyof typeof sectors>("food");
  const [category, setCategory] = useState("الأرز والحبوب");
  const sector = sectors[sectorKey];
  const visibleProducts = products[category as keyof typeof products] ?? [];

  const selectSector = (key: keyof typeof sectors) => {
    setSectorKey(key);
    setCategory(sectors[key].categories[0]);
    requestAnimationFrame(() => document.getElementById("catalogue")?.scrollIntoView({ behavior: "smooth" }));
  };

  return (
    <main className="min-h-screen overflow-x-hidden bg-pearl text-ink" dir="rtl">
      <nav className="fixed inset-x-0 top-0 z-50 border-b border-pearl/15 bg-ink/25 text-pearl backdrop-blur-md">
        <div className="mx-auto flex h-20 max-w-7xl items-center justify-between px-5 md:px-8">
          <div className="flex items-center gap-12">
            <a href="#top" className="text-2xl font-bold text-pearl">سعود<span className="text-gold">.</span></a>
            <div className="hidden items-center gap-8 text-sm md:flex">
              <a href="#sectors" className="transition-colors hover:text-gold">القطاعات</a>
              <a href="#catalogue" className="transition-colors hover:text-gold">المنتجات</a>
              <a href="#supply" className="transition-colors hover:text-gold">التوريد الذكي</a>
              <a href="#about" className="transition-colors hover:text-gold">عن الشركة</a>
            </div>
          </div>
          <div className="hidden items-center gap-3 md:flex">
            <Button variant="glass">EN</Button><Button>تواصل معنا</Button>
          </div>
          <Button variant="glass" size="icon" className="md:hidden" aria-label="فتح القائمة" onClick={() => setMenuOpen(!menuOpen)}>
            {menuOpen ? <X size={20} /> : <Menu size={20} />}
          </Button>
        </div>
        {menuOpen && <div className="grid gap-4 border-t border-pearl/15 bg-ink px-5 py-6 text-sm md:hidden">
          <a href="#sectors" onClick={() => setMenuOpen(false)}>القطاعات</a><a href="#catalogue" onClick={() => setMenuOpen(false)}>المنتجات</a><a href="#about" onClick={() => setMenuOpen(false)}>عن الشركة</a>
        </div>}
      </nav>

      <header id="top" className="relative flex min-h-[92svh] items-center overflow-hidden">
        <img src={heroImage} width={1920} height={1088} alt="ميناء تجاري وسفينة شحن عند الغروب" className="hero-drift absolute inset-0 size-full object-cover" />
        <div className="absolute inset-0 bg-linear-to-l from-ink/90 via-ink/40 to-ink/10" />
        <div className="absolute inset-x-0 bottom-0 h-40 bg-linear-to-t from-pearl to-transparent" />
        <div className="relative z-10 mx-auto w-full max-w-7xl px-5 pt-20 md:px-8">
          <div className="reveal-up max-w-3xl">
            <div className="mb-6 flex items-center gap-4"><span className="h-px w-12 bg-gold" /><span className="font-mono text-xs text-gold">LEADING GLOBAL TRADE</span></div>
            <h1 className="text-5xl font-bold leading-[1.15] text-pearl md:text-8xl">نربط العالم<br /><span className="text-gold">بأمانة سعودية</span></h1>
            <p className="mt-7 max-w-2xl text-lg leading-8 text-pearl/80 md:text-xl">حلول متكاملة لسلاسل الإمداد، من المواد الخام البلاستيكية إلى أجود أنواع الأغذية العالمية، بمعايير تتجاوز التوقعات.</p>
            <div className="mt-9 flex flex-wrap gap-3"><Button variant="gold" size="lg" asChild><a href="#sectors">استكشف القطاعات <ArrowLeft size={18} /></a></Button><Button variant="glass" size="lg">الملف المؤسسي</Button></div>
          </div>
        </div>
        <a href="#sectors" aria-label="انتقل إلى القطاعات" className="absolute bottom-10 left-1/2 z-20 -translate-x-1/2 text-ink"><ChevronDown className="animate-bounce" /></a>
      </header>

      <section id="supply" className="border-y border-primary/10 bg-sage">
        <div className="mx-auto grid max-w-7xl grid-cols-2 gap-8 px-5 py-10 md:grid-cols-4 md:px-8">
          {[['+٤٥','سوقاً دولياً'],['١٢٠ ألف','طن سنوياً'],['٢','قطاعان رئيسيان'],['٢٤/٧','متابعة التوريد']].map(([value,label]) => <div key={label}><strong className="block font-mono text-3xl text-primary">{value}</strong><span className="mt-1 block text-sm text-primary/65">{label}</span></div>)}
        </div>
      </section>

      <section id="sectors" className="mx-auto max-w-7xl px-5 py-20 md:px-8 md:py-28">
        <div className="mb-12 flex flex-col justify-between gap-5 md:flex-row md:items-end">
          <div><span className="font-mono text-xs text-gold">01 / BUSINESS SECTORS</span><h2 className="mt-3 text-4xl font-bold text-primary md:text-5xl">قطاعاتنا الرئيسية</h2><p className="mt-4 max-w-xl leading-7 text-muted-foreground">هيكل واضح يوصلك من القطاع إلى التصنيف ثم المنتج المطلوب.</p></div>
          <Button variant="outline" asChild><a href="#catalogue">عرض الكتالوج <ArrowLeft size={16} /></a></Button>
        </div>
        <div className="grid gap-5 md:grid-cols-12">
          <button onClick={() => selectSector('plastics')} className="group relative min-h-[430px] overflow-hidden text-right md:col-span-8" aria-label="عرض قطاع اللدائن والبلاستيك">
            <img src={plasticsSector} width={1200} height={800} loading="lazy" alt="حبيبات بلاستيكية خام" className="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105" />
            <div className="absolute inset-0 bg-linear-to-t from-ink/90 via-ink/5 to-transparent" /><div className="absolute inset-x-0 bottom-0 p-7 text-pearl md:p-10"><span className="font-mono text-xs text-gold">INDUSTRIAL MATERIALS</span><h3 className="mt-2 text-3xl font-bold">قطاع اللدائن والبلاستيك</h3><p className="mt-3 text-sm text-pearl/70">بوليمرات خام · تعبئة وتغليف · حلول صناعية</p></div>
          </button>
          <button onClick={() => selectSector('food')} className="group relative min-h-[430px] overflow-hidden text-right md:col-span-4" aria-label="عرض قطاع المواد الغذائية">
            <img src={foodSector} width={800} height={1200} loading="lazy" alt="أرز بسمتي فاخر" className="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105" />
            <div className="absolute inset-0 bg-linear-to-t from-primary via-primary/5 to-transparent" /><div className="absolute inset-x-0 bottom-0 p-7 text-pearl"><span className="font-mono text-xs text-gold">FOOD COMMODITIES</span><h3 className="mt-2 text-2xl font-bold">قطاع المواد الغذائية</h3><p className="mt-3 text-sm text-pearl/75">أرز فاخر · زيوت نباتية · حبوب مختارة</p></div>
          </button>
        </div>
      </section>

      <section id="catalogue" className="bg-ink py-20 text-pearl md:py-28">
        <div className="mx-auto max-w-7xl px-5 md:px-8">
          <div className="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
            <div><span className="font-mono text-xs text-gold">02 / SMART CATALOGUE</span><h2 className="mt-3 text-4xl font-bold">{sector.title}</h2><p className="mt-4 max-w-lg leading-7 text-pearl/55">{sector.description}</p>
              <div className="mt-8 grid gap-2">{sector.categories.map(item => <button key={item} onClick={() => setCategory(item)} className={`flex items-center justify-between border px-5 py-4 text-right transition-colors ${category === item ? 'border-gold bg-gold text-ink' : 'border-pearl/10 hover:border-gold/60'}`}><span>{item}</span><ArrowLeft size={17} /></button>)}</div>
            </div>
            <div><div className="mb-6 flex items-center justify-between border-b border-pearl/10 pb-5"><div><span className="text-xs text-gold">التصنيف المختار</span><h3 className="mt-1 text-2xl font-semibold">{category}</h3></div><PackageCheck className="text-gold" /></div>
              <div className="grid gap-px bg-pearl/10 md:grid-cols-3">{visibleProducts.map((item, index) => <article key={item} className="group bg-ink p-5"><div className="relative mb-5 aspect-square overflow-hidden bg-pearl/5"><img src={productCollection} width={1600} height={912} loading="lazy" alt={item} className={`size-full object-cover transition-transform duration-500 group-hover:scale-105 ${index === 0 ? 'object-left' : index === 1 ? 'object-center' : 'object-right'}`} /></div><span className="font-mono text-xs text-gold">{sectorKey === 'food' ? 'FD' : 'PL'}-{401 + index}</span><h4 className="mt-2 text-lg font-semibold">{item}</h4><p className="mt-2 text-sm leading-6 text-pearl/45">توريد تجاري موثوق مع مستندات المواصفات وخيارات الكميات.</p><Button variant="ghost" className="mt-4 px-0 text-gold">تفاصيل المنتج <ArrowLeft size={15} /></Button></article>)}</div>
            </div>
          </div>
        </div>
      </section>

      <section id="about" className="border-b border-primary/10 bg-pearl py-20 md:py-28"><div className="mx-auto grid max-w-7xl gap-12 px-5 md:grid-cols-2 md:px-8"><div><span className="font-mono text-xs text-gold">03 / SAOUD TRADING</span><h2 className="mt-3 text-4xl font-bold text-primary">توريد محسوب.<br />شراكات تدوم.</h2></div><div><p className="text-lg leading-8 text-muted-foreground">نبني جسوراً موثوقة بين المنتجين والأسواق، مع عناية دقيقة بالجودة والامتثال وسرعة الوصول.</p><div className="mt-7 flex items-center gap-3 text-primary"><Ship /><span className="font-semibold">من المصدر إلى وجهتك بكفاءة ووضوح</span></div></div></div></section>

      <footer className="bg-pearl py-12"><div className="mx-auto flex max-w-7xl flex-col justify-between gap-8 px-5 md:flex-row md:items-end md:px-8"><div><div className="text-3xl font-bold text-primary">سعود<span className="text-gold">.</span></div><p className="mt-3 max-w-sm text-sm leading-6 text-muted-foreground">شركة سعودية متخصصة في تجارة المواد الغذائية والبلاستيكية.</p></div><div className="text-sm text-muted-foreground"><p>الرياض، المملكة العربية السعودية</p><p className="mt-2 font-mono text-xs">© 2026 SAOUD TRADING</p></div></div></footer>
    </main>
  );
}
