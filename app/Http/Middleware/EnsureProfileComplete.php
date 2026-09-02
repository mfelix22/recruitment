<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isApplicant()) {
            $profile = $user->applicantProfile;

            if (! $profile || ! $profile->isComplete()) {
                return redirect()->route('profile.edit')
                    ->with('warning', 'Harap lengkapi profil Anda terlebih dahulu sebelum melamar pekerjaan.');
            }
        }

        return $next($request);
    }
}
