import { Compass, Eye, Globe, Sparkles, Target, Telescope } from "lucide-react";

/** One icon per cube face — all about looking ahead / vision. */
const FACES = [
    { name: "front", Icon: Eye },
    { name: "back", Icon: Telescope },
    { name: "right", Icon: Target },
    { name: "left", Icon: Compass },
    { name: "top", Icon: Sparkles },
    { name: "bottom", Icon: Globe },
] as const;

/**
 * A slowly rotating glass cube with orbiting rings and a glowing core.
 * Uses the same .cube / .ring styles as the AI cube in DigitalEcosystem.
 */
export function VisionCube() {
    return (
        <div className="cube-scene anim-float" aria-hidden>
            <div className="ring" />
            <div className="ring ring-2" />
            <div className="cube">
                <span className="cube-core" />
                {FACES.map(({ name, Icon }) => (
                    <div key={name} className={`cube-face cube-${name}`}>
                        <Icon size={34} strokeWidth={1.25} />
                    </div>
                ))}
            </div>
        </div>
    );
}