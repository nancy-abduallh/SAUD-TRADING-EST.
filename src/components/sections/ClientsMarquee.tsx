import heroSkyline from "@/assets/hero-skyline.jpg";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { SectionHeading } from "@/components/effects/SectionHeading";
import { clients } from "@/lib/site-data";

const MASK = "[mask-image:linear-gradient(to_right,transparent,black_12%,black_88%,transparent)]";

function Row({ items, reverse = false }: { items: string[]; reverse?: boolean }) {
    const track = [...items, ...items];
    return (
        <div className={`overflow-hidden ${MASK}`}>
            <div dir="ltr" className={`flex w-max gap-4 hover:[animation-play-state:paused] ${reverse ? "animate-marquee-reverse" : "animate-marquee"}`}>
                {track.map((client, index) => (
                    <span
                        key={`${client}-${index}`}
                        className="glass-dark inline-flex items-center gap-3 whitespace-nowrap rounded-full px-7 py-4 text-sm font-semibold text-pearl/80 transition-colors hover:border-gold/60 hover:text-gold-soft"
                    >
                        <span className="gradient-bg-gold size-1.5 rounded-full" />
                        {client}
                    </span>
                ))}
            </div>
        </div>
    );
}

export function ClientsMarquee() {
    return (
        <section id="clients" className="relative isolate overflow-hidden bg-ink py-24 text-pearl md:py-28">
            <MovingBg src={heroSkyline} tone="dark" motion="pan" imageOpacity={0.5} />
            <div className="relative">
                <Reveal className="mx-auto mb-14 max-w-7xl px-5 md:px-8">
                    <SectionHeading
                        index="06"
                        eyebrow="TRUSTED BY"
                        tone="dark"
                        align="center"
                        title={
                            <>
                                <span className="gradient-text-gold">عملاؤنا</span>
                            </>
                        }
                        description="نفخر بثقة جهات رائدة في القطاعين الحكومي والخاص."
                    />
                </Reveal>
                <div className="grid gap-4">
                    <Row items={clients} />
                    <Row items={[...clients].reverse()} reverse />
                </div>
            </div>
        </section>
    );
}
