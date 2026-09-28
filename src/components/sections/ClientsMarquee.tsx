import { clients } from "@/lib/site-data";

export function ClientsMarquee() {
    const track = [...clients, ...clients];

    return (
        <section id="clients" className="border-y border-border bg-ink py-16 text-pearl md:py-20">
            <div className="mx-auto max-w-7xl px-5 md:px-8">
                <div className="mb-10 text-center">
                    <span className="font-mono text-xs text-gold">06 / TRUSTED BY</span>
                    <h2 className="mt-3 text-3xl font-bold md:text-4xl">عملاؤنا</h2>
                </div>
            </div>
            <div className="relative overflow-hidden">
                <div className="pointer-events-none absolute inset-y-0 right-0 z-10 w-24 bg-linear-to-l from-ink to-transparent" />
                <div className="pointer-events-none absolute inset-y-0 left-0 z-10 w-24 bg-linear-to-r from-ink to-transparent" />
                <div dir="ltr" className="animate-marquee flex w-max gap-4">
                    {track.map((client, index) => (
                        <span
                            key={`${client}-${index}`}
                            className="whitespace-nowrap border border-pearl/10 px-6 py-4 text-sm font-semibold text-pearl/70 transition-colors hover:border-gold/50 hover:text-gold"
                        >
                            {client}
                        </span>
                    ))}
                </div>
            </div>
        </section>
    );
}