import type { ReactNode } from "react";

import { cn } from "@/lib/utils";

type SectionHeadingProps = {
    index: string;
    eyebrow: string;
    title: ReactNode;
    description?: ReactNode;
    tone?: "dark" | "light";
    align?: "start" | "center";
    children?: ReactNode;
};

export function SectionHeading({ index, eyebrow, title, description, tone = "light", align = "start", children }: SectionHeadingProps) {
    const dark = tone === "dark";
    return (
        <div className={cn("flex flex-col gap-6", align === "center" ? "items-center text-center" : "md:flex-row md:items-end md:justify-between")}>
            <div className={cn(align === "center" && "mx-auto")}>
                <div className={cn("flex items-center gap-3", align === "center" && "justify-center")}>
                    <span className="gradient-bg-gold flex h-7 min-w-9 items-center justify-center rounded-full px-2 font-mono text-xs font-semibold text-ink">
                        {index}
                    </span>
                    <span className="h-px w-10 bg-gold/60" />
                    <span className="font-mono text-xs tracking-widest text-gold">{eyebrow}</span>
                </div>
                <h2 className={cn("mt-5 text-4xl font-bold leading-[1.2] md:text-5xl", dark ? "text-pearl" : "text-primary")}>{title}</h2>
                {description && (
                    <p className={cn("mt-5 max-w-2xl text-lg leading-8", align === "center" && "mx-auto", dark ? "text-pearl/65" : "text-muted-foreground")}>
                        {description}
                    </p>
                )}
            </div>
            {children}
        </div>
    );
}
