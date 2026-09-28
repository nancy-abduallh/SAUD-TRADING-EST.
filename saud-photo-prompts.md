# Saud Trading — photorealistic product image prompts

Style is matched to your reference (`food-sector.jpg`): warm golden sunlight, palm-leaf shadows, cream marble, brass, dark emerald ceramic, burlap.

**How to use**
1. Paste the **STYLE BLOCK** after every subject line below (or set it as a standing instruction in your image tool).
2. Generate in **4:3 landscape** (1600×1200 or larger). The catalogue cards are 4:3, so portrait images get cropped.
3. Save each result using the **filename** shown in the heading (e.g. `hdpe.png`), drop them all in one folder, then run `process_images.py` (bottom of this file) to crop, resize and convert to WebP.
4. Generate 3–4 variations per item and keep the best one. Check that no text or logos were invented on packaging.

---

## STYLE BLOCK — food sector (14 items)

> Professional commercial product photograph, warm natural golden-hour sunlight from the upper left, soft dappled palm-leaf shadows, cream marble surface with subtle veining, shallow depth of field, rich realistic textures, styled with a brass Arabic coffee pot and brass tray, dark emerald-green ceramic and a green linen cloth with gold trim, premium editorial food photography, 4:3 landscape, ultra-detailed, sharp focus on the product, no text, no logos, no watermark, no people.

## STYLE BLOCK — plastics sector (9 items)

> Ultra-realistic commercial industrial photograph, shot on a full-frame mirrorless camera with a 90mm macro lens at f/5.6, ISO 100, soft warm window light from the upper left with a large diffused fill, clean light-grey honed stone or brushed stainless-steel surface, deep navy out-of-focus background with a subtle warm gold highlight, true-to-life plastic with accurate pellet size (2–4 mm), matte-to-satin surfaces, natural translucency, tiny real-world imperfections, natural contact shadows, believable scale and physics, premium B2B catalogue quality, 4:3 landscape, no CGI or 3D-render look, no toy-like plastic sheen, no text, no logos, no watermark, no people.

## STYLE BLOCK — digital services (9 items)

> Ultra-realistic lifestyle photograph of a real modern workspace, shot on a full-frame mirrorless camera with a 35mm lens at f/2.8, ISO 200, warm natural window light from the left with soft fill, dark navy matte desk or leather desk mat with brass and gold accents, real-world details (natural glass reflections, slight fingerprints, subtle film-like grain), correct device proportions and a correct keyboard key layout, screens show a softly blurred interface made only of simple coloured blocks and shapes with NO readable text, natural depth of field, hands allowed but no faces, correct hand anatomy with five fingers, 4:3 landscape, no CGI or 3D-render look, no brand logos, no garbled text, no watermark.

**Negative prompt** (paste into tools that have a separate field; otherwise append "avoid: …"):
`cgi, 3d render, cartoon, illustration, plastic toy look, oversaturated, garbled text, gibberish letters, warped keyboard keys, extra fingers, distorted hands, faces, logos, watermark, lens flare overload, floating objects`

## Realism tips (plastics + digital)

- **Use your reference.** In tools that accept an image/style reference, upload `food-sector.jpg` and set the strength to about 30–50% so the light and colour grade carry over without copying the objects.
- **Generate big, then upscale.** Ask for the highest resolution available and upscale to 2400 px wide before running `process_images.py`. Fine detail (pellets, weave, glass edges) is what sells realism.
- **Screens are the weak point.** AI tools garble UI text. Two fixes: (1) keep the "blurred blocks, no readable text" wording in every digital prompt; (2) for the best result, generate the device with a **dark or solid navy screen**, then overlay a real screenshot of the Saud website with perspective in Photoshop, Photopea or Figma. Real UI on an AI-generated photo looks the most convincing.
- **Keep one object family per image.** Fewer props means fewer AI artefacts. If a result has warped keys, extra buttons or fused objects, regenerate rather than fix.
- **Check the physics.** Pellets should be small, uniform and cast contact shadows; film should crease and refract light; nothing should float.

---

# Food sector

### `basmati-rice` — أرز بسمتي ملكي
Long-grain white basmati rice pouring from a burlap sack into a dark green ceramic bowl, extremely long slender grains, a few grains scattered on the marble.

### `egyptian-rice` — أرز مصري قصير الحبة
Short, plump, pearly-white Egyptian round rice heaped in a shallow brass bowl beside a small burlap sack, grains visibly shorter and rounder than basmati.

