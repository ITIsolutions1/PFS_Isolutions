<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proposal;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;

class ProposalSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'rfp',
            'draft',
            'submitted',
            'awaiting_po',
            'awarded',
            'decline',
            'lost'
        ];

        $years = [2021, 2022, 2023, 2024, 2025];

        $leadIds = Lead::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        for ($i = 0; $i < 120; $i++) {
            $year = $years[array_rand($years)];
            $date = Carbon::create($year, rand(1, 12), rand(1, 28));

            Proposal::create([
                'lead_id'    => $leadIds[array_rand($leadIds)],
                'assign_to'  => $userIds[array_rand($userIds)],
                'title'      => 'Proposal ' . fake()->sentence(3),
                'status'     => $statuses[array_rand($statuses)],
                'description'=> fake()->paragraph(),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
