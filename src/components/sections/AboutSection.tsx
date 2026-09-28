import { Ship } from "lucide-react";

import { countries } from "@/lib/site-data";

export function AboutSection() {
    return (
        <section id="about" className="border-b border-primary/10 bg-pearl py-20 md:py-28">
            <div className="mx-auto grid max-w-7xl gap-12 px-5 md:grid-cols-2 md:px-8">
                <div>
                    <span className="font-mono text-xs text-gold">07 / SAUD TRADING</span>
                    <h2 className="mt-3 text-4xl font-bold text-primary">
                        توريد محسوب.
                        <br />
                        شراكات تدوم.
                    </h2>
                </div>
                <div>
                    <p className="text-lg leading-8 text-muted-foreground">
                        نبني جسوراً موثوقة بين المنتجين والأسواق، مع عناية دقيقة بالجودة والامتثال وسرعة الوصول.
                    </p>
                    <div className="mt-7 flex items-center gap-3 text-primary">
                        <Ship />
                        <span className="font-semibold">من المصدر إلى وجهتك بكفاءة ووضوح</span>
                    </div>
                    <div className="mt-8 flex flex-wrap gap-3">
                        {countries.map((country) => (
                            <span
                                key={country.name}
                                className="border border-primary/15 px-4 py-2 text-sm font-medium text-primary"
                            >
                                {country.name}
                            </span>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}