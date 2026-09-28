import { createFileRoute } from "@tanstack/react-router";
import { useState } from "react";

import { Navbar } from "@/components/sections/Navbar";
import { HeroSlider } from "@/components/sections/HeroSlider";
import { StatsBar } from "@/components/sections/StatsBar";
import { SectorsGrid } from "@/components/sections/SectorsGrid";
import { Catalogue } from "@/components/sections/Catalogue";
import { VisionValues } from "@/components/sections/VisionValues";
import { DigitalEcosystem } from "@/components/sections/DigitalEcosystem";
import { ComparisonTable } from "@/components/sections/ComparisonTable";
import { ClientsMarquee } from "@/components/sections/ClientsMarquee";
import { AboutSection } from "@/components/sections/AboutSection";
import { Footer } from "@/components/sections/Footer";
import { sectors, type CategoryName, type SectorKey } from "@/lib/site-data";

export const Route = createFileRoute("/")({
  head: () => ({
    meta: [
      { title: "سعود التجارية | تجارة عالمية برؤية سعودية" },
      {
        name: "description",
        content:
          "حلول سعودية موثوقة لتوريد المواد الغذائية والبلاستيكية، وخدمات رقمية متكاملة مدعومة بالذكاء الاصطناعي.",
      },
      { property: "og:title", content: "سعود التجارية | تجارة عالمية برؤية سعودية" },
      {
        property: "og:description",
        content: "اكتشف قطاعات سعود التجارية: الغذاء، البلاستيك، والحلول الرقمية المدعومة بالذكاء الاصطناعي.",
      },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary_large_image" },
    ],
  }),
  component: Index,
});

function Index() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [sectorKey, setSectorKey] = useState<SectorKey>("food");
  const [category, setCategory] = useState<CategoryName>("الأرز والحبوب");

  const selectSector = (key: SectorKey) => {
    setSectorKey(key);
    setCategory(sectors[key].categories[0] as CategoryName);
    requestAnimationFrame(() => document.getElementById("catalogue")?.scrollIntoView({ behavior: "smooth" }));
  };

  const changeSector = (key: SectorKey) => {
    setSectorKey(key);
    setCategory(sectors[key].categories[0] as CategoryName);
  };

  return (
    <main className="min-h-screen overflow-x-hidden bg-pearl text-ink" dir="rtl">
      <Navbar menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
      <HeroSlider />
      <StatsBar />
      <SectorsGrid onSelect={selectSector} />
      <Catalogue sectorKey={sectorKey} category={category} setCategory={setCategory} onSectorChange={changeSector} />
      <VisionValues />
      <DigitalEcosystem />
      <ComparisonTable />
      <ClientsMarquee />
      <AboutSection />
      <Footer />
    </main>
  );
}