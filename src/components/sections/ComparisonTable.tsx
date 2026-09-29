import { Check, X } from "lucide-react";

import plasticsSector from "@/assets/plastics-sector.jpg";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { SectionHeading } from "@/components/effects/SectionHeading";
import { Tilt } from "@/components/effects/Tilt";
import { comparisonRows } from "@/lib/site-data";

const COLS = "md:grid-cols-[0.7fr_1fr_1.2fr]";

export function ComparisonTable() {
    return (
        <section id="compare" className="relative isolate overflow-hidden bg-pearl py-24 md:py-32">
            <MovingBg src={plasticsSector} tone="light" />
            <div className="relative mx-auto max-w-5xl px-5 md:px-8">
                <Reveal>
                    <SectionHeading
                        index="05"
                        eyebrow="لماذا هذا مهم"
                        align="center"
                        title={
                            <>
                                الفارق بين الجيد<span className="gradient-text-gold">..</span> والاستثنائي
                            </>
                        }
                    />
                </Reveal>

                <div className="mt-14">
                    <div className={`hidden gap-4 px-2 pb-4 text-sm font-semibold md:grid ${COLS}`}>
                        <span className="text-primary/60">المعيار</span>
                        <span className="text-primary/60">الطرق التقليدية</span>
                        <span className="gradient-text-gold text-base">حلول الذكاء الاصطناعي</span>
                    </div>
                    <div className="grid gap-4">
                        {comparisonRows.map((row, i) => (
                            <Reveal key={row.label} delay={i * 110}>
                                <div className={`grid gap-3 md:gap-4 ${COLS}`}>
                                    <div className="glass-light flex items-center rounded-2xl px-6 py-5 text-lg font-bold text-primary">{row.label}</div>
                                    <div className="glass-light flex items-start gap-3 rounded-2xl p-5 text-muted-foreground">
                                        <span className="mt-0.5 flex size-7 shrink-0 items-center justify-center rounded-full bg-destructive/10 text-destructive">
                                            <X size={15} />
                                        </span>
                                        <div>
                                            <span className="mb-1 block text-xs text-primary/50 md:hidden">الطرق التقليدية</span>
                                            {row.traditional}
                                        </div>
                                    </div>
                                    <Tilt max={5} className="h-full rounded-2xl">
                                        <div className="gradient-bg-navy flex h-full items-start gap-3 rounded-2xl border border-gold/40 p-5 text-pearl shadow-[0_28px_50px_-24px_oklch(0.257_0.077_262.1/0.8)]">
                                            <span className="gradient-bg-gold depth-md mt-0.5 flex size-7 shrink-0 items-center justify-center rounded-full text-ink">
                                                <Check size={15} strokeWidth={3} />
                                            </span>
                                            <div className="depth-sm">
                                                <span className="mb-1 block text-xs text-gold-soft md:hidden">حلول الذكاء الاصطناعي</span>
                                                <span className="font-medium leading-6">{row.smart}</span>
                                            </div>
                                        </div>
                                    </Tilt>
                                </div>
                            </Reveal>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}
