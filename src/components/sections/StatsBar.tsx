import { stats } from "@/lib/site-data";

export function StatsBar() {
    return (
        <section id="supply" className="border-y border-primary/10 bg-sand">
            <div className="mx-auto grid max-w-7xl grid-cols-2 gap-8 px-5 py-10 md:grid-cols-4 md:px-8">
                {stats.map(([value, label]) => (
                    <div key={label}>
                        <strong className="block font-mono text-3xl text-primary">{value}</strong>
                        <span className="mt-1 block text-sm text-primary/65">{label}</span>
                    </div>
                ))}
            </div>
        </section>
    );
}