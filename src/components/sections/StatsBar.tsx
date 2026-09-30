import { Clock, Globe, Layers, Package, type LucideIcon } from "lucide-react";

import { CountUp } from "@/components/effects/CountUp";
import { Reveal } from "@/components/effects/Reveal";
import { stats } from "@/lib/site-data";
import { cn } from "@/lib/utils";

// One icon per stat, in the same order as `stats` in site-data.ts
const ICONS: LucideIcon[] = [Globe, Package, Layers, Clock];

export function StatsBar() {
    return (
        <section id="supply" className="relative z-20 -mt-14 px-4 md:-mt-20 md:px-8">
            <Reveal className="mx-auto max-w-6xl">
                <div className="relative overflow-hidden rounded-2xl border border-gold/30 bg-linear-to-br from-navy-2 via-navy to-ink shadow-[0_30px_60px_-30px_oklch(0.158_0.036_265.6/0.75)] md:rounded-3xl">
                    {/* gold hairline + soft glow */}
                    <span className="absolute inset-x-8 top-0 h-px bg-linear-to-r from-transparent via-gold to-transparent md:inset-x-10" />
                    <span className="pointer-events-none absolute -top-24 left-1/2 size-64 -translate-x-1/2 rounded-full bg-gold/15 blur-3xl" />

                    <div className="relative grid grid-cols-2 md:grid-cols-4">
                        {stats.map(([value, label], i) => {
                            const Icon = ICONS[i % ICONS.length] ?? Globe;
                            return (
                                <div
                                    key={label}
                                    className={cn(
                                        "flex flex-col items-center border-gold/15 px-3 py-6 text-center sm:px-4 md:py-10",
                                        // RTL-safe dividers: the line sits on the start edge (right side) of every card
                                        // that isn't first in its row.
                                        i === 0 ? "" : i % 2 === 1 ? "border-s" : "md:border-s",
                                        i >= 2 && "border-t md:border-t-0",
                                    )}
                                >
                                    <span className="gradient-bg-gold mb-3.5 flex size-10 items-center justify-center rounded-xl text-ink shadow-[0_10px_24px_-10px_oklch(0.655_0.106_75.6/0.9)] ring-4 ring-gold/10 md:mb-4 md:size-11">
                                        <Icon size={19} strokeWidth={1.8} />
                                    </span>
                                    <CountUp
                                        value={value}
                                        className="gradient-text-gold block text-[1.65rem] font-bold leading-tight tabular-nums sm:text-3xl md:text-4xl"
                                    />
                                    <span className="mt-1.5 block text-xs text-pearl/70 sm:text-sm md:mt-2">{label}</span>
                                    {/* small gold accent, mobile only */}
                                    <span aria-hidden className="mt-3 h-0.5 w-6 rounded-full bg-gold/50 md:hidden" />
                                </div>
                            );
                        })}
                    </div>
                </div>
            </Reveal>
        </section>
    );
}