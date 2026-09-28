import { ArrowLeft } from "lucide-react";

import { sectors, type SectorKey } from "@/lib/site-data";
import { Button } from "@/components/ui/button";

const overlayBySector: Record<SectorKey, string> = {
    plastics: "from-ink/90 via-ink/10 to-transparent",
    food: "from-primary/95 via-primary/10 to-transparent",
    digital: "from-navy/95 via-navy/15 to-transparent",
};

export function SectorsGrid({ onSelect }: { onSelect: (key: SectorKey) => void }) {
    return (
        <section id="sectors" className="mx-auto max-w-7xl px-5 py-20 md:px-8 md:py-28">
            <div className="mb-12 flex flex-col justify-between gap-5 md:flex-row md:items-end">
                <div>
                    <span className="font-mono text-xs text-gold">01 / BUSINESS SECTORS</span>
                    <h2 className="mt-3 text-4xl font-bold text-primary md:text-5xl">قطاعاتنا الرئيسية</h2>
                    <p className="mt-4 max-w-xl leading-7 text-muted-foreground">
                        هيكل واضح يوصلك من القطاع إلى التصنيف ثم المنتج أو الخدمة المطلوبة.
                    </p>
                </div>
                <Button variant="outline" asChild>
                    <a href="#catalogue">
                        عرض الكتالوج <ArrowLeft size={16} />
                    </a>
                </Button>
            </div>
            <div className="grid gap-5 md:grid-cols-3">
                {(Object.keys(sectors) as SectorKey[]).map((key) => {
                    const sector = sectors[key];
                    return (
                        <button
                            key={key}
                            onClick={() => onSelect(key)}
                            className="group relative min-h-[420px] overflow-hidden text-right"
                            aria-label={`عرض ${sector.title}`}
                        >
                            <img
                                src={sector.image}
                                width={1200}
                                height={800}
                                loading="lazy"
                                alt={sector.imageAlt}
                                className="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105"
                            />
                            <div className={`absolute inset-0 bg-linear-to-t ${overlayBySector[key]}`} />
                            <div className="absolute inset-x-0 bottom-0 p-7 text-pearl">
                                <span className="font-mono text-xs text-gold">{sector.english}</span>
                                <h3 className="mt-2 text-2xl font-bold md:text-3xl">{sector.title}</h3>
                                <p className="mt-3 text-sm text-pearl/75">{sector.categories.join(" · ")}</p>
                            </div>
                        </button>
                    );
                })}
            </div>
        </section>
    );
}