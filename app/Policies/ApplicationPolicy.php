<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    public function view(User $user, Application $application): bool
    {
        return $user->id === $application->applicant_id;
    }

    public function viewEmployer(User $user, Application $application): bool
    {
        return $user->id === $application->jobPosting->employer_id;
    }

    public function update(User $user, Application $application): bool
    {
        return $user->id === $application->jobPosting->employer_id;
    }

    public function downloadPdf(User $user, Application $application): bool
    {
        return $user->id === $application->jobPosting->employer_id;
    }
}
