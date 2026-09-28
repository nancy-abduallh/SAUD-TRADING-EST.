/**
 * Client-side error reporting.
 *
 * Replaces the previous Lovable-editor-only hook (which only ever reported
 * anything when the app was running inside lovable.dev's preview iframe).
 * This version just logs to the console so nothing is silently swallowed
 * locally — swap the body of `reportError` for your own provider (Sentry,
 * PostHog, etc.) when you're ready to wire one up.
 */
export function reportError(
  error: unknown,
  context: Record<string, unknown> = {},
) {
  if (typeof window === "undefined") return;

  // Loaders and server fns commonly throw a raw Response; String(it) is the
  // opaque "[object Response]", so pull out the status and URL instead.
  const message =
    error instanceof Response
      ? `Response ${error.status}${error.url ? ` at ${error.url}` : ""}`
      : error instanceof Error
        ? error.message
        : String(error);

  console.error("[error-reporting]", message, {
    route: window.location.pathname,
    stack: error instanceof Error ? error.stack : undefined,
    ...context,
  });
}
