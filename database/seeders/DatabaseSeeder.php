<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(LaratrustSeeder::class);
        DB::table('locations')->insert([
            ['name' => 'Depok', 'color' => '#f56954'],
        ]);

        DB::table('times')->insert([
            ['jam' => '09.00'],
            ['jam' => '09.30'],
            ['jam' => '10.00'],
            ['jam' => '10.30'],
            ['jam' => '11.00'],
            ['jam' => '11.30'],
            ['jam' => '12.00'],
            ['jam' => '12.30'],
            ['jam' => '13.00'],
            ['jam' => '13.30'],
            ['jam' => '14.00'],
            ['jam' => '14.30'],
            ['jam' => '15.00'],
            ['jam' => '15.30'],
            ['jam' => '16.00'],
            ['jam' => '16.30'],
            ['jam' => '17.00'],
            ['jam' => '17.30'],
            ['jam' => '18.00'],
            ['jam' => '18.30'],
            ['jam' => '19.00'],
            ['jam' => '19.30'],
            ['jam' => '20.00'],
            ['jam' => '20.30'],
            ['jam' => '21.00'],
        ]);

        DB::table('categories')->insert([
            ['name' => 'Basic Cut',],
            ['name' => 'Adult Cut',],
            ['name' => 'Shaving Only',],
            ['name' => 'Head Massage + Wash',],
            ['name' => 'Hair Coloring',],
        ]);

        DB::table('services')->insert([
            [
                'category_id' => 1,
                'name' => 'HAIRCUT',
                'duration' => 30,
                'price' => 35,
                'desc' => 'HAIRCUT',
            ],
            [
                'category_id' => 1,
                'name' => 'SHAVING',
                'duration' => 30,
                'price' => 35,
                'desc' => 'SHAVING',
            ],[
                'category_id' => 1,
                'name' => 'HAIR TONIC',
                'duration' => 30,
                'price' => 35,
                'desc' => 'HAIR TONIC',
            ],
            [
                'category_id' => 2,
                'name' => 'HAIR CUT',
                'duration' => 30,
                'price' => 45,
                'desc' => 'POTONG RAMBUT',
            ],
            [
                'category_id' => 2,
                'name' => 'SHAVING',
                'duration' => 30,
                'price' => 45,
                'desc' => null,
            ],[
                'category_id' => 2,
                'name' => 'HAIR WASH',
                'duration' => 30,
                'price' => 45,
                'desc' => null,
            ],[
                'category_id' => 2,
                'name' => 'HAIRTONIC',
                'duration' => 30,
                'price' => 45,
                'desc' => null,
            ],[
                'category_id' => 2,
                'name' => 'HEAD MASSAGE',
                'duration' => 30,
                'price' => 45,
                'desc' => null,
            ],[
                'category_id' => 2,
                'name' => 'STYLING POMADE / CLAY / POWDER',
                'duration' => 30,
                'price' => 35,
                'desc' => null,
            ],[
                'category_id' => 3,
                'name' => 'SHAVING ONLY',
                'duration' => 30,
                'price' => 20,
                'desc' => null,
            ],[
                'category_id' => 4,
                'name' => 'HEAD MASSAGE + WASH',
                'duration' => 30,
                'price' => 25,
                'desc' => null,
            ],[
                'category_id' => 5,
                'name' => 'BLACK',
                'duration' => 30,
                'price' => 90,
                'desc' => null,
            ],[
                'category_id' => 5,
                'name' => 'BLEACHING',
                'duration' => 30,
                'price' => 195,
                'desc' => null,
            ],[
                'category_id' => 5,
                'name' => 'FULL COLORING',
                'duration' => 30,
                'price' => 275,
                'desc' => null,
            ],
        ]);

        DB::table('payments')->insert([
            [
                'bank' => 'BRI',
                'cabang' => 'DEPOK',
                'an' => 'Boy',
                'norek' => '123456789',
            ],
            [
                'bank' => 'BNI',
                'cabang' => 'DEPOK',
                'an' => 'Bro',
                'norek' => '987654321',
            ],[
                'bank' => 'Mandiri',
                'cabang' => 'DEPOK',
                'an' => 'Bam',
                'norek' => '735327357234',
            ],
        ]);
    }
}
