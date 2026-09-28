import { comparisonRows } from "@/lib/site-data";

export function ComparisonTable() {
    return (
        <section className="bg-pearl py-20 md:py-28">
            <div className="mx-auto max-w-5xl px-5 md:px-8">
                <div className="mb-12 text-center">
                    <span className="font-mono text-xs text-gold">05 / WHY IT MATTERS</span>
                    <h2 className="mt-3 text-4xl font-bold text-primary md:text-5xl">
                        الفارق بين الجيد<span className="text-gold">..</span> والاستثنائي
                    </h2>
                </div>
                <div className="overflow-hidden border border-border">
                    <div className="grid grid-cols-3 bg-navy text-pearl">
                        <div className="p-4 text-sm font-semibold md:p-5">المعيار</div>
                        <div className="p-4 text-sm font-semibold text-pearl/70 md:p-5">الطرق التقليدية</div>
                        <div className="p-4 text-sm font-semibold text-gold md:p-5">حلول الذكاء الاصطناعي</div>
                    </div>
                    {comparisonRows.map((row, index) => (
                        <div
                            key={row.label}
                            className={`grid grid-cols-3 ${index % 2 === 0 ? "bg-background" : "bg-sand/60"}`}
                        >
                            <div className="p-4 text-sm font-semibold text-primary md:p-5">{row.label}</div>
                            <div className="p-4 text-sm leading-6 text-muted-foreground md:p-5">{row.traditional}</div>
                            <div className="p-4 text-sm font-medium leading-6 text-primary md:p-5">{row.smart}</div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}