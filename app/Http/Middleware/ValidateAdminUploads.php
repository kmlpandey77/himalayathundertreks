<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rejects unsafe files on every admin request before a controller can move them into public/uploads.
 *
 * Admin controllers name the stored file from the upload's detected extension and write it to a
 * public folder, so anything other than the expected types (scripts, SVG, HTML) must never get through.
 */
class ValidateAdminUploads
{
    /** Allowed by default: every admin upload field is an image. */
    protected const IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /** Fields that legitimately take something else. */
    protected const FIELD_TYPES = [
        'html_file' => ['html', 'htm'], // newsletter HTML template
    ];

    protected const MAX_KB = 10240;

    public function handle(Request $request, Closure $next): Response
    {
        $errors = [];

        foreach (Arr::dot($request->allFiles()) as $key => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $field = explode('.', $key)[0];
            $allowed = self::FIELD_TYPES[$field] ?? self::IMAGE_TYPES;
            $label = str_replace('_', ' ', $field);

            if (! $file->isValid()) {
                $errors[$key] = "The {$label} upload failed. Please try again.";
                continue;
            }

            // Both the real content type and the file name must be on the list.
            try {
                $detected = strtolower((string) $file->guessExtension());
            } catch (\Throwable) {
                $detected = ''; // unreadable file (e.g. locked by antivirus): reject
            }
            $named = strtolower($file->getClientOriginalExtension());

            if (! in_array($detected, $allowed, true) || ! in_array($named, $allowed, true)) {
                $errors[$key] = isset(self::FIELD_TYPES[$field])
                    ? "The {$label} must be a .".implode(' or .', $allowed).' file.'
                    : "The {$label} must be an image (JPG, PNG, GIF or WebP).";
                continue;
            }

            if ($file->getSize() > self::MAX_KB * 1024) {
                $errors[$key] = "The {$label} must be smaller than ".(self::MAX_KB / 1024).' MB.';
            }
        }

        if ($errors) {
            throw ValidationException::withMessages($errors);
        }

        return $next($request);
    }
}
