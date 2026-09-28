import { ArrowLeft, ArrowUp, Mail, MapPin, Phone } from "lucide-react";

import heroPort from "@/assets/hero-port.jpg";
import logoMark from "@/assets/logo-mark.png";
import { MovingBg } from "@/components/effects/MovingBg";
import { Reveal } from "@/components/effects/Reveal";
import { Button } from "@/components/ui/button";
import { countries, sectors, type SectorKey } from "@/lib/site-data";

// Fill these in to show them in the footer + CTA. Empty values are hidden.
const CONTACT = { email: "", phone: "" };

const QUICK_LINKS = [
    { href: "#sectors", label: "القطاعات" },
    { href: "#catalogue", label: "المنتجات" },
    { href: "#vision", label: "رؤيتنا" },
    { href: "#clients", label: "عملاؤنا" },
    { href: "#about", label: "عن الشركة" },
];

export function Footer() {
    const ctaHref = CONTACT.email ? `mailto:${CONTACT.email}` : "#contact";

    return (
        <footer id="contact" className="relative isolate overflow-hidden bg-ink pt-24 text-pearl">
            <MovingBg src={heroPort} tone="dark" imageOpacity={0.45} />
            <div className="relative mx-auto max-w-7xl px-5 md:px-8">
                <Reveal>
                    <div className="gradient-bg-navy relative overflow-hidden rounded-[2rem] border border-gold/35 p-10 shadow-[0_50px_90px_-40px_oklch(0_0_0)] md:p-14">
                        <span className="orb orb-a" data-tone="dark" />
                        <div className="relative flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">
                            <div className="max-w-2xl">
                                <span className="font-mono text-xs tracking-widest text-gold-soft">LET'S WORK TOGETHER</span>
                                <h2 className="mt-4 text-3xl font-bold leading-snug md:text-5xl">
                                    لنبدأ <span className="gradient-text-shine">شراكة تجارية</span> تدوم
                                </h2>
                                <p className="mt-4 leading-7 text-pearl/65">فريقنا جاهز للرد على استفساراتكم وتجهيز عروض التوريد المناسبة لاحتياجاتكم.</p>
                            </div>
                            <Button variant="gold" size="lg" asChild>
                                <a href={ctaHref}>
                                    تواصل معنا <ArrowLeft size={18} />
                                </a>
                            </Button>
                        </div>
                    </div>
                </Reveal>

                <div className="mt-20 grid gap-12 md:grid-cols-2 lg:grid-cols-[1.4fr_0.7fr_1fr_1fr]">
                    <div>
                        <div className="flex items-center gap-3">
                            <img src={logoMark} alt="شعار سعود التجارية" className="h-10 w-auto" />
                            <span className="text-3xl font-bold">
                                سعود<span className="gradient-text-gold">.</span>
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

                    <div>
                        <h3 className="gradient-text-gold font-semibold">روابط سريعة</h3>
                        <ul className="mt-5 grid gap-3 text-sm text-pearl/65">
                            {QUICK_LINKS.map((l) => (
                                <li key={l.href}>
                                    <a href={l.href} className="transition-colors hover:text-gold-soft">
                                        {l.label}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>

                    <div>
                        <h3 className="gradient-text-gold font-semibold">قطاعاتنا</h3>
                        <ul className="mt-5 grid gap-3 text-sm text-pearl/65">
                            {(Object.keys(sectors) as SectorKey[]).map((key) => (
                                <li key={key}>
                                    <a href="#catalogue" className="transition-colors hover:text-gold-soft">
                                        {sectors[key].title}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>

                    <div>
                        <h3 className="gradient-text-gold font-semibold">تواصل</h3>
                        <ul className="mt-5 grid gap-4 text-sm text-pearl/65">
                            <li className="flex items-center gap-3">
                                <MapPin size={16} className="text-gold" />
                                الرياض، المملكة العربية السعودية
                            </li>
                            {CONTACT.email && (
                                <li className="flex items-center gap-3">
                                    <Mail size={16} className="text-gold" />
                                    <a href={`mailto:${CONTACT.email}`} className="font-mono hover:text-gold-soft">
                                        {CONTACT.email}
                                    </a>
                                </li>
                            )}
                            {CONTACT.phone && (
                                <li className="flex items-center gap-3">
                                    <Phone size={16} className="text-gold" />
                                    <a dir="ltr" href={`tel:${CONTACT.phone}`} className="font-mono hover:text-gold-soft">
                                        {CONTACT.phone}
                                    </a>
                                </li>
                            )}
                        </ul>
                    </div>
                </div>

                <div className="mt-16 flex flex-col items-center justify-between gap-4 border-t border-pearl/10 py-8 md:flex-row">
                    <p className="font-mono text-xs text-pearl/45">© 2026 SAUD TRADING EST. — Your Success, Our Commitment</p>
                    <a
                        href="#top"
                        aria-label="العودة للأعلى"
                        className="gradient-bg-gold flex size-11 items-center justify-center rounded-full text-ink shadow-lg transition-transform hover:-translate-y-1"
                    >
                        <ArrowUp size={18} />
                    </a>
                </div>
            </div>
        </footer>
    );
}
