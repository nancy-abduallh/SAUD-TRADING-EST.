import { useCallback, useEffect, useState } from "react";
import * as DialogPrimitive from "@radix-ui/react-dialog";
import { ChevronLeft, ChevronRight, X, ZoomIn, ZoomOut } from "lucide-react";

import { cn } from "@/lib/utils";

export type LightboxItem = {
    name: string;
    image: string;
    blurb?: string;
    sku?: string;
};

type ImageLightboxProps = {
    items: LightboxItem[];
    /** Index of the open item, or null when closed. */
    index: number | null;
    onIndexChange: (index: number) => void;
    onClose: () => void;
};

/**
 * Full-screen popup that shows a product image at a much larger size.
 * - Click the image (or the zoom button) to toggle 2x zoom and scroll around
 * - Arrow buttons / keyboard arrows move between products
 * - Esc, the close button, or a click on the dark backdrop closes it
 */
export function ImageLightbox({ items, index, onIndexChange, onClose }: ImageLightboxProps) {
    const item = index !== null ? items[index] : undefined;
    const open = item !== undefined;
    const count = items.length;
    const [zoomed, setZoomed] = useState(false);

    // Always start a new image un-zoomed.
    useEffect(() => {
        setZoomed(false);
    }, [index]);

    const go = useCallback(
        (step: 1 | -1) => {
            if (index === null || count < 2) return;
            onIndexChange((index + step + count) % count);
        },
        [index, count, onIndexChange],
    );

    // Keyboard navigation. The page is RTL, so the left arrow means "next".
    useEffect(() => {
        if (!open) return;
        const onKey = (e: KeyboardEvent) => {
            if (e.key === "ArrowLeft") go(1);
            if (e.key === "ArrowRight") go(-1);
        };
        window.addEventListener("keydown", onKey);
        return () => window.removeEventListener("keydown", onKey);
    }, [open, go]);

    return (
        <DialogPrimitive.Root open={open} onOpenChange={(next) => !next && onClose()}>
            <DialogPrimitive.Portal>
                <DialogPrimitive.Overlay className="fixed inset-0 z-[100] bg-ink/90 backdrop-blur-md data-[state=closed]:animate-out data-[state=open]:animate-in data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0" />

                <DialogPrimitive.Content
                    dir="rtl"
                    className="fixed inset-0 z-[100] flex flex-col p-3 outline-none data-[state=closed]:animate-out data-[state=open]:animate-in data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95 sm:p-6"
                    // Clicking empty space around the picture closes the popup.
                    onClick={(e) => {
                        if (e.target === e.currentTarget) onClose();
                    }}
                >
                    {item && (
                        <>
                            {/* Top bar: title + controls */}
                            <div className="relative z-10 flex shrink-0 items-start justify-between gap-4 text-pearl">
                                <div className="min-w-0">
                                    {item.sku && <span className="font-mono text-xs text-gold">{item.sku}</span>}
                                    <DialogPrimitive.Title className="truncate text-lg font-semibold sm:text-2xl">
                                        {item.name}
                                    </DialogPrimitive.Title>
                                    <DialogPrimitive.Description className="sr-only">
                                        {item.blurb ?? item.name}
                                    </DialogPrimitive.Description>
                                </div>

                                <div className="flex shrink-0 items-center gap-2">
                                    {count > 1 && index !== null && (
                                        <span className="font-mono text-xs text-pearl/60">
                                            {index + 1} / {count}
                                        </span>
                                    )}
                                    <button
                                        type="button"
                                        onClick={() => setZoomed((z) => !z)}
                                        aria-label={zoomed ? "تصغير الصورة" : "تكبير الصورة"}
                                        className="flex size-10 items-center justify-center rounded-full border border-pearl/20 bg-pearl/10 text-pearl transition-colors hover:border-gold/60 hover:text-gold-soft"
                                    >
                                        {zoomed ? <ZoomOut size={18} /> : <ZoomIn size={18} />}
                                    </button>
                                    <DialogPrimitive.Close
                                        aria-label="إغلاق"
                                        className="flex size-10 items-center justify-center rounded-full border border-pearl/20 bg-pearl/10 text-pearl transition-colors hover:border-gold/60 hover:text-gold-soft"
                                    >
                                        <X size={18} />
                                    </DialogPrimitive.Close>
                                </div>
                            </div>

                            {/* Image stage */}
                            <div
                                className={cn(
                                    "relative mt-3 flex min-h-0 flex-1 rounded-2xl",
                                    zoomed ? "overflow-auto" : "overflow-hidden",
                                )}
                                onClick={(e) => {
                                    if (e.target === e.currentTarget) onClose();
                                }}
                            >
                                <img
                                    key={item.image}
                                    src={item.image}
                                    alt={item.name}
                                    onClick={() => setZoomed((z) => !z)}
                                    draggable={false}
                                    className={cn(
                                        "m-auto rounded-2xl object-contain shadow-[0_40px_90px_-30px_oklch(0_0_0/0.9)] transition-[max-width,max-height] duration-300 animate-in fade-in-0 zoom-in-95",
                                        zoomed
                                            ? "max-h-none max-w-none cursor-zoom-out w-[200%] sm:w-[160%]"
                                            : "max-h-full max-w-full cursor-zoom-in",
                                    )}
                                />
                            </div>

                            {/* Prev / next (RTL: "next" sits on the left) */}
                            {count > 1 && (
                                <>
                                    <button
                                        type="button"
                                        onClick={() => go(-1)}
                                        aria-label="المنتج السابق"
                                        className="absolute right-3 top-1/2 z-10 flex size-11 -translate-y-1/2 items-center justify-center rounded-full border border-pearl/20 bg-ink/60 text-pearl backdrop-blur transition-colors hover:border-gold/60 hover:text-gold-soft sm:right-6"
                                    >
                                        <ChevronRight size={22} />
                                    </button>
                                    <button
                                        type="button"
                                        onClick={() => go(1)}
                                        aria-label="المنتج التالي"
                                        className="absolute left-3 top-1/2 z-10 flex size-11 -translate-y-1/2 items-center justify-center rounded-full border border-pearl/20 bg-ink/60 text-pearl backdrop-blur transition-colors hover:border-gold/60 hover:text-gold-soft sm:left-6"
                                    >
                                        <ChevronLeft size={22} />
                                    </button>
                                </>
                            )}
                        </>
                    )}
                </DialogPrimitive.Content>
            </DialogPrimitive.Portal>
        </DialogPrimitive.Root>
    );
}