import { digitalEcosystem } from "@/lib/site-data";

export function DigitalEcosystem() {
    return (
        <section className="bg-navy py-20 text-pearl md:py-24">
            <div className="mx-auto max-w-7xl px-5 md:px-8">
                <div className="mb-12 max-w-2xl">
                    <span className="font-mono text-xs text-gold">04 / ONE INTEGRATED SYSTEM</span>
                    <h2 className="mt-3 text-4xl font-bold md:text-5xl">
                        منظومة رقمية متكاملة<span className="text-gold">..</span> عقلها واحد
                    </h2>
                    <p className="mt-4 leading-7 text-pearl/60">
                        نقدم حزمة متكاملة من الخدمات التي تعتمد كلياً على الذكاء الاصطناعي لضمان الاتساق والجودة في كل نقطة اتصال
                        مع عميلك.
                    </p>
                </div>
                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    {digitalEcosystem.map((item) => {
                        const Icon = item.icon;
                        return (
                            <div key={item.title} className="border border-pearl/10 p-6 transition-colors hover:border-gold/50">
                                <div className="flex size-12 items-center justify-center border border-gold/40 text-gold">
                                    <Icon size={22} strokeWidth={1.5} />
                                </div>
                                <h3 className="mt-5 font-semibold">{item.title}</h3>
                                <p className="mt-2 text-sm leading-6 text-pearl/55">{item.description}</p>
                            </div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}