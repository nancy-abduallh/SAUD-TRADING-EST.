import { useEffect, useRef, useState } from "react";

const AR_DIGITS = "٠١٢٣٤٥٦٧٨٩";
const toEn = (s: string) => s.replace(/[٠-٩]/g, (d) => String(AR_DIGITS.indexOf(d)));
const toAr = (n: number) => String(n).replace(/\d/g, (d) => AR_DIGITS.charAt(Number(d)));

/** Counts the first Arabic-Indic number in `value` up from 0 when scrolled into view. */
export function CountUp({ value, className, duration = 1800 }: { value: string; className?: string; duration?: number }) {
    const ref = useRef<HTMLSpanElement>(null);
    const [text, setText] = useState(value);

    useEffect(() => {
        const found = value.match(/[٠-٩]+/);
        const el = ref.current;
        if (!found || !el || window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
        const target = Number(toEn(found[0]));
        let raf = 0;
        setText(value.replace(found[0], toAr(0)));

        const io = new IntersectionObserver(
            ([entry]) => {
                if (!entry?.isIntersecting) return;
                io.disconnect();
                const start = performance.now();
                const tick = (now: number) => {
                    const p = Math.min(1, (now - start) / duration);
                    const eased = 1 - Math.pow(1 - p, 3);
                    setText(value.replace(found[0], toAr(Math.round(target * eased))));
                    if (p < 1) raf = requestAnimationFrame(tick);
                };
                raf = requestAnimationFrame(tick);
            },
            { threshold: 0.4 },
        );
        io.observe(el);
        return () => {
            io.disconnect();
            cancelAnimationFrame(raf);
        };
    }, [value, duration]);

    return (
        <span ref={ref} className={className}>
            {text}
        </span>
    );
}
