<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavigationItem;

class NavigationItemsSeeder extends Seeder
{
    public function run(): void
    {
        NavigationItem::seedDefaultNavigation();
    }
}
