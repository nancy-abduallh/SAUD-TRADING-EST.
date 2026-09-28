import { fileURLToPath } from "node:url";

import { defineConfig } from "vite";
import viteReact from "@vitejs/plugin-react";
import tailwindcss from "@tailwindcss/vite";
import tsConfigPaths from "vite-tsconfig-paths";
import { tanstackStart } from "@tanstack/react-start/plugin/vite";
import { nitro } from "nitro/vite";

// Plain local Vite config for TanStack Start — no external platform wrapper.
//
// Composes the same building blocks the previous Lovable-managed config used
// under the hood (tailwindcss, tsconfig-paths, tanstackStart, nitro, React),
// minus the Lovable-editor-only pieces (sandbox HMR bridge, remote asset
// proxy, telemetry hooks) that only ever did anything inside lovable.dev.
//
// `nitro`'s `cloudflare-module` preset matches src/server.ts's
// `{ fetch(request, env, ctx) }` export, so `npm run build` still produces a
// Cloudflare Pages/Workers-ready output. Point `preset` elsewhere (e.g.
// "node-server") if you deploy somewhere else.
export default defineConfig({
  server: {
    host: true, // all interfaces (IPv4-safe; "::" fails on machines without IPv6)
    port: 8080,
  },
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
    dedupe: [
      "react",
      "react-dom",
      "react/jsx-runtime",
      "react/jsx-dev-runtime",
      "@tanstack/react-query",
      "@tanstack/query-core",
    ],
  },
  plugins: [
    tailwindcss(),
    tsConfigPaths({ projects: ["./tsconfig.json"] }),
    tanstackStart({
      // Redirect TanStack Start's bundled server entry to src/server.ts (our SSR error wrapper).
      server: { entry: "server" },
      importProtection: {
        behavior: "error",
        client: { files: ["**/server/**"], specifiers: ["server-only"] },
      },
    }),
    nitro({ preset: "cloudflare-module" }),
    viteReact(),
  ],
});