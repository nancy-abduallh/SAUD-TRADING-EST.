import { ArrowLeft, PackageCheck } from "lucide-react";

import { products, sectors, type CategoryName, type SectorKey } from "@/lib/site-data";
import { Button } from "@/components/ui/button";

const skuPrefix: Record<SectorKey, string> = {
    food: "FD",
    plastics: "PL",
    digital: "DG",
};

export function Catalogue({
    sectorKey,
    category,
    setCategory,
}: {
    sectorKey: SectorKey;
    category: CategoryName;
    setCategory: (category: CategoryName) => void;
}) {
    const sector = sectors[sectorKey];
    const visibleProducts = products[category] ?? [];

    return (
        <section id="catalogue" className="bg-ink py-20 text-pearl md:py-28">
            <div className="mx-auto max-w-7xl px-5 md:px-8">
                <div className="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
                    <div>
                        <span className="font-mono text-xs text-gold">02 / SMART CATALOGUE</span>
                        <h2 className="mt-3 text-4xl font-bold">{sector.title}</h2>
                        <p className="mt-4 max-w-lg leading-7 text-pearl/55">{sector.description}</p>
                        <div className="mt-8 grid gap-2">
                            {sector.categories.map((item) => (
                                <button
                                    key={item}
                                    onClick={() => setCategory(item as CategoryName)}
                                    className={`flex items-center justify-between border px-5 py-4 text-right transition-colors ${category === item ? "border-gold bg-gold text-ink" : "border-pearl/10 hover:border-gold/60"
                                        }`}
                                >
                                    <span>{item}</span>
                                    <ArrowLeft size={17} />
                                </button>
                            ))}
                        </div>
                    </div>
                    <div>
                        <div className="mb-6 flex items-center justify-between border-b border-pearl/10 pb-5">
                            <div>
                                <span className="text-xs text-gold">التصنيف المختار</span>
                                <h3 className="mt-1 text-2xl font-semibold">{category}</h3>
                            </div>
                            <PackageCheck className="text-gold" />
                        </div>
                        <div className="grid gap-px bg-pearl/10 md:grid-cols-3">
                            {visibleProducts.map((item, index) => {
                                const Icon = item.icon;
                                return (
                                    <article key={item.name} className="group bg-ink p-5">
                                        <div className="relative mb-5 flex aspect-square items-center justify-center overflow-hidden border border-pearl/10 bg-surface transition-colors group-hover:border-gold/50">
                                            <Icon size={42} strokeWidth={1.25} className="text-gold transition-transform duration-500 group-hover:scale-110" />
                                        </div>
                                        <span className="font-mono text-xs text-gold">
                                            {skuPrefix[sectorKey]}-{401 + index}
                                        </span>
                                        <h4 className="mt-2 text-lg font-semibold">{item.name}</h4>
                                        <p className="mt-2 text-sm leading-6 text-pearl/45">{item.blurb}</p>
                                        <Button variant="ghost" className="mt-4 px-0 text-gold">
                                            تفاصيل المنتج <ArrowLeft size={15} />
                                        </Button>
                                    </article>
                                );
                            })}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}