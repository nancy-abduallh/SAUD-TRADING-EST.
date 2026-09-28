import { useEffect, useRef, useState, type CSSProperties, type ReactNode } from "react";

import { cn } from "@/lib/utils";

type RevealProps = {
    children: ReactNode;
    className?: string;
    /** Stagger delay in ms. */
    delay?: number;
    /** Start offset in px. */
    y?: number;
};

/** Fades + slides its children in the first time they scroll into view. */
export function Reveal({ children, className, delay = 0, y = 32 }: RevealProps) {
    const ref = useRef<HTMLDivElement>(null);
    const [shown, setShown] = useState(false);

    useEffect(() => {
        const el = ref.current;
        if (!el) return;
        if (typeof IntersectionObserver === "undefined") {
            setShown(true);
            return;
        }
        const io = new IntersectionObserver(
            ([entry]) => {
                if (entry?.isIntersecting) {
                    setShown(true);
                    io.disconnect();
                }
            },
            { threshold: 0.1, rootMargin: "0px 0px -6% 0px" },
        );
        io.observe(el);
        return () => io.disconnect();
    }, []);

    return (
        <div
            ref={ref}
            className={cn("reveal", shown && "is-in", className)}
            style={{ transitionDelay: `${delay}ms`, "--reveal-y": `${y}px` } as CSSProperties}
        >
            {children}
        </div>
    );
}
