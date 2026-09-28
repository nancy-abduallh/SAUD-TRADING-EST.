import { MapPin, Ship } from "lucide-react";

import egypt from "@/assets/egypt.png";
import dubai from "@/assets/dubai.png";
import saudi from "@/assets/saudi.png";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { SectionHeading } from "@/components/effects/SectionHeading";
import { Tilt } from "@/components/effects/Tilt";
import { countries } from "@/lib/site-data";

const IMG = "h-full w-full rounded-3xl object-cover shadow-[0_40px_70px_-30px_oklch(0.158_0.036_265.6/0.8)] ring-1 ring-gold/40";

export function AboutSection() {
    return (
        <section id="about" className="relative isolate overflow-hidden bg-pearl py-24 md:py-32">
            <MovingBg src={egypt} tone="light" motion="pan" />
            <div className="relative mx-auto grid max-w-7xl items-center gap-16 px-5 md:px-8 lg:grid-cols-2">
                <div>
                    <Reveal>
                        <SectionHeading
                            index="07"
                            eyebrow="SAUD TRADING"
                            title={
                                <>
                                    توريد محسوب.
                                    <br />
                                    <span className="gradient-text-gold">شراكات تدوم.</span>
                                </>
                            }
                            description="نبني جسوراً موثوقة بين المنتجين والأسواق، مع عناية دقيقة بالجودة والامتثال وسرعة الوصول."
                        />
                    </Reveal>
                    <Reveal delay={120}>
                        <div className="mt-8 flex items-center gap-4 text-primary">
                            <span className="gradient-bg-gold flex size-12 items-center justify-center rounded-xl text-ink shadow-lg">
                                <Ship size={22} />
                            </span>
                            <span className="text-lg font-semibold">من المصدر إلى وجهتك بكفاءة ووضوح</span>
                        </div>
                    </Reveal>
                    <div className="mt-10 grid gap-4 sm:grid-cols-3">
                        {countries.map((country, i) => (
                            <Reveal key={country.name} delay={200 + i * 100}>
                                <Tilt max={10} className="rounded-2xl">
                                    <div className="glass-light gold-border rounded-2xl p-5 text-center">
                                        <span className="depth-md gradient-bg-navy mx-auto flex size-11 items-center justify-center rounded-full text-gold-soft">
                                            <MapPin size={18} />
                                        </span>
                                        <strong className="depth-sm mt-3 block text-primary">{country.name}</strong>
                                        <span className="mt-1 block font-mono text-[11px] text-muted-foreground">{country.english}</span>
                                    </div>
                                </Tilt>
                            </Reveal>
                        ))}
                    </div>
                </div>

                <Reveal delay={150}>
                    <div className="relative mx-auto h-[540px] w-full max-w-[540px]" style={{ perspective: "1400px" }}>
                        <div className="p3d absolute inset-0" style={{ transform: "rotateY(-16deg) rotateX(7deg)" }}>
                            <div className="absolute right-0 top-0 h-72 w-[78%]" style={{ transform: "translateZ(0)" }}>
                                <img src={dubai} alt="دبي" loading="lazy" className={`${IMG} anim-float`} />
                            </div>
                            <div className="absolute left-0 top-44 h-64 w-[62%]" style={{ transform: "translateZ(70px)" }}>
                                <img src={egypt} alt="مصر" loading="lazy" className={`${IMG} anim-float`} style={{ animationDelay: "-2.5s" }} />
                            </div>
                            <div className="absolute bottom-0 right-8 h-56 w-[58%]" style={{ transform: "translateZ(140px)" }}>
                                <img src={saudi} alt="السعودية" loading="lazy" className={`${IMG} anim-float`} style={{ animationDelay: "-5s" }} />
                            </div>
                            <div
                                className="glass-dark absolute bottom-24 left-2 rounded-2xl px-5 py-3 text-sm font-semibold text-pearl"
                                style={{ transform: "translateZ(200px)" }}
                            >
                                <span className="gradient-text-gold">الرياض</span> · المملكة العربية السعودية
                            </div>
                        </div>
                    </div>
                </Reveal>
            </div>
        </section>
    );
}
