import { Menu, X } from "lucide-react";

import logoMark from "@/assets/logo-mark.png";
import { Button } from "@/components/ui/button";

const LINKS = [
    { href: "#sectors", label: "القطاعات" },
    { href: "#catalogue", label: "المنتجات" },
    { href: "#vision", label: "رؤيتنا" },
    { href: "#clients", label: "عملاؤنا" },
    { href: "#about", label: "عن الشركة" },
];

export function Navbar({ menuOpen, setMenuOpen }: { menuOpen: boolean; setMenuOpen: (open: boolean) => void }) {
    return (
        <nav className="fixed inset-x-0 top-0 z-50 border-b border-pearl/15 bg-ink/25 text-pearl backdrop-blur-md">
            <div className="mx-auto flex h-20 max-w-7xl items-center justify-between px-5 md:px-8">
                <div className="flex items-center gap-12">
                    <a href="#top" className="flex items-center gap-3">
                        <img src={logoMark} alt="شعار سعود التجارية" className="h-10 w-auto drop-shadow-sm" />
                        <span className="text-2xl font-bold text-pearl">
                            سعود<span className="text-gold">.</span>
                        </span>
                    </a>
                    <div className="hidden items-center gap-8 text-sm md:flex">
                        {LINKS.map((link) => (
                            <a key={link.href} href={link.href} className="transition-colors hover:text-gold">
                                {link.label}
                            </a>
                        ))}
                    </div>
                </div>
                <div className="hidden items-center gap-3 md:flex">
                    <Button variant="glass">EN</Button>
                    <Button asChild>
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
            {menuOpen && (
                <div className="grid gap-4 border-t border-pearl/15 bg-ink px-5 py-6 text-sm md:hidden">
                    {LINKS.map((link) => (
                        <a key={link.href} href={link.href} onClick={() => setMenuOpen(false)}>
                            {link.label}
                        </a>
                    ))}
                    <a href="#contact" onClick={() => setMenuOpen(false)} className="font-semibold text-gold">
                        تواصل معنا
                    </a>
                </div>
            )}
        </nav>
    );
}