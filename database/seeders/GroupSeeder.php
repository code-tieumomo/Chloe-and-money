<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\SubGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupSeeder extends Seeder
{
    private array $groups = [
        [
            'name' => 'Required Expense',
            'subName' => [
                ['Food & Beverage', 'Outflow'],
                ['Transportation', 'Outflow'],
                ['Rentals', 'Outflow'],
                ['Water Bill', 'Outflow'],
                ['Phone Bill', 'Outflow'],
                ['Electricity Bill', 'Outflow'],
                ['Gas Bill', 'Outflow'],
                ['Television Bill', 'Outflow'],
                ['Internet Bill', 'Outflow'],
                ['Other Utilities Bills', 'Outflow'],
            ],
        ],
        [
            'name' => 'Up & Comers',
            'subName' => [
                ['Home Maintenance', 'Outflow'],
                ['Vehicle Maintenance', 'Outflow'],
                ['Medical Check-up', 'Outflow'],
                ['Insurances', 'Outflow'],
                ['Education', 'Outflow'],
                ['Housewares', 'Outflow'],
                ['Personal Items', 'Outflow'],
                ['Pest', 'Outflow'],
                ['Home Services', 'Outflow'],
                ['Other Expense', 'Outflow'],
            ],
        ],
        [
            'name' => 'Fun & Relax',
            'subName' => [
                ['Fitness', 'Outflow'],
                ['Makeup', 'Outflow'],
                ['Gifts & Donations', 'Outflow'],
                ['Streaming Service', 'Outflow'],
                ['Fun Money', 'Outflow'],
            ],
        ],
        [
            'name' => 'Investing & Debt Payments',
            'subName' => [
                ['Investment', 'Outflow'],
                ['Debt Collection', 'Outflow'],
                ['Debt', 'Outflow'],
                ['Loan', 'Outflow'],
                ['Repayment', 'Outflow'],
                ['Pay Interest', 'Outflow'],
                ['Collect Interest', 'Outflow'],
            ],
        ],
        [
            'name' => 'Income',
            'subName' => [
                ['Salary', 'Inflow'],
                ['Other Income', 'Inflow'],
            ],
        ],
        [
            'name' => 'Bank',
            'subName' => [
                ['Withdrawals', 'Inflow'],
                ['Deposits', 'Outflow'],
                ['Receive', 'Inflow'],
                ['Transfer', 'Outflow'],
            ],
        ],
        [
            'name' => 'Other',
            'subName' => [
                ['Outgoing transfer', 'Outflow'],
                ['Incoming transfer', 'Inflow'],
            ],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->groups as $group) {
            $created = Group::create([
                'name' => $group['name'],
                'slug' => Str::slug($group['name']),
                'description' => $group['name'],
            ]);

            foreach ($group['subName'] as $subGroup) {
                SubGroup::create([
                    'name' => $subGroup[0],
                    'slug' => Str::slug($subGroup[0]),
                    'description' => $subGroup[0],
                    'group_id' => $created->id,
                    'transaction_type' => $subGroup[1],
                ]);
            }
        }
    }
}
