import { useQuery } from "@tanstack/react-query";

const API =
    (import.meta.env as any).VITE_API_URL ??
    "http://localhost/SAUD-TRADING-EST/admin/public_api.php";

export function useSiteApi() {
    return useQuery({
        queryKey: ["site-data"],
        queryFn: async ({ signal }) => {
            const res = await fetch(API, { signal });
            if (!res.ok) throw new Error("API " + res.status);
            return res.json();
        },
        staleTime: 5 * 60_000, // don't refetch for 5 minutes
        retry: 1,
    });
}