<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\StatusUpdateRepositoryContract;

class StatusUpdateService
{
    protected $statusUpdateRepositoryContract;
    
    public function __construct(StatusUpdateRepositoryContract $statusUpdateRepositoryContract)
    {
        $this->statusUpdateRepositoryContract = $statusUpdateRepositoryContract;
    }

    public function newStatus(array $data)
    {
        $userId = Auth::user()->id;

        $newData = [
            'user_id' => $userId,
            'status' => $data['status'],
        ];

        return $this->statusUpdateRepositoryContract->newStatus($newData);
    }
}