import sharp from "sharp";
import { readdirSync, mkdirSync, copyFileSync, renameSync, existsSync, statSync } from "node:fs";
import { join, extname, dirname } from "node:path";

const jobs = [
    { dir: "src/assets/products", exts: [".jfif", ".jpg", ".jpeg"], width: 900 },
    { dir: "src/assets", exts: [".jfif", ".jpg", ".jpeg"], width: 1600 },
    { dir: "src/assets", exts: [".png"], only: ["egypt.png", "saudi.png", "dubai.png"], width: 1000 },
];

const kb = (n) => Math.round(n / 1024) + " KB";
let before = 0;
let after = 0;

for (const job of jobs) {
    for (const entry of readdirSync(job.dir, { withFileTypes: true })) {
        if (!entry.isFile()) continue;
        const ext = extname(entry.name).toLowerCase();
        if (!job.exts.includes(ext)) continue;
        if (job.only && !job.only.includes(entry.name)) continue;

        const file = join(job.dir, entry.name);
        const backup = join("originals-backup", file);
        mkdirSync(dirname(backup), { recursive: true });
        if (!existsSync(backup)) copyFileSync(file, backup); // keep the untouched original

        // Always read from the backup so running the script twice never re-compresses twice.
        const tmp = file + ".tmp";
        let img = sharp(backup).rotate().resize({ width: job.width, withoutEnlargement: true });
        img =
            ext === ".png"
                ? img.png({ palette: true, quality: 80, compressionLevel: 9 })
                : img.jpeg({ quality: 76, mozjpeg: true });
        await img.toFile(tmp);
        renameSync(tmp, file); // same file name, so imports and DB paths keep working

        const b = statSync(backup).size;
        const a = statSync(file).size;
        before += b;
        after += a;
        console.log(entry.name.padEnd(45), kb(b).padStart(9), "->", kb(a).padStart(8));
    }
}
console.log("\nTotal:", kb(before), "->", kb(after));