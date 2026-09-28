import { Slot } from "@radix-ui/react-slot";
import { cva, type VariantProps } from "class-variance-authority";
import { forwardRef, type ButtonHTMLAttributes } from "react";

import { cn } from "@/lib/utils";

const buttonVariants = cva(
  "inline-flex h-11 items-center justify-center gap-2 rounded-lg border px-5 text-sm font-semibold transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50",
  {
    variants: {
      variant: {
        primary:
          "border-primary/80 bg-linear-to-br from-navy-2 to-navy text-primary-foreground shadow-[0_12px_30px_-12px_oklch(0.257_0.077_262.1/0.7)] hover:-translate-y-0.5 hover:brightness-125",
        gold:
          "gradient-bg-gold border-gold/60 text-ink shadow-[0_12px_32px_-10px_oklch(0.655_0.106_75.6/0.75)] hover:-translate-y-0.5 hover:brightness-110",
        glass: "border-pearl/30 bg-pearl/10 text-pearl backdrop-blur-md hover:border-gold/60 hover:bg-pearl/20",
        outline: "border-primary/20 bg-transparent text-primary hover:bg-primary hover:text-primary-foreground",
        ghost: "border-transparent bg-transparent text-foreground hover:bg-secondary",
      },
      size: {
        default: "h-11 px-5",
        lg: "h-14 px-8 text-base",
        icon: "size-11 p-0",
      },
    },
    defaultVariants: { variant: "primary", size: "default" },
  },
);

export type ButtonProps = ButtonHTMLAttributes<HTMLButtonElement> &
  VariantProps<typeof buttonVariants> & { asChild?: boolean };

const Button = forwardRef<HTMLButtonElement, ButtonProps>(
  ({ className, variant, size, asChild = false, ...props }, ref) => {
    const Comp = asChild ? Slot : "button";
    return <Comp ref={ref} className={cn(buttonVariants({ variant, size }), className)} {...props} />;
  },
);
Button.displayName = "Button";

export { Button, buttonVariants };