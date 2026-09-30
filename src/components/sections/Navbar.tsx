import { useEffect, useRef, useState } from "react";
import { ArrowLeft, ChevronLeft, Menu, X } from "lucide-react";

import logoMark from "@/assets/logo-mark.png";
import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";

const LINKS = [
    { href: "#sectors", label: "القطاعات" },
    { href: "#catalogue", label: "المنتجات" },
    { href: "#vision", label: "رؤيتنا" },
    { href: "#clients", label: "عملاؤنا" },
    { href: "#about", label: "عن الشركة" },
];

export function Navbar({ menuOpen, setMenuOpen }: { menuOpen: boolean; setMenuOpen: (open: boolean) => void }) {
    const [scrolled, setScrolled] = useState(false);
    const bar = useRef<HTMLSpanElement>(null);

    useEffect(() => {
        const onScroll = () => {
            const max = document.documentElement.scrollHeight - window.innerHeight;
            setScrolled(window.scrollY > 24);
            if (bar.current) bar.current.style.transform = `scaleX(${max > 0 ? window.scrollY / max : 0})`;
        };
        onScroll();
        window.addEventListener("scroll", onScroll, { passive: true });
        return () => window.removeEventListener("scroll", onScroll);
    }, []);

    useEffect(() => {
        if (!menuOpen) return;
        const onKey = (e: KeyboardEvent) => e.key === "Escape" && setMenuOpen(false);
        const mq = window.matchMedia("(min-width: 768px)");
        const onChange = () => mq.matches && setMenuOpen(false);
        const prevOverflow = document.body.style.overflow;
        document.body.style.overflow = "hidden";
        window.addEventListener("keydown", onKey);
        mq.addEventListener("change", onChange);
        return () => {
            document.body.style.overflow = prevOverflow;
            window.removeEventListener("keydown", onKey);
            mq.removeEventListener("change", onChange);
        };
    }, [menuOpen, setMenuOpen]);

    const close = () => setMenuOpen(false);

    return (
        <>
            <nav
                className={cn(
                    "fixed inset-x-0 top-0 z-50 text-pearl transition-all duration-500",
                    scrolled
                        ? "bg-linear-to-b from-ink/95 to-navy/90 shadow-[0_18px_40px_-20px_oklch(0_0_0/0.7)] backdrop-blur-xl"
                        : "bg-linear-to-b from-ink/60 to-transparent backdrop-blur-[2px]",
                )}
            >
                <div className={cn("mx-auto flex max-w-7xl items-center justify-between px-4 transition-all duration-500 sm:px-5 md:px-8", scrolled ? "h-14 md:h-16" : "h-16 md:h-20")}>
                    <div className="flex items-center gap-12">
                        <a href="#top" className="flex items-center gap-2.5 md:gap-3">
                            <img src={logoMark} alt="شعار سعود التجارية" className="h-9 w-auto drop-shadow-sm md:h-10" />
                            <span className="text-xl font-bold text-pearl md:text-2xl">
                                سعود التجارية<span className="gradient-text-gold">.</span>
                            </span>
                        </a>
                        <div className="hidden items-center gap-8 text-sm md:flex">
                            {LINKS.map((link) => (
                                <a
                                    key={link.href}
                                    href={link.href}
                                    className="relative py-2 text-pearl/85 transition-colors hover:text-gold-soft after:absolute after:inset-x-0 after:-bottom-0.5 after:h-px after:origin-center after:scale-x-0 after:bg-gold after:transition-transform after:duration-300 hover:after:scale-x-100"
                                >
                                    {link.label}
                                </a>
                            ))}
                        </div>
                    </div>
                    <div className="hidden items-center gap-3 md:flex">
                        {/* <Button variant="glass">EN</Button> */}
                        <Button variant="gold" asChild>
                            <a href="#contact">تواصل معنا</a>
                        </Button>
                    </div>

                    <Button
                        variant="glass"
                        size="icon"
                        className="md:hidden"
                        aria-label="فتح القائمة"
                        aria-expanded={menuOpen}
                        aria-controls="mobile-menu"
                        onClick={() => setMenuOpen(true)}
                    >
                        <Menu size={20} />
                    </Button>
                </div>

                <span ref={bar} aria-hidden className="gradient-bg-gold absolute inset-x-0 bottom-0 h-0.5 origin-right scale-x-0" />
            </nav>


            <div
                aria-hidden
                onClick={close}
                className={cn(
                    "fixed inset-0 z-[60] bg-ink/60 backdrop-blur-sm transition-opacity duration-300 md:hidden",
                    menuOpen ? "opacity-100" : "pointer-events-none opacity-0",
                )}
            />

            <aside
                id="mobile-menu"
                role="dialog"
                aria-modal="true"
                aria-label="القائمة الرئيسية"
                inert={!menuOpen}
                className={cn(
                    "fixed inset-y-0 right-0 z-[70] flex w-[82%] max-w-xs flex-col border-l border-gold/25 bg-linear-to-b from-ink to-navy text-pearl shadow-[-30px_0_60px_-20px_oklch(0_0_0/0.8)] transition-transform duration-300 ease-out md:hidden",
                    menuOpen ? "translate-x-0" : "translate-x-full",
                )}
            >
                <span aria-hidden className="absolute inset-x-0 top-0 h-px bg-linear-to-r from-transparent via-gold to-transparent" />

                <div className="flex h-16 shrink-0 items-center justify-between border-b border-pearl/10 px-4">
                    <a href="#top" onClick={close} className="flex items-center gap-2.5">
                        <img src={logoMark} alt="" className="h-9 w-auto" />
                        <span className="text-lg font-bold">
                            سعود التجارية<span className="gradient-text-gold">.</span>
                        </span>
                    </a>
                    <Button variant="glass" size="icon" aria-label="إغلاق القائمة" onClick={close}>
                        <X size={20} />
                    </Button>
                </div>

                <ul className="flex-1 divide-y divide-pearl/10 overflow-y-auto px-4 py-2">
                    {LINKS.map((link) => (
                        <li key={link.href}>
                            <a
                                href={link.href}
                                onClick={close}
                                className="group flex items-center justify-between py-4 text-[15px] font-medium text-pearl/90 transition-colors active:text-gold-soft"
                            >
                                {link.label}
                                <ChevronLeft size={16} className="text-pearl/40 transition-all group-hover:-translate-x-1 group-hover:text-gold group-active:text-gold" />
                            </a>
                        </li>
                    ))}
                </ul>

                <div className="shrink-0 border-t border-pearl/10 p-4">
                    <a href="#contact" onClick={close} className="gradient-bg-gold flex h-12 items-center justify-center gap-2 rounded-xl font-semibold text-ink shadow-lg">
                        تواصل معنا <ArrowLeft size={16} />
                    </a>
                </div>
            </aside>
        </>
    );
}