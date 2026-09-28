import { useEffect, useRef, useState } from "react";
import { Menu, X } from "lucide-react";

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

    return (
        <nav
            className={cn(
                "fixed inset-x-0 top-0 z-50 text-pearl transition-all duration-500",
                scrolled
                    ? "bg-linear-to-b from-ink/95 to-navy/90 shadow-[0_18px_40px_-20px_oklch(0_0_0/0.7)] backdrop-blur-xl"
                    : "bg-linear-to-b from-ink/60 to-transparent backdrop-blur-[2px]",
            )}
        >
            <div className={cn("mx-auto flex max-w-7xl items-center justify-between px-5 transition-all duration-500 md:px-8", scrolled ? "h-16" : "h-20")}>
                <div className="flex items-center gap-12">
                    <a href="#top" className="flex items-center gap-3">
                        <img src={logoMark} alt="شعار سعود التجارية" className="h-10 w-auto drop-shadow-sm" />
                        <span className="text-2xl font-bold text-pearl">
                            سعود<span className="gradient-text-gold">.</span>
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
                    onClick={() => setMenuOpen(!menuOpen)}
                >
                    {menuOpen ? <X size={20} /> : <Menu size={20} />}
                </Button>
            </div>

            <div className={cn("grid transition-[grid-template-rows] duration-300 md:hidden", menuOpen ? "grid-rows-[1fr]" : "grid-rows-[0fr]")}>
                <div className="overflow-hidden">
                    <div className="grid gap-1 border-t border-pearl/10 bg-ink/95 px-5 py-4 text-sm">
                        {LINKS.map((link) => (
                            <a key={link.href} href={link.href} onClick={() => setMenuOpen(false)} className="rounded-lg px-3 py-3 hover:bg-pearl/10">
                                {link.label}
                            </a>
                        ))}
                        <a href="#contact" onClick={() => setMenuOpen(false)} className="gradient-bg-gold mt-2 rounded-lg px-3 py-3 text-center font-semibold text-ink">
                            تواصل معنا
                        </a>
                    </div>
                </div>
            </div>

            <span ref={bar} aria-hidden className="gradient-bg-gold absolute inset-x-0 bottom-0 h-0.5 origin-right scale-x-0" />
        </nav>
    );
}
