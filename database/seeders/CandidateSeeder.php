<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $candidates = [
            [
                'name' => 'John Smith',
                'description' => 'Experienced public servant with 15 years in local government. Focused on education reform and infrastructure development.',
                'party' => 'Democratic Party',
                'image' => 'candidates/john-smith.jpg'
            ],
            [
                'name' => 'Sarah Johnson',
                'description' => 'Business leader and advocate for small business growth. Promises tax reform and economic stimulus packages.',
                'party' => 'Republican Party',
                'image' => 'candidates/sarah-johnson.jpg'
            ],
            [
                'name' => 'Michael Chen',
                'description' => 'Environmental scientist running on a platform of climate action and renewable energy investment.',
                'party' => 'Green Party',
                'image' => 'candidates/michael-chen.jpg'
            ],
            [
                'name' => 'Elizabeth Williams',
                'description' => 'Former judge campaigning for criminal justice reform and police accountability measures.',
                'party' => 'Democratic Party',
                'image' => 'candidates/elizabeth-williams.jpg'
            ],
            [
                'name' => 'Robert Taylor',
                'description' => 'Military veteran focused on national security and veterans affairs. Advocates for strong defense policies.',
                'party' => 'Republican Party',
                'image' => 'candidates/robert-taylor.jpg'
            ],
            [
                'name' => 'Maria Garcia',
                'description' => 'Community organizer running on platform of immigration reform and workers rights.',
                'party' => 'Progressive Party',
                'image' => 'candidates/maria-garcia.jpg'
            ],
            [
                'name' => 'David Wilson',
                'description' => 'Tech entrepreneur advocating for digital privacy laws and innovation-friendly policies.',
                'party' => 'Libertarian Party',
                'image' => 'candidates/david-wilson.jpg'
            ],
            [
                'name' => 'Jennifer Lee',
                'description' => 'Healthcare professional campaigning for universal healthcare and mental health services expansion.',
                'party' => 'Democratic Party',
                'image' => 'candidates/jennifer-lee.jpg'
            ],
            [
                'name' => 'James Brown',
                'description' => 'Farmer and agricultural advocate pushing for rural development and farming subsidies.',
                'party' => 'Independent',
                'image' => 'candidates/james-brown.jpg'
            ],
            [
                'name' => 'Patricia Miller',
                'description' => 'Education reform advocate with plan to increase teacher salaries and modernize school infrastructure.',
                'party' => 'Republican Party',
                'image' => 'candidates/patricia-miller.jpg'
            ]
        ];

        foreach ($candidates as $candidate) {
            DB::table('candidates')->insert([
                'name' => $candidate['name'],
                'description' => $candidate['description'],
                'image' => $candidate['image'],
                'party' => $candidate['party'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

}
