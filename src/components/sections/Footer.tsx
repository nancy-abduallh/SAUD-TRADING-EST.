import { useId, useState, type ReactNode } from "react";
import { ArrowLeft, ArrowUp, ChevronDown, Mail, MapPin, Phone } from "lucide-react";

import heroPort from "@/assets/hero-port.jpg";
import logoMark from "@/assets/logo-mark.png";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { Button } from "@/components/ui/button";
import { countries, sectors, type SectorKey } from "@/lib/site-data";
import { cn } from "@/lib/utils";

const CONTACT = { email: "", phone: "" };

const QUICK_LINKS = [
    { href: "#sectors", label: "القطاعات" },
    { href: "#catalogue", label: "المنتجات" },
    { href: "#vision", label: "رؤيتنا" },
    { href: "#clients", label: "عملاؤنا" },
    { href: "#about", label: "عن الشركة" },
];


function FooterColumn({ title, children }: { title: string; children: ReactNode }) {
    const [open, setOpen] = useState(false);
    const panelId = useId();

    return (
        <div className="border-b border-pearl/10 md:border-0">
            <h3 className="font-semibold">
                <button
                    type="button"
                    aria-expanded={open}
                    aria-controls={panelId}
                    onClick={() => setOpen((o) => !o)}
                    className="flex w-full items-center justify-between py-4 text-start md:pointer-events-none md:cursor-default md:py-0"
                >
                    <span className="gradient-text-gold">{title}</span>
                    <ChevronDown
                        size={18}
                        aria-hidden
                        className={cn("text-gold transition-transform duration-300 md:hidden", open && "rotate-180")}
                    />
                </button>
            </h3>

            <div
                id={panelId}
                className={cn(
                    "grid transition-[grid-template-rows] duration-300 md:grid-rows-[1fr]",
                    open ? "grid-rows-[1fr]" : "grid-rows-[0fr]",
                )}
            >
                {/* `invisible` keeps hidden links out of the tab order; the transition delays it until the close animation ends */}
                <div className={cn("overflow-hidden transition-[visibility] duration-300", !open && "invisible md:visible")}>
                    <div className="pb-5 md:pb-0 md:pt-5">{children}</div>
                </div>
            </div>
        </div>
    );
}

