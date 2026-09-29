import { useCallback, useEffect, useState } from "react";
import useEmblaCarousel from "embla-carousel-react";
import Autoplay from "embla-carousel-autoplay";
import { ArrowLeft, ChevronDown, ChevronLeft, ChevronRight } from "lucide-react";

import heroPort from "@/assets/hero-port.jpg";
import heroSkyline from "@/assets/hero-skyline.jpg";
import heroGlobe from "@/assets/hero-globe.jpg";
import { Button } from "@/components/ui/button";

type Slide = {
    image: string;
    imagePosition: string;
    alt: string;
    eyebrow: string;
    heading: [string, string];
    paragraph: string;
};

const slides: Slide[] = [
    {
        image: heroPort,
        imagePosition: "center",
        alt: "ميناء تجاري وسفينة شحن عند الغروب",
        eyebrow: "ريادة التجارة العالمية",
        heading: ["نربط العالم", "بأمانة سعودية"],
        paragraph:
            "حلول متكاملة لسلاسل الإمداد، من المواد الخام البلاستيكية إلى أجود أنواع الأغذية العالمية، بمعايير تتجاوز التوقعات.",
    },
    {
        image: heroSkyline,
        imagePosition: "center 22%",
        alt: "برج المملكة وأفق الرياض عند الليل",
        eyebrow: "رؤية سعودية عالمية",
        heading: ["رؤية سعودية", "تتجاوز الحدود"],
        paragraph:
            "من قلب المملكة إلى أسواق مصر والإمارات، نبني منظومة تجارية ورقمية متكاملة تواكب رؤية 2030.",
    },
    {
        image: heroGlobe,
        imagePosition: "center",
        alt: "شبكة اتصال رقمية عالمية مضيئة",
        eyebrow: "شبكة مترابطة",
        heading: ["شبكة عالمية", "من الشركاء والموارد"],
        paragraph:
            "أكثر من 45 سوقاً دولياً ومنظومة رقمية مدعومة بالذكاء الاصطناعي تربطك بعملائك أينما كانوا.",
    },
];

export function HeroSlider() {
    const [emblaRef, emblaApi] = useEmblaCarousel({ loop: true, direction: "rtl" }, [
        Autoplay({ delay: 6500, stopOnInteraction: false, stopOnMouseEnter: true }),
    ]);
    const [selected, setSelected] = useState(0);

    const onSelect = useCallback(() => {
        if (emblaApi) setSelected(emblaApi.selectedScrollSnap());
    }, [emblaApi]);

    useEffect(() => {
        if (!emblaApi) return;
        onSelect();
        emblaApi.on("select", onSelect);
        emblaApi.on("reInit", onSelect);
    }, [emblaApi, onSelect]);

    return (
        <header id="top" className="relative min-h-[92svh] overflow-hidden">
            <div className="absolute inset-0 overflow-hidden" ref={emblaRef}>
                <div className="flex h-full">
                    {slides.map((slide, index) => (
                        <div key={slide.alt} className="relative min-w-0 flex-[0_0_100%]">
                            <img
                                src={slide.image}
                                width={1920}
                                height={1088}
                                alt={slide.alt}
                                loading={index === 0 ? "eager" : "lazy"}
                                style={{ objectPosition: slide.imagePosition }}
                                className="hero-drift absolute inset-0 size-full object-cover"
                            />
                        </div>
                    ))}
                </div>
            </div>

            <div className="pointer-events-none absolute inset-0 bg-linear-to-l from-ink/90 via-ink/40 to-ink/10" />
            <div className="pointer-events-none absolute inset-x-0 bottom-0 h-40 bg-linear-to-t from-pearl to-transparent" />

            <div className="relative z-10 flex min-h-[92svh] items-center">
                <div className="mx-auto grid w-full max-w-7xl px-5 pb-48 pt-32 md:px-8 md:pb-52">
                    {slides.map((slide, index) => (
                        <div
                            key={slide.alt}
                            className={`col-start-1 row-start-1 max-w-3xl transition-opacity duration-700 ${selected === index ? "reveal-up opacity-100" : "pointer-events-none opacity-0"
                                }`}
                            aria-hidden={selected !== index}
                        >
                            <div className="mb-6 flex items-center gap-4">
                                <span className="h-px w-12 bg-gold" />
                                <span className="font-mono text-xs text-gold">{slide.eyebrow}</span>
                            </div>
                            <h1 className="text-5xl font-bold leading-[1.15] text-pearl md:text-7xl xl:text-8xl">
                                {slide.heading[0]}
                                <br />
                                <span className="text-gold">{slide.heading[1]}</span>
                            </h1>
                            <p className="mt-7 max-w-2xl text-lg leading-8 text-pearl/80 md:text-xl">{slide.paragraph}</p>
                            <div className="mt-9 flex flex-wrap gap-3">
                                <Button variant="gold" size="lg" asChild>
                                    <a href="#sectors">
                                        استكشف القطاعات <ArrowLeft size={18} />
                                    </a>
                                </Button>
                                <Button variant="glass" size="lg" asChild>
                                    <a href="#about">الملف المؤسسي</a>
                                </Button>
                            </div>
                        </div>
                    ))}
                </div>
            </div>

            <div className="absolute inset-x-0 bottom-32 z-20 flex items-center justify-center gap-2">
                {slides.map((slide, index) => (
                    <button
                        key={slide.alt}
                        aria-label={`الشريحة ${index + 1}`}
                        onClick={() => emblaApi?.scrollTo(index)}
                        className={`h-1.5 rounded-full transition-all ${selected === index ? "w-8 bg-gold" : "w-1.5 bg-pearl/40 hover:bg-pearl/70"
                            }`}
                    />
                ))}
            </div>

            <button
                aria-label="الشريحة التالية"
                onClick={() => emblaApi?.scrollNext()}
                className="absolute inset-y-0 right-2 z-20 hidden w-12 items-center justify-center text-pearl/70 transition-colors hover:text-gold md:flex"
            >
                <ChevronRight size={28} />
            </button>
            <button
                aria-label="الشريحة السابقة"
                onClick={() => emblaApi?.scrollPrev()}
                className="absolute inset-y-0 left-2 z-20 hidden w-12 items-center justify-center text-pearl/70 transition-colors hover:text-gold md:flex"
            >
                <ChevronLeft size={28} />
            </button>


            <a href="#sectors"
                aria-label="انتقل إلى القطاعات"
                className="absolute bottom-20 left-1/2 z-20 -translate-x-1/2 text-pearl"
            >
                <ChevronDown className="animate-bounce" />
            </a>
        </header >
    );
}