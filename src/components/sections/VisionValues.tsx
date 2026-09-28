import { values, visionStatement } from "@/lib/site-data";

export function VisionValues() {
    return (
        <section id="vision" className="mx-auto max-w-7xl px-5 py-20 md:px-8 md:py-28">
            <div className="grid gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                <div>
                    <span className="font-mono text-xs text-gold">03 / OUR VISION</span>
                    <h2 className="mt-3 text-4xl font-bold text-primary md:text-5xl">رؤيتنا</h2>
                    <p className="mt-6 max-w-md text-lg leading-8 text-muted-foreground">{visionStatement}</p>
                </div>
                <div className="grid gap-px bg-border sm:grid-cols-2">
                    {values.map((value) => {
                        const Icon = value.icon;
                        return (
                            <div key={value.title} className="bg-background p-7">
                                <Icon size={30} strokeWidth={1.25} className="text-gold" />
                                <h3 className="mt-4 text-lg font-semibold text-primary">{value.title}</h3>
                                <p className="mt-2 text-sm leading-6 text-muted-foreground">{value.description}</p>
                            </div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}