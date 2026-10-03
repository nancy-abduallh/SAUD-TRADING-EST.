/**
 * Client logos + data — split out from site-data.ts so these 11 logo imports
 * are NOT in the main bundle.  They load on demand when the ClientsMarquee
 * section enters the viewport (via React.lazy + LazySection).
 */

import type { Client } from "./site-data";

import moh from "@/assets/clients/ministry-of-health.png";
import gea from "@/assets/clients/gea.png";
import sab from "@/assets/clients/sab.png";
import riyadBank from "@/assets/clients/riyad-bank.png";
import halfM from "@/assets/clients/half-m.png";
import sign from "@/assets/clients/sign.png";
import ksu from "@/assets/clients/king-saud-university.png";
import aou from "@/assets/clients/aou.png";
import alibaba from "@/assets/clients/alibaba.png";
import naqi from "@/assets/clients/naqi.png";
import kingdomSchools from "@/assets/clients/kingdom-schools.png";

export const clients: Client[] = [
    { name: "وزارة الصحة", logo: moh },
    { name: "الهيئة العامة للترفيه", logo: gea },
    { name: "البنك الأول SAB", logo: sab },
    { name: "بنك الرياض", logo: riyadBank },
    { name: "1/2M", logo: halfM },
    { name: "Sign", logo: sign },
    { name: "جامعة الملك سعود", logo: ksu },
    { name: "الجامعة العربية المفتوحة", logo: aou },
    { name: "Alibaba.com", logo: alibaba },
    { name: "نقي NAQI", logo: naqi },
    { name: "مدارس المملكة", logo: kingdomSchools },
];
