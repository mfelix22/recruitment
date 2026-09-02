<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBasicProfileComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isApplicant()) {
            $profile = $user->applicantProfile;

            if (! $profile || ! $profile->isBasicComplete()) {
                return redirect()->route('applicant.setup')
                    ->with('info', 'Lengkapi profil dasar Anda untuk melanjutkan.');
            }
        }

        return $next($request);
    }
}