### `wheat-flour` — قمح وطحين فاخر
Golden wheat grains in a wooden scoop next to a soft mound of fine white flour, dried wheat ears lying across the marble, a small burlap sack behind.

### `barley` — شعير علف وتصنيع
Heap of hulled barley grains spilling from a burlap sack onto the marble, a few barley ears with long awns in the corner, rustic and earthy.

### `olive-oil` — زيت زيتون بكر ممتاز
Dark green glass bottle of extra virgin olive oil with a plain blank cream label, a small brass dish of golden-green oil, fresh green and black olives with leaves, oil drizzle catching the sunlight.

### `sunflower-oil` — زيت دوار الشمس
Clear glass bottle of bright golden sunflower oil with a blank label, a fresh sunflower head and scattered sunflower seeds on the marble, glowing backlight through the oil.

### `corn-oil` — زيت الذرة
Clear glass bottle of golden corn oil with a blank label, a fresh corn cob with husk peeled back and loose kernels in a brass bowl.

### `soybean-oil` — زيت الصويا
Clear glass bottle of pale golden soybean oil with a blank label, a shallow bowl of dry soybeans and a few fresh green soybean pods.

### `palm-oil` — زيت النخيل
Bottle of rich orange-red palm oil with a blank label, a small bunch of ripe red-orange oil palm fruits on the marble, a palm frond shadow across the scene.

### `red-lentils` — عدس أحمر مصري
Split red lentils in a dark green ceramic bowl and spilling onto the marble, vivid orange-red colour, a burlap sack behind.

### `yellow-lentils` — عدس أصفر مقشر
Peeled yellow lentils heaped in a brass scoop and spilling from a small burlap sack, bright uniform yellow.

### `chickpeas` — حمص فاخر
Large beige premium chickpeas overflowing a dark green ceramic bowl and scattered on the marble, a burlap sack in the background.

### `white-beans` — فاصوليا بيضاء
Creamy white kidney beans in a wooden bowl with a burlap sack behind, a few beans scattered on the marble.

### `raw-peanuts` — فول سوداني نيء
Raw peanuts in the shell and a handful of shelled peanuts with red skins, in a woven basket on the marble, warm sunlight.

# Plastics sector

### `hdpe` — بوليثيلين عالي الكثافة (HDPE)
Three-quarter macro view of a heaped pile of natural-white HDPE granules, small cylindrical and lentil-shaped pellets 3–4 mm with a waxy matte finish and faint translucency, on light-grey honed stone. A stainless-steel scoop in the foreground with granules spilling over its lip, a blue 200-litre HDPE drum softly out of focus behind, natural contact shadows under every pellet.

### `ldpe` — بوليثيلين منخفض الكثافة (LDPE)
Milky-translucent LDPE granules, slightly softer and more glossy than HDPE with rounded edges, filling a stainless-steel scoop on a brushed-steel surface. Behind, out of focus, a roll of clear stretch film on a cardboard core with light refracting through the film edge.

### `pp` — بولي بروبلين (PP)
Crisp off-white polypropylene granules piled on stone, slightly glossier and more uniform than HDPE. Behind, softly blurred, a real injection-moulded white PP bucket with visible moulding ribs and a thin metal wire handle.

### `flexible-film` — أفلام تغليف مرنة
Warehouse scene: three jumbo rolls of clear flexible packaging film on cardboard cores standing on a wooden pallet, one roll partially unwound with the film catching window light and showing fine natural creases. Slightly hazy daylight from high industrial windows, concrete floor, 35mm lens, believable scale.

### `industrial-bags` — أكياس صناعية
Neat stack of blank white woven polypropylene sacks on a wooden pallet, sewn tops with visible stitching thread, one open sack slumped in front showing the woven texture and fibre detail. Warehouse daylight, no printing on the sacks.

### `food-containers` — عبوات غذائية
Stack of clean food-grade polypropylene tubs with snap-on lids in white and clear, slightly translucent walls with moulded rings, arranged in a tidy group on light stone with soft reflections. Blank, no labels, shallow depth of field on the front tub.

### `plastic-compounds` — مركبات بلاستيكية
Three separate piles of strand-cut compound pellets (about 3 mm cylinders): navy blue, amber-gold and white, side by side on light-grey stone. Macro depth of field with the centre pile in sharp focus, natural colour variation between individual pellets.

### `manufacturing-additives` — إضافات تصنيع
Laboratory bench scene: a real borosilicate Erlenmeyer flask and a beaker containing amber and blue liquids (graduation marks as plain lines without numbers), beside a glass jar of white masterbatch pellets and powder with a small metal scoop. Soft window light, realistic glass reflections and refraction.

### `recycled-materials` — مواد معاد تدويرها
Compressed bale of sorted mixed plastic tied with steel baling wire, visible compression and crushed colours, next to a heap of washed multicoloured recycled plastic flakes (irregular chips 5–10 mm). Daylight at a recycling facility, faint dust in the air, honest industrial look.

# Digital services

### `smart-websites` — مواقع ذكية تتطور مع الزوار
Three-quarter view of a slim silver aluminium laptop (no logo) open on a navy leather desk mat, screen showing a softly blurred modern website made of a large gold hero banner and three card blocks, shapes only. A black hardbound notebook and a brass pen to the right, a ceramic coffee cup out of focus behind, focus on the laptop's screen edge and keyboard.

### `responsive-design` — تصميم متجاوب وسرعة تنفيذ
Eye-level shot of a laptop, a tablet and a smartphone standing together on a navy desk, all three showing the same blurred navy-and-gold layout adapted to each screen size, devices angled slightly toward the camera, matching screen brightness, soft reflections on the desk surface.

### `seo` — تحسين محركات البحث SEO
A large monitor on a desk showing a softly blurred analytics dashboard with a rising line chart and bar chart (shapes only, no numbers or labels). In the foreground, in sharp focus, a real glass magnifying glass with a brass handle resting on the desk, monitor glow reflected in the lens.

### `social-media-24-7` — إدارة تواصل اجتماعي 24/7
Close-up of a hand holding a smartphone (natural nails, five fingers, no face) showing blurred chat bubbles and notification dots in gold and navy. A brass analogue desk clock in the background and warm evening window light with softly blurred city lights outside.

### `paid-ads` — إعلانات ممولة بدقة استهداف
Sharp macro of a steel-tip dart planted in the bullseye of a plain round sisal target board painted in concentric navy, cream and gold rings, no numbers on the board. Behind it, softly out of focus, a laptop on a desk showing a blurred rising growth chart, and a short stack of gold-coloured coins in the corner.

### `micro-targeting` — استهداف دقيق Micro-Targeting
Overhead photograph of a neat grid of small natural-wood peg-doll figures on a navy surface, one cluster in the centre painted gold, a real glass magnifier held just above that cluster. Even soft light, crisp wood grain, gentle shadows.

### `visual-identity` — تصميم هوية بصرية
Overhead flat-lay on textured cream paper: matte business cards with an embossed gold-foil geometric emblem (no letters), a letterhead sheet and envelope, a fan of colour swatches in navy, gold and cream, a fountain pen and a blank hardbound brand-guideline book. Soft directional light with realistic paper shadows and visible paper grain.

### `ai-logos` — شعارات ذكية بالذكاء الاصطناعي
A graphics tablet on a navy desk with a stylus resting on it, the screen showing a blurred vector editor where an abstract geometric diamond emblem in navy and gold is being drawn with anchor points and bezier handles, no text. A pencil sketch pad and colour swatch cards beside it.

### `video-vr` — فيديو وواقع افتراضي
A modern generic VR headset (no branding) resting on a navy desk beside a mirrorless camera with a lens attached and a small wooden clapperboard with a blank slate. Warm cinematic side light, shallow depth of field, focus on the headset lenses.

---

# `process_images.py`

Save this next to your folder of generated images, then run `python process_images.py ./generated ./out` (`pip install pillow`).

```python
import sys, pathlib
from PIL import Image, ImageOps

src, dst = pathlib.Path(sys.argv[1]), pathlib.Path(sys.argv[2])
dst.mkdir(parents=True, exist_ok=True)
for f in sorted(src.iterdir()):
    if f.suffix.lower() not in {".png", ".jpg", ".jpeg", ".webp", ".jfif"}:
        continue
    im = ImageOps.exif_transpose(Image.open(f)).convert("RGB")
    im = ImageOps.fit(im, (1200, 900), Image.LANCZOS, centering=(0.5, 0.5))  # 4:3 crop
    im.save(dst / f"{f.stem}.webp", "WEBP", quality=86, method=6)
    print("ok", f.stem)
```

Filenames must match the slugs above. Copy the resulting `.webp` files into `src/assets/products/`, overwriting the placeholders, and `site-data.ts` picks them up with no code changes.
