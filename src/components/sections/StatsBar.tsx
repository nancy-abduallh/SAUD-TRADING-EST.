import { Clock, Globe, Layers, Package, type LucideIcon } from "lucide-react";

import { CountUp } from "@/components/effects/CountUp";
import { Reveal } from "@/components/effects/Reveal";
import { stats } from "@/lib/site-data";

// One icon per stat, in the same order as `stats` in site-data.ts
const ICONS: LucideIcon[] = [Globe, Package, Layers, Clock];

export function StatsBar() {
    return (
        <section id="supply" className="relative z-20 -mt-20 px-5 md:px-8">
            <Reveal className="mx-auto max-w-6xl">
                <div className="relative overflow-hidden rounded-3xl border border-gold/30 bg-linear-to-br from-navy-2 via-navy to-ink shadow-[0_30px_60px_-30px_oklch(0.158_0.036_265.6/0.75)]">
                    {/* gold hairline + soft glow */}
                    <span className="absolute inset-x-10 top-0 h-px bg-linear-to-r from-transparent via-gold to-transparent" />
                    <span className="pointer-events-none absolute -top-24 left-1/2 size-64 -translate-x-1/2 rounded-full bg-gold/15 blur-3xl" />

                    <div className="relative grid grid-cols-2 md:grid-cols-4">
                        {stats.map(([value, label], i) => {
                            const Icon = ICONS[i % ICONS.length] ?? Globe;
                            return (
                                <div
                                    key={label}
                                    className={[
                                        "flex flex-col items-center border-pearl/10 px-4 py-8 text-center md:py-10",
                                        // RTL: the divider sits on the right edge of every card except the first
                                        i === 0 ? "" : i % 2 === 1 ? "border-r" : "md:border-r",
                                        i >= 2 ? "border-t md:border-t-0" : "",
                                    ].join(" ")}
                                >
                                    <span className="gradient-bg-gold mb-4 flex size-11 items-center justify-center rounded-xl text-ink shadow-[0_10px_24px_-10px_oklch(0.655_0.106_75.6/0.9)]">
                                        <Icon size={20} strokeWidth={1.8} />
                                    </span>
                                    <CountUp value={value} className="gradient-text-gold block text-3xl font-bold leading-tight md:text-4xl" />
                                    <span className="mt-2 block text-sm text-pearl/70">{label}</span>
                                </div>
                            );
                        })}
                    </div>
                </div>
            </Reveal>
        </section>
    );
}