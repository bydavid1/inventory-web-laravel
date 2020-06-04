<?php

use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Providers::class, 50)->create()->each(function ($provider) {
            $provider->posts()->save(factory(App\Post::class)->make());
        });
    }
}
