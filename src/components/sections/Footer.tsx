import logoMark from "@/assets/logo-mark.png";
import { countries } from "@/lib/site-data";

export function Footer() {
    return (
        <footer id="contact" className="bg-pearl py-12">
            <div className="mx-auto flex max-w-7xl flex-col justify-between gap-8 px-5 md:flex-row md:items-end md:px-8">
                <div>
                    <div className="flex items-center gap-3">
                        <img src={logoMark} alt="شعار سعود التجارية" className="h-9 w-auto" />
                        <span className="text-3xl font-bold text-primary">
                            سعود<span className="text-gold">.</span>
                        </span>
                    </div>
                    <p className="mt-3 max-w-sm text-sm leading-6 text-muted-foreground">
                        شركة سعودية متخصصة في تجارة المواد الغذائية والبلاستيكية، وتقديم حلول رقمية متكاملة مدعومة بالذكاء
                        الاصطناعي.
                    </p>
                    <div className="mt-4 flex flex-wrap gap-2">
                        {countries.map((country) => (
                            <span key={country.name} className="text-xs font-medium text-muted-foreground">
                                {country.name}
                                {country !== countries[countries.length - 1] && <span className="mx-2 text-border">·</span>}
                            </span>
                        ))}
                    </div>
                </div>
                <div className="text-sm text-muted-foreground">
                    <p>الرياض، المملكة العربية السعودية</p>
                    <p className="mt-2 font-mono text-xs">© 2026 SAUD TRADING EST. — Your Success, Our Commitment</p>
                </div>
            </div>
        </footer>
    );
}