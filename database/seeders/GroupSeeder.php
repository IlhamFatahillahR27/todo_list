<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->groupedItems() as $group) {
            \App\Models\Group::updateOrCreate($group);
        }
    }

    protected function groupedItems() {
        return [
            [
                'id' => 1,
                'title' => 'ON GOING',
                'is_default' => true,
            ],
            [
                'id' => 2,
                'title' => 'COMPLETED',
                'is_default' => true,
                'for_complete' => true,
            ],
        ];
    }
}
