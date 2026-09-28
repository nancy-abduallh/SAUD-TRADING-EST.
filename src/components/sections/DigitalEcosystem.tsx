import { Bot } from "lucide-react";

import heroGlobe from "@/assets/hero-globe.jpg";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { SectionHeading } from "@/components/effects/SectionHeading";
import { Tilt } from "@/components/effects/Tilt";
import { digitalEcosystem } from "@/lib/site-data";

const FACES = ["front", "back", "right", "left", "top", "bottom"] as const;

function AiCube() {
    return (
        <div className="cube-scene" aria-hidden>
            <div className="ring" />
            <div className="ring ring-2" />
            <div className="cube">
                {FACES.map((face) => (
                    <div key={face} className={`cube-face cube-${face}`}>
                        <Bot size={34} strokeWidth={1.25} />
                    </div>
                ))}
            </div>
        </div>
    );
}

export function DigitalEcosystem() {
    return (
        <section id="digital" className="relative isolate overflow-hidden bg-navy py-24 text-pearl md:py-32">
            <MovingBg src={heroGlobe} tone="dark" imageOpacity={0.6} />
            <div className="relative mx-auto max-w-7xl px-5 md:px-8">
                <div className="grid items-center gap-10 lg:grid-cols-[1.4fr_0.6fr]">
                    <Reveal>
                        <SectionHeading
                            index="04"
                            eyebrow="ONE INTEGRATED SYSTEM"
                            tone="dark"
                            title={
                                <>
                                    منظومة رقمية متكاملة<span className="gradient-text-gold">..</span> عقلها واحد
                                </>
                            }
                            description="نقدم حزمة متكاملة من الخدمات التي تعتمد كلياً على الذكاء الاصطناعي لضمان الاتساق والجودة في كل نقطة اتصال مع عميلك."
                        />
                    </Reveal>
                    <Reveal delay={200}>
                        <AiCube />
                    </Reveal>
                </div>

                <div className="relative mt-20 pt-7">
                    <div className="absolute inset-x-[10%] top-7 hidden h-px bg-linear-to-r from-transparent via-gold/70 to-transparent lg:block" />
                    <div className="grid gap-x-6 gap-y-14 sm:grid-cols-2 lg:grid-cols-4">
                        {digitalEcosystem.map((item, i) => {
                            const Icon = item.icon;
                            return (
                                <Reveal key={item.title} delay={i * 120} className="h-full">
                                    <Tilt max={9} className="h-full rounded-2xl">
                                        <div className="glass-dark gold-border relative h-full rounded-2xl p-7 pt-12">
                                            <span className="depth-lg gradient-bg-gold anim-pulse-ring absolute -top-7 right-7 flex size-14 items-center justify-center rounded-2xl text-ink shadow-xl">
                                                <Icon size={24} strokeWidth={1.6} />
                                            </span>
                                            <span className="absolute bottom-3 left-5 font-mono text-6xl font-bold text-pearl/[0.05]">0{i + 1}</span>
                                            <h3 className="depth-sm text-lg font-semibold">{item.title}</h3>
                                            <p className="mt-2 text-sm leading-6 text-pearl/60">{item.description}</p>
                                        </div>
                                    </Tilt>
                                </Reveal>
                            );
                        })}
                    </div>
                </div>
            </div>
        </section>
    );
}
