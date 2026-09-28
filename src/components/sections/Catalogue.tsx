import { ArrowLeft, Boxes, MonitorSmartphone, PackageCheck, Wheat, type LucideIcon } from "lucide-react";

import saoudPort from "@/assets/saoud-port-hero.jpg";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { SectionHeading } from "@/components/effects/SectionHeading";
import { Tilt } from "@/components/effects/Tilt";
import { Button } from "@/components/ui/button";
import { products, sectors, type CategoryName, type SectorKey } from "@/lib/site-data";
import { cn } from "@/lib/utils";

const skuPrefix: Record<SectorKey, string> = {
    food: "FD",
    plastics: "PL",
    digital: "DG",
};

const sectorIcon: Record<SectorKey, LucideIcon> = {
    food: Wheat,
    plastics: Boxes,
    digital: MonitorSmartphone,
};

const sectorShort: Record<SectorKey, string> = {
    food: "الغذاء",
    plastics: "البلاستيك",
    digital: "الرقمي",
};

export function Catalogue({
    sectorKey,
    category,
    setCategory,
    onSectorChange,
}: {
    sectorKey: SectorKey;
    category: CategoryName;
    setCategory: (category: CategoryName) => void;
    onSectorChange: (key: SectorKey) => void;
}) {
    const sector = sectors[sectorKey];
    const visibleProducts = products[category] ?? [];

    return (
        <section id="catalogue" className="relative isolate overflow-hidden bg-ink py-24 text-pearl md:py-32">
            <MovingBg src={saoudPort} tone="dark" motion="pan" imageOpacity={0.5} />
            <div className="relative mx-auto max-w-7xl px-5 md:px-8">
                <Reveal>
                    <SectionHeading
                        index="02"
                        eyebrow="SMART CATALOGUE"
                        tone="dark"
                        title={<span className="gradient-text-gold">{sector.title}</span>}
                        description={sector.description}
                    >
                        <div className="glass-dark flex gap-1 rounded-full p-1.5">
                            {(Object.keys(sectors) as SectorKey[]).map((key) => {
                                const Icon = sectorIcon[key];
                                const active = key === sectorKey;
                                return (
                                    <button
                                        key={key}
                                        onClick={() => onSectorChange(key)}
                                        className={cn(
                                            "flex items-center gap-2 rounded-full px-4 py-2.5 text-sm font-semibold transition-all",
                                            active ? "gradient-bg-gold text-ink shadow-lg" : "text-pearl/70 hover:text-gold-soft",
                                        )}
                                    >
                                        <Icon size={16} />
                                        {sectorShort[key]}
                                    </button>
                                );
                            })}
                        </div>
                    </SectionHeading>
                </Reveal>

                <div className="mt-14 grid gap-10 lg:grid-cols-[0.75fr_1.25fr] lg:items-start">
                    <Reveal>
                        <div className="grid gap-3">
                            {sector.categories.map((item, i) => {
                                const active = category === item;
                                return (
                                    <button
                                        key={item}
                                        onClick={() => setCategory(item as CategoryName)}
                                        className={cn(
                                            "group flex items-center justify-between rounded-2xl border px-5 py-5 text-right transition-all duration-300",
                                            active
                                                ? "gradient-bg-gold border-gold text-ink shadow-[0_18px_40px_-16px_oklch(0.655_0.106_75.6/0.8)]"
                                                : "border-pearl/10 bg-pearl/5 hover:-translate-x-1 hover:border-gold/50 hover:bg-pearl/10",
                                        )}
                                    >
                                        <span className="flex items-center gap-4">
                                            <span className={cn("font-mono text-xs", active ? "text-ink/60" : "text-gold")}>0{i + 1}</span>
                                            <span className="font-semibold">{item}</span>
                                        </span>
                                        <ArrowLeft size={17} className="transition-transform group-hover:-translate-x-1" />
                                    </button>
                                );
                            })}
                        </div>
                    </Reveal>

                    <div>
                        <div className="mb-7 flex items-center justify-between rounded-2xl border border-pearl/10 bg-pearl/5 px-6 py-5">
                            <div>
                                <span className="text-xs text-gold-soft">التصنيف المختار</span>
                                <h3 className="mt-1 text-2xl font-semibold">{category}</h3>
                            </div>
                            <span className="flex items-center gap-3">
                                <span className="font-mono text-sm text-pearl/50">{visibleProducts.length} ITEMS</span>
                                <span className="gradient-bg-gold flex size-11 items-center justify-center rounded-xl text-ink">
                                    <PackageCheck size={20} />
                                </span>
                            </span>
                        </div>

                        <div key={category} className="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                            {visibleProducts.map((item, index) => {
                                const Icon = item.icon;
                                return (
                                    <Reveal key={item.name} delay={index * 80} className="h-full">
                                        <Tilt max={10} className="h-full rounded-2xl">
                                            <article className="glass-dark gold-border group h-full rounded-2xl p-5">
                                                <div className="depth-sm relative mb-5 flex aspect-[4/3] items-center justify-center overflow-hidden rounded-xl border border-pearl/10 bg-linear-to-br from-navy-2 via-surface to-ink">
                                                    <span className="absolute inset-0 bg-[radial-gradient(circle_at_50%_120%,oklch(0.655_0.106_75.6/0.4),transparent_62%)]" />
                                                    <Icon
                                                        size={46}
                                                        strokeWidth={1.25}
                                                        className="relative text-gold-soft transition-transform duration-500 group-hover:-rotate-6 group-hover:scale-110"
                                                    />
                                                </div>
                                                <span className="depth-md block font-mono text-xs text-gold">
                                                    {skuPrefix[sectorKey]}-{401 + index}
                                                </span>
                                                <h4 className="depth-md mt-2 text-lg font-semibold">{item.name}</h4>
                                                <p className="mt-2 text-sm leading-6 text-pearl/55">{item.blurb}</p>
                                                <Button variant="ghost" className="depth-sm mt-4 px-0 text-gold-soft hover:bg-transparent hover:text-gold">
                                                    تفاصيل المنتج <ArrowLeft size={15} />
                                                </Button>
                                            </article>
                                        </Tilt>
                                    </Reveal>
                                );
                            })}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
