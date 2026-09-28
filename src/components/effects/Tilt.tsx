import { useRef, type CSSProperties, type PointerEvent, type ReactNode } from "react";

import { cn } from "@/lib/utils";

type TiltProps = {
    children: ReactNode;
    className?: string;
    /** Max rotation in degrees. */
    max?: number;
    /** Hover scale. */
    scale?: number;
    glare?: boolean;
};

/** Mouse-driven 3D tilt with a moving light glare. Touch devices skip the tilt. */
export function Tilt({ children, className, max = 9, scale = 1.02, glare = true }: TiltProps) {
    const ref = useRef<HTMLDivElement>(null);
    const frame = useRef(0);

    const onMove = (e: PointerEvent<HTMLDivElement>) => {
        if (e.pointerType !== "mouse") return;
        const el = ref.current;
        if (!el) return;
        const rect = el.getBoundingClientRect();
        const px = (e.clientX - rect.left) / rect.width;
        const py = (e.clientY - rect.top) / rect.height;
        cancelAnimationFrame(frame.current);
        frame.current = requestAnimationFrame(() => {
            el.style.setProperty("--ry", `${(px - 0.5) * max * 2}deg`);
            el.style.setProperty("--rx", `${(0.5 - py) * max * 2}deg`);
            el.style.setProperty("--mx", `${px * 100}%`);
            el.style.setProperty("--my", `${py * 100}%`);
        });
    };

    const onLeave = () => {
        cancelAnimationFrame(frame.current);
        const el = ref.current;
        if (!el) return;
        el.style.setProperty("--rx", "0deg");
        el.style.setProperty("--ry", "0deg");
    };

    return (
        <div
            ref={ref}
            onPointerMove={onMove}
            onPointerLeave={onLeave}
            className={cn("tilt", className)}
            style={{ "--tilt-scale": scale } as CSSProperties}
        >
            {children}
            {glare && <span aria-hidden className="tilt-glare" />}
        </div>
    );
}
