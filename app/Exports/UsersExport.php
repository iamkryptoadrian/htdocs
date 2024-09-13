<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class UsersExport implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        // Transform the collection to only include necessary fields
        return $this->users->map(function ($user, $key) {
            return [
                'S.No' => $key + 1,
                'Name' => $user->name,
                'Account ID' => $user->account_id,
                'Email' => $user->email,
                'Status' => $user->status ? 'Active' : 'Inactive',
                'Sponsor ID' => $user->sponsor_id,
                'User Investment' => $user->self_investment,
                'IsActive' => $user->IsActive ? 'Working' : 'Non Working',
                // Any other fields you want to include
            ];
        });
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Name',
            'Account ID',
            'Email',
            'Status',
            'Sponsor ID',
            'User Investment',
            'IsActive'
            // Any other headings
        ];
    }
}
