import { ArrowLeft } from "lucide-react";

import productCollection from "@/assets/product-collection.jpg";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { SectionHeading } from "@/components/effects/SectionHeading";
import { Tilt } from "@/components/effects/Tilt";
import { Button } from "@/components/ui/button";
import { sectors, type SectorKey } from "@/lib/site-data";

const overlayBySector: Record<SectorKey, string> = {
    plastics: "from-ink/95 via-ink/40 to-transparent",
    food: "from-primary/95 via-primary/35 to-transparent",
    digital: "from-navy/95 via-navy/35 to-transparent",
};

export function SectorsGrid({ onSelect }: { onSelect: (key: SectorKey) => void }) {
    return (
        <section id="sectors" className="relative isolate overflow-hidden bg-pearl pb-24 pt-32 md:pb-32 md:pt-40">
            <MovingBg src={productCollection} tone="light" />
            <div className="relative mx-auto max-w-7xl px-5 md:px-8">
                <Reveal>
                    <SectionHeading
                        index="01"
                        eyebrow="BUSINESS SECTORS"
                        title={
                            <>
                                قطاعاتنا <span className="gradient-text-gold">الرئيسية</span>
                            </>
                        }
                        description="هيكل واضح يوصلك من القطاع إلى التصنيف ثم المنتج أو الخدمة المطلوبة."
                    >
                        <Button variant="outline" asChild>
                            <a href="#catalogue">
                                عرض الكتالوج <ArrowLeft size={16} />
                            </a>
                        </Button>
                    </SectionHeading>
                </Reveal>

                <div className="mt-16 grid gap-7 md:grid-cols-3">
                    {(Object.keys(sectors) as SectorKey[]).map((key, i) => {
                        const sector = sectors[key];
                        return (
                            <Reveal key={key} delay={i * 130} className={i === 1 ? "md:-translate-y-6" : ""}>
                                <Tilt max={8} className="rounded-3xl">
                                    <button
                                        onClick={() => onSelect(key)}
                                        aria-label={`عرض ${sector.title}`}
                                        className="gold-border group relative block min-h-[500px] w-full rounded-3xl text-right shadow-[0_45px_70px_-35px_oklch(0.257_0.077_262.1/0.65)]"
                                    >
                                        <div className="absolute inset-0 overflow-hidden rounded-3xl">
                                            <img
                                                src={sector.image}
                                                width={1200}
                                                height={800}
                                                loading="lazy"
                                                alt={sector.imageAlt}
                                                className="size-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                            />
                                            <div className={`absolute inset-0 bg-linear-to-t ${overlayBySector[key]}`} />
                                            <div className="absolute inset-0 bg-linear-to-br from-gold/25 via-transparent to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100" />
                                        </div>

                                        <span className="depth-md absolute right-6 top-6 flex size-12 items-center justify-center rounded-full border border-pearl/25 bg-ink/40 font-mono text-sm font-semibold text-gold-soft">
                                            {String(i + 1).padStart(2, "0")}
                                        </span>

                                        <div className="depth-lg absolute inset-x-0 bottom-0 p-8 text-pearl">
                                            <span className="font-mono text-xs tracking-widest text-gold-soft">{sector.english}</span>
                                            <h3 className="mt-3 text-2xl font-bold leading-tight md:text-3xl">{sector.title}</h3>
                                            <div className="mt-5 flex flex-wrap gap-2">
                                                {sector.categories.map((c) => (
                                                    <span key={c} className="rounded-full border border-pearl/25 bg-pearl/10 px-3 py-1 text-xs text-pearl/85">
                                                        {c}
                                                    </span>
                                                ))}
                                            </div>
                                            <span className="gradient-bg-gold mt-7 inline-flex size-12 items-center justify-center rounded-full text-ink transition-transform duration-300 group-hover:-translate-x-2">
                                                <ArrowLeft size={20} />
                                            </span>
                                        </div>
                                    </button>
                                </Tilt>
                            </Reveal>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}
