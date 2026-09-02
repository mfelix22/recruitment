<?php

namespace App\Policies;

use App\Models\JobPosting;
use App\Models\User;

class JobPostingPolicy
{
    public function viewEmployer(User $user, JobPosting $job): bool
    {
        return $user->id === $job->employer_id;
    }

    public function update(User $user, JobPosting $job): bool
    {
        return $user->id === $job->employer_id;
    }

    public function delete(User $user, JobPosting $job): bool
    {
        return $user->id === $job->employer_id;
    }
}
