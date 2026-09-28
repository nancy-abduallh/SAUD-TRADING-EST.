import { Quote } from "lucide-react";

import globeNetwork from "@/assets/globe-network.jpg";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { SectionHeading } from "@/components/effects/SectionHeading";
import { Tilt } from "@/components/effects/Tilt";
import { values, visionStatement } from "@/lib/site-data";

export function VisionValues() {
    return (
        <section id="vision" className="relative isolate overflow-hidden bg-sand py-24 md:py-32">
            <MovingBg src={globeNetwork} tone="light" motion="pan" imageOpacity={0.4} />
            <div className="relative mx-auto max-w-7xl px-5 md:px-8">
                <Reveal>
                    <SectionHeading
                        index="03"
                        eyebrow="OUR VISION"
                        title={
                            <>
                                رؤيتنا <span className="gradient-text-gold">وقيمنا</span>
                            </>
                        }
                    />
                </Reveal>

                <div className="mt-14 grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-stretch">
                    <Reveal className="h-full">
                        <Tilt max={6} className="h-full rounded-3xl">
                            <div className="gradient-bg-navy relative flex h-full min-h-[420px] flex-col justify-between rounded-3xl border border-gold/30 p-10 text-pearl shadow-[0_50px_80px_-40px_oklch(0.158_0.036_265.6)]">
                                <span className="depth-lg gradient-bg-gold flex size-16 items-center justify-center rounded-2xl text-ink shadow-xl">
                                    <Quote size={28} />
                                </span>
                                <p className="depth-md mt-10 text-2xl font-medium leading-[2.6rem]">{visionStatement}</p>
                                <div className="depth-sm mt-10 flex items-center gap-4">
                                    <span className="h-px flex-1 bg-linear-to-l from-gold/70 to-transparent" />
                                    <span className="font-mono text-xs tracking-widest text-gold-soft">VISION 2030 READY</span>
                                </div>
                                <div className="ring pointer-events-none !inset-auto -bottom-24 -left-24 size-72 opacity-60" />
                            </div>
                        </Tilt>
                    </Reveal>

                    <div className="grid gap-5 sm:grid-cols-2">
                        {values.map((value, i) => {
                            const Icon = value.icon;
                            return (
                                <Reveal key={value.title} delay={i * 90} className="h-full">
                                    <Tilt max={9} className="h-full rounded-2xl">
                                        <div className="glass-light gold-border relative h-full rounded-2xl p-7">
                                            <span className="absolute left-5 top-3 font-mono text-5xl font-bold text-primary/[0.06]">0{i + 1}</span>
                                            <span className="depth-md gradient-bg-gold flex size-14 items-center justify-center rounded-xl text-ink shadow-[0_14px_30px_-10px_oklch(0.655_0.106_75.6/0.8)]">
                                                <Icon size={26} strokeWidth={1.5} />
                                            </span>
                                            <h3 className="depth-sm mt-5 text-lg font-bold text-primary">{value.title}</h3>
                                            <p className="mt-2 text-sm leading-6 text-muted-foreground">{value.description}</p>
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
