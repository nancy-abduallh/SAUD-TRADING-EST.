import { Suspense, useEffect, useRef, useState, type ReactNode } from "react";

type LazySectionProps = {
    children: ReactNode;
    /** Approximate section height to reserve space and prevent layout shifts. */
    minHeight?: string;
    /** IntersectionObserver rootMargin — how far ahead of the viewport to trigger loading. */
    rootMargin?: string;
    /** Forwarded to the placeholder so in-page anchors still work before the real section loads. */
    id?: string;
};

/**
 * Defers rendering of its children until the placeholder scrolls near the
 * viewport.  On the server (SSR) only the lightweight placeholder `<div>` is
 * emitted, keeping TTFB low and the HTML payload small.
 *
 * A `<Suspense>` boundary wraps the revealed children so `React.lazy`
 * code-split components work seamlessly inside.
 */
export function LazySection({
    children,
    minHeight = "400px",
    rootMargin = "300px 0px",
    id,
}: LazySectionProps) {
    const ref = useRef<HTMLDivElement>(null);
    const [visible, setVisible] = useState(false);

    useEffect(() => {
        const el = ref.current;
        if (!el) return;

        // Fallback: if IntersectionObserver is unavailable, show immediately
        if (typeof IntersectionObserver === "undefined") {
            setVisible(true);
            return;
        }

        const io = new IntersectionObserver(
            ([entry]) => {
                if (entry?.isIntersecting) {
                    setVisible(true);
                    io.disconnect();
                }
            },
            { rootMargin },
        );
        io.observe(el);
        return () => io.disconnect();
    }, [rootMargin]);

    if (visible) {
        return (
            <Suspense fallback={<div id={id} style={{ minHeight }} />}>
                {children}
            </Suspense>
        );
    }

    return <div ref={ref} id={id} style={{ minHeight }} />;
}