export function Footer() {
    const ctaHref = CONTACT.email ? `mailto:${CONTACT.email}` : "#contact";

    return (
        <footer id="contact" className="relative isolate overflow-hidden bg-ink pt-16 text-pearl md:pt-24">
            <MovingBg src={heroPort} tone="dark" imageOpacity={0.45} />
            <div className="relative mx-auto max-w-7xl px-5 md:px-8">
                <Reveal>
                    <div className="gradient-bg-navy relative overflow-hidden rounded-3xl border border-gold/35 p-7 shadow-[0_50px_90px_-40px_oklch(0_0_0)] sm:p-10 md:rounded-[2rem] md:p-14">
                        <span className="orb orb-a" data-tone="dark" />
                        <div className="relative flex flex-col items-start justify-between gap-7 md:flex-row md:items-center md:gap-8">
                            <div className="max-w-2xl">
                                <span className="font-mono text-xs tracking-widest text-gold-soft">LET'S WORK TOGETHER</span>
                                <h2 className="mt-4 text-2xl font-bold leading-snug sm:text-3xl md:text-5xl">
                                    لنبدأ <span className="gradient-text-shine">شراكة تجارية</span> تدوم
                                </h2>
                                <p className="mt-4 text-sm leading-7 text-pearl/65 sm:text-base">
                                    فريقنا جاهز للرد على استفساراتكم وتجهيز عروض التوريد المناسبة لاحتياجاتكم.
                                </p>
                            </div>
                            <Button variant="gold" size="lg" className="w-full sm:w-auto" asChild>
                                <a href={ctaHref}>
                                    تواصل معنا <ArrowLeft size={18} />
                                </a>
                            </Button>
                        </div>
                    </div>
                </Reveal>

                <div className="mt-14 grid gap-x-12 md:mt-20 md:grid-cols-2 md:gap-y-12 lg:grid-cols-[1.4fr_0.7fr_1fr_1fr]">
                    {/* Brand block — always visible */}
                    <div className="pb-8 md:pb-0">
                        <div className="flex items-center gap-3">
                            <img src={logoMark} alt="شعار سعود التجارية" className="h-10 w-auto" />
                            <span className="text-2xl font-bold md:text-3xl">
                                سعود التجارية<span className="gradient-text-gold">.</span>
                            </span>
                        </div>
                        <p className="mt-4 max-w-sm text-sm leading-7 text-pearl/60">
                            شركة سعودية متخصصة في تجارة المواد الغذائية والبلاستيكية، وتقديم حلول رقمية متكاملة مدعومة بالذكاء الاصطناعي.
                        </p>
                        <div className="mt-5 flex flex-wrap gap-2">
                            {countries.map((c) => (
                                <span key={c.name} className="rounded-full border border-pearl/15 px-3 py-1 text-xs text-pearl/70">
                                    {c.name}
                                </span>
                            ))}
                        </div>
                    </div>

                    {/* On mobile the first accordion gets a top border so the three rows read as one list */}
                    <div className="border-t border-pearl/10 md:contents">
                        <FooterColumn title="روابط سريعة">
                            <ul className="grid gap-3 text-sm text-pearl/65">
                                {QUICK_LINKS.map((l) => (
                                    <li key={l.href}>
                                        <a href={l.href} className="transition-colors hover:text-gold-soft">
                                            {l.label}
                                        </a>
                                    </li>
                                ))}
                            </ul>
                        </FooterColumn>
                    </div>

                    <FooterColumn title="قطاعاتنا">
                        <ul className="grid gap-3 text-sm text-pearl/65">
                            {(Object.keys(sectors) as SectorKey[]).map((key) => (
                                <li key={key}>
                                    <a href="#catalogue" className="transition-colors hover:text-gold-soft">
                                        {sectors[key].title}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </FooterColumn>

                    <FooterColumn title="تواصل">
                        <ul className="grid gap-4 text-sm text-pearl/65">
                            <li className="flex items-center gap-3">
                                <MapPin size={16} className="shrink-0 text-gold" />
                                الرياض، المملكة العربية السعودية
                            </li>
                            {CONTACT.email && (
                                <li className="flex items-center gap-3">
                                    <Mail size={16} className="shrink-0 text-gold" />
                                    <a href={`mailto:${CONTACT.email}`} className="font-mono hover:text-gold-soft">
                                        {CONTACT.email}
                                    </a>
                                </li>
                            )}
                            {CONTACT.phone && (
                                <li className="flex items-center gap-3">
                                    <Phone size={16} className="shrink-0 text-gold" />
                                    <a dir="ltr" href={`tel:${CONTACT.phone}`} className="font-mono hover:text-gold-soft">
                                        {CONTACT.phone}
                                    </a>
                                </li>
                            )}
                        </ul>
                    </FooterColumn>
                </div>

                <div className="mt-10 flex items-center justify-between gap-4 border-t border-pearl/10 py-6 md:mt-16 md:py-8">
                    {/* dir="ltr" keeps the English line in the right word order inside the RTL page */}
                    <p dir="ltr" className="text-right font-mono text-xs leading-relaxed text-pearl/45">
                        © 2026 SAUD TRADING EST. — Your Success, Our Commitment
                    </p>
                    <a
                        href="#top"
                        aria-label="العودة للأعلى"
                        className="gradient-bg-gold flex size-11 shrink-0 items-center justify-center rounded-full text-ink shadow-lg transition-transform hover:-translate-y-1"
                    >
                        <ArrowUp size={18} />
                    </a>
                </div>
            </div>
        </footer>
    );
}