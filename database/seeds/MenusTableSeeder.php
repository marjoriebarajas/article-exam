<?php

use Illuminate\Database\Seeder;
use App\Modules\Admin\Models\Settings\Menu;
class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = new Menu;
        $timestamps = \Carbon\Carbon::now();
        $menu->truncate();
        $menu_datas = [
            ['id' => 1, 'name' => 'User Management', 'parent_id' => 0, 'order_number' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps],
            ['id' => 2, 'name' => 'Roles', 'parent_id' => 1, 'order_number' => 2, 'created_at' => $timestamps, 'updated_at' => $timestamps],
            ['id' => 3, 'name' => 'Users', 'parent_id' => 1, 'order_number' => 3, 'created_at' => $timestamps, 'updated_at' => $timestamps],
            ['id' => 4, 'name' => 'Article', 'parent_id' => 0, 'order_number' => 4, 'created_at' => $timestamps, 'updated_at' => $timestamps],
        ];
        $menu->insert($menu_datas);
        $this->command->info('Menus table seeded!');
    }
}