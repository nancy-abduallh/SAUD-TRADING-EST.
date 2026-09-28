# Saud Trading Est. — سعود التجارية

Corporate site for Saud Trading Est.: plastics & food commodity trading plus
AI-powered digital services, serving Saudi Arabia, Egypt and the UAE.

## Development

You need Node.js 20+ and npm.

```sh
git clone <this-repository-url>
cd <repository-name>
npm install
npm run dev
```

The dev server runs at `http://localhost:8080`.

## Scripts

- `npm run dev` — local dev server with HMR
- `npm run build` — production build (outputs a Cloudflare Pages/Workers-ready
  bundle via Nitro's `cloudflare-module` preset — see the comment in
  `vite.config.ts` if you deploy elsewhere)
- `npm run preview` — preview the production build locally
- `npm run lint` / `npm run format` — ESLint / Prettier

## Built with

- TanStack Start (React 19, file-based routing, SSR)
- TypeScript
- Tailwind CSS v4
- shadcn/ui + Radix primitives
- embla-carousel (hero slider)

## Project structure

```
src/
  assets/            images (logo, hero photos, sector photos)
  components/
    sections/        page sections (Navbar, HeroSlider, Catalogue, ...)
    ui/              shadcn/ui primitives
  lib/
    site-data.ts     all sector/product/vision/clients content in one place
    error-reporting.ts   console-based client error logger
    error-capture.ts / error-page.ts   SSR error handling
  routes/
    __root.tsx       document shell, fonts, favicon, meta
    index.tsx        home page (composes the sections)
public/
  favicon.ico, icon-192.png, icon-512.png, apple-touch-icon.png
```

To change site copy, sector/category/product data, values, clients, or the
comparison table, edit `src/lib/site-data.ts` — the section components read
from it directly.
