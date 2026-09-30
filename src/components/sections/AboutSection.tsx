import { MapPin, Ship } from "lucide-react";

import egypt from "@/assets/egypt.png";
import dubai from "@/assets/dubai.png";
import saudi from "@/assets/saudi.png";
import hero from "@/assets/hero-globe.jpg";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { SectionHeading } from "@/components/effects/SectionHeading";
import { Tilt } from "@/components/effects/Tilt";
import { countries } from "@/lib/site-data";

const IMG =
    "h-full w-full rounded-2xl object-cover shadow-[0_40px_70px_-30px_oklch(0.158_0.036_265.6/0.8)] ring-1 ring-gold/40 md:rounded-3xl";

/*
 * Mobile  : flat, tidy collage (no 3D tilt) so nothing gets cropped or scaled by perspective.
 * md & up : the original 3D layered look (rotateY/rotateX + translateZ on each layer).
 */
export function AboutSection() {
    return (
        <section id="about" className="relative isolate overflow-hidden bg-pearl py-20 md:py-32">
            <MovingBg src={hero} tone="light" motion="pan" />
            <div className="relative mx-auto grid max-w-7xl items-center gap-12 px-5 md:gap-16 md:px-8 lg:grid-cols-2">
                <div>
                    <Reveal>
                        <SectionHeading
                            index="07"
                            eyebrow="سعود التجارية"
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
                            <span className="gradient-bg-gold flex size-12 shrink-0 items-center justify-center rounded-xl text-ink shadow-lg">
                                <Ship size={22} />
                            </span>
                            <span className="text-base font-semibold sm:text-lg">من المصدر إلى وجهتك بكفاءة ووضوح</span>
                        </div>
                    </Reveal>
                    <div className="mt-8 grid grid-cols-3 gap-2.5 sm:gap-4 md:mt-10">
                        {countries.map((country, i) => (
                            <Reveal key={country.name} delay={200 + i * 100}>
                                <Tilt max={10} className="h-full rounded-2xl">
                                    <div className="glass-light gold-border h-full rounded-2xl p-3 text-center sm:p-5">
                                        <span className="depth-md gradient-bg-navy mx-auto flex size-9 items-center justify-center rounded-full text-gold-soft sm:size-11">
                                            <MapPin size={16} />
                                        </span>
                                        <strong className="depth-sm mt-2.5 block text-sm text-primary sm:mt-3 sm:text-base">{country.name}</strong>
                                        <span className="mt-1 block font-mono text-[9px] leading-snug text-muted-foreground sm:text-[11px]">
                                            {country.english}
                                        </span>
                                    </div>
                                </Tilt>
                            </Reveal>
                        ))}
                    </div>
                </div>

                <Reveal delay={150}>
                    <div className="relative mx-auto h-[440px] w-full max-w-[540px] md:h-[540px]" style={{ perspective: "1400px" }}>
                        <div className="p3d absolute inset-0 md:[transform:rotateY(-16deg)_rotateX(7deg)]">
                            {/* Dubai */}
                            <div className="absolute right-0 top-0 h-44 w-[74%] md:h-72 md:w-[78%]">
                                <img src={dubai} alt="دبي" loading="lazy" className={`${IMG} anim-float`} />
                            </div>
                            {/* Egypt */}
                            <div className="absolute left-0 top-[7.5rem] h-44 w-[58%] md:top-44 md:h-64 md:w-[62%] md:[transform:translateZ(70px)]">
                                <img src={egypt} alt="مصر" loading="lazy" className={`${IMG} anim-float`} style={{ animationDelay: "-2.5s" }} />
                            </div>
                            {/* Saudi Arabia */}
                            <div className="absolute bottom-16 right-4 h-44 w-[56%] md:bottom-0 md:right-8 md:h-56 md:w-[58%] md:[transform:translateZ(140px)]">
                                <img src={saudi} alt="السعودية" loading="lazy" className={`${IMG} anim-float`} style={{ animationDelay: "-5s" }} />
                            </div>
                            {/* Location chip: centred under the collage on mobile, floating on desktop */}
                            <div
                                className="glass-dark absolute bottom-0 left-0 right-0 mx-auto flex w-fit max-w-[calc(100%-1rem)] items-center gap-2 whitespace-nowrap rounded-full py-2.5 pe-5 ps-4 text-xs font-semibold text-pearl backdrop-blur-md sm:text-sm md:bottom-24 md:left-2 md:right-auto md:mx-0 md:rounded-2xl md:px-5 md:py-3 md:[transform:translateZ(200px)]"
                            >
                                <MapPin size={14} className="shrink-0 text-gold-soft" />
                                <span>
                                    <span className="gradient-text-gold">الرياض</span> · المملكة العربية السعودية
                                </span>
                            </div>
                        </div>
                    </div>
                </Reveal>
            </div>
        </section>
    );
}