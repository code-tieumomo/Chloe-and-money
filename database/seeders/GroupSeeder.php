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
                'Food & Beverage',
                'Transportation',
                'Rentals',
                'Water Bill',
                'Phone Bill',
                'Electricity Bill',
                'Gas Bill',
                'Television Bill',
                'Internet Bill',
                'Other Utilities Bills',
            ],
        ],
        [
            'name' => 'Up & Comers',
            'subName' => [
                'Home Maintenance',
                'Vehicle Maintenance',
                'Medical Check-up',
                'Insurances',
                'Education',
                'Housewares',
                'Personal Items',
                'Pest',
                'Home Services',
                'Other Expense',
            ],
        ],
        [
            'name' => 'Fun & Relax',
            'subName' => [
                'Fitness',
                'Makeup',
                'Gifts & Donations',
                'Streaming Service',
                'Fun Money',
            ],
        ],
        [
            'name' => 'Investing & Debt Payments',
            'subName' => [
                'Investment',
                'Debt Collection',
                'Debt',
                'Loan',
                'Repayment',
                'Pay Interest',
                'Collect Interest',
            ],
        ],
        [
            'name' => 'Income',
            'subName' => [
                'Salary',
                'Other Income',
            ],
        ],
        [
            'name' => 'Other',
            'subName' => [
                'Outgoing transfer',
                'Incoming transfer',
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
                    'name' => $subGroup,
                    'slug' => Str::slug($subGroup),
                    'description' => $subGroup,
                    'group_id' => $created->id,
                ]);
            }
        }
    }
}
