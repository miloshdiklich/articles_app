import { z } from "zod";

export const userSchema = z.object({
    email: z
        .string({
            required_error: "Email address is required."
        })
        .email("Not a valid email address."),
    password: z
        .string({
            required_error: "Password is required."
        })
        .min(7, "Password must be at least 7 characters long")
        .max(32, "Password must be of maximum 32 characters")
    // .regex(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%&*-])[A-Za-z\d!@#$%&*-]{8,}$/),
}).required();
