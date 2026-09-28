import { cn } from "@/lib/utils";

type MovingBgProps = {
    src: string;
    tone?: "dark" | "light";
    motion?: "kenburns" | "pan";
    /** 0–1 opacity of the photo under the colour wash. */
    imageOpacity?: number;
    orbs?: boolean;
    grid?: boolean;
    className?: string;
};

/**
 * Full-bleed animated photo background for a section.
 * The parent must be `relative isolate overflow-hidden`; content goes in a `relative` wrapper.
 */
export function MovingBg({
    src,
    tone = "dark",
    motion = "kenburns",
    imageOpacity,
    orbs = true,
    grid = true,
    className,
}: MovingBgProps) {
    const dark = tone === "dark";
    return (
        <div aria-hidden className={cn("pointer-events-none absolute inset-0 -z-10 overflow-hidden", className)}>
            <img
                src={src}
                alt=""
                loading="lazy"
                decoding="async"
                className={cn("absolute inset-0 size-full object-cover", motion === "pan" ? "anim-pan" : "anim-kenburns")}
                style={{ opacity: imageOpacity ?? (dark ? 0.55 : 0.28) }}
            />
            <div
                className={cn(
                    "absolute inset-0",
                    dark
                        ? "bg-linear-to-b from-ink/95 via-navy/80 to-ink/95"
                        : "bg-linear-to-b from-pearl/95 via-pearl/80 to-sand/95",
                )}
            />
            {orbs && (
                <>
                    <span className="orb orb-a" data-tone={tone} />
                    <span className="orb orb-b" data-tone={tone} />
                </>
            )}
            {grid && <div className="grid-lines absolute inset-0" data-tone={tone} />}
            <div className="absolute inset-x-0 top-0 h-px bg-linear-to-r from-transparent via-gold/60 to-transparent" />
        </div>
    );
}
