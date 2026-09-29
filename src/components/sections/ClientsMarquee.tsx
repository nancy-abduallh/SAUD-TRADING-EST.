import type { CSSProperties } from "react";

import heroSkyline from "@/assets/hero-skyline.jpg";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { SectionHeading } from "@/components/effects/SectionHeading";
import { clients } from "@/lib/site-data";

/** Small gold divider (line — diamond — line) shown under the heading. */
function GoldDivider() {
    return (
        <div aria-hidden className="mx-auto mb-12 flex items-center justify-center gap-3">
            <span className="h-px w-16 bg-gradient-to-r from-transparent to-gold/70 md:w-28" />
            <span className="gradient-bg-gold size-2 rotate-45" />
            <span className="h-px w-16 bg-gradient-to-l from-transparent to-gold/70 md:w-28" />
        </div>
    );
}

/**
 * Per-logo timing so the grid never moves in lockstep:
 *  - float: each logo bobs with a slightly different speed and starts mid-cycle
 *  - shine: the light sweep is staggered so it ripples across the grid
 * All animations are switched off by the global prefers-reduced-motion rule.
 */
function motionVars(index: number): CSSProperties {
    return {
        "--float-dur": `${5 + (index % 4) * 0.8}s`,
        "--float-delay": `-${((index * 1.3) % 5).toFixed(1)}s`,
        "--shine-delay": `${(index * 0.45).toFixed(2)}s`,
    } as CSSProperties;
}

export function ClientsMarquee() {
    return (
        <section id="clients" className="relative isolate overflow-hidden bg-ink py-24 text-pearl md:py-28">
            <MovingBg src={heroSkyline} tone="dark" motion="pan" imageOpacity={0.5} />
            <div className="relative mx-auto max-w-7xl px-5 md:px-8">
                <Reveal className="mb-8">
                    <SectionHeading
                        index="06"
                        eyebrow="نفخر بثقتهم"
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

                <GoldDivider />

                {/* Logo grid: 2 cols on mobile, 3 on tablet, 4 on desktop.
                    flex-wrap + justify-center keeps a short last row centered (4 / 4 / 3). */}
                <ul dir="ltr" className="flex flex-wrap justify-center gap-y-6 md:gap-y-10">
                    {clients.map((client, index) => (
                        <li key={client.name} className="flex w-1/2 justify-center md:w-1/3 lg:w-1/4">
                            <Reveal delay={index * 60} y={20} className="w-full">
                                {/* 1) floating motion (pauses while hovered) */}
                                <div
                                    style={motionVars(index)}
                                    className="anim-logo-float flex h-28 items-center justify-center px-4 hover:[animation-play-state:paused] md:h-36 md:px-6"
                                >
                                    {/* 2) hover zoom + glow */}
                                    <div className="group relative max-w-[85%] transition duration-500 hover:scale-110">
                                        <img
                                            src={client.logo}
                                            alt={client.name}
                                            loading="lazy"
                                            decoding="async"
                                            draggable={false}
                                            className="block max-h-20 w-auto max-w-full object-contain opacity-90 drop-shadow-[0_0_18px_oklch(0.75_0.1_80/0.18)] transition duration-500 group-hover:opacity-100 group-hover:drop-shadow-[0_0_26px_oklch(0.8_0.12_82/0.45)] md:max-h-24"
                                        />
                                        {/* 3) light sweep, masked to the logo's own shape */}
                                        <span
                                            aria-hidden
                                            className="anim-logo-shine pointer-events-none absolute inset-0 mix-blend-plus-lighter"
                                            style={{
                                                ...motionVars(index),
                                                WebkitMaskImage: `url(${client.logo})`,
                                                maskImage: `url(${client.logo})`,
                                                WebkitMaskSize: "100% 100%",
                                                maskSize: "100% 100%",
                                                WebkitMaskRepeat: "no-repeat",
                                                maskRepeat: "no-repeat",
                                            }}
                                        />
                                    </div>
                                </div>
                            </Reveal>
                        </li>
                    ))}
                </ul>
            </div>
        </section>
    );
}