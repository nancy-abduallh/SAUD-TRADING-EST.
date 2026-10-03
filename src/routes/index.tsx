import { createFileRoute } from "@tanstack/react-router";
import { lazy, useState } from "react";

import { Navbar } from "@/components/sections/Navbar";
import { HeroSlider } from "@/components/sections/HeroSlider";
import { StatsBar } from "@/components/sections/StatsBar";
import { SectorsGrid } from "@/components/sections/SectorsGrid";
import { VisionValues } from "@/components/sections/VisionValues";
import { DigitalEcosystem } from "@/components/sections/DigitalEcosystem";
import { ComparisonTable } from "@/components/sections/ComparisonTable";
import { AboutSection } from "@/components/sections/AboutSection";
import { Footer } from "@/components/sections/Footer";
import { LazySection } from "@/components/effects/LazySection";
import { sectors, type CategoryName, type SectorKey } from "@/lib/site-data";

// ── Code-split the two heaviest sections ────────────────────────────────────
// Catalogue pulls in ~57 product images; ClientsMarquee pulls in ~11 logos.
// Their JS chunks only download when the section enters the viewport.
const Catalogue = lazy(() =>
    import("@/components/sections/Catalogue").then((m) => ({ default: m.Catalogue })),
);
const ClientsMarquee = lazy(() =>
    import("@/components/sections/ClientsMarquee").then((m) => ({ default: m.ClientsMarquee })),
);

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
            {/* ── Above the fold — rendered eagerly during SSR ── */}
            <Navbar menuOpen={menuOpen} setMenuOpen={setMenuOpen} />
            <HeroSlider />
            <StatsBar />

            {/* ── Below the fold — deferred until approaching viewport ── */}
            <LazySection minHeight="700px" id="sectors">
                <SectorsGrid onSelect={selectSector} />
            </LazySection>
            <LazySection minHeight="800px" id="catalogue">
                <Catalogue sectorKey={sectorKey} category={category} setCategory={setCategory} onSectorChange={changeSector} />
            </LazySection>
            <LazySection minHeight="600px" id="vision">
                <VisionValues />
            </LazySection>
            <LazySection minHeight="600px" id="digital">
                <DigitalEcosystem />
            </LazySection>
            <LazySection minHeight="500px" id="compare">
                <ComparisonTable />
            </LazySection>
            <LazySection minHeight="500px" id="clients">
                <ClientsMarquee />
            </LazySection>
            <LazySection minHeight="500px" id="about">
                <AboutSection />
            </LazySection>
            <LazySection minHeight="400px" id="contact">
                <Footer />
            </LazySection>
        </main>
    );
}