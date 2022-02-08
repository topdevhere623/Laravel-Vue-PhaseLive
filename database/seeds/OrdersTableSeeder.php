<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();

        DB::table('orders')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2018/12/03',
                'updated_at' => '2018/12/03',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/01/08',
                'updated_at' => '2019/01/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/02/08',
                'updated_at' => '2019/02/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/03/08',
                'updated_at' => '2019/03/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/01/08',
                'updated_at' => '2019/01/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/04/08',
                'updated_at' => '2019/04/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/05/08',
                'updated_at' => '2019/05/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/06/08',
                'updated_at' => '2019/06/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/07/08',
                'updated_at' => '2019/07/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/08/08',
                'updated_at' => '2019/08/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/09/08',
                'updated_at' => '2019/09/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/10/08',
                'updated_at' => '2019/10/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
            [
                'created_at' => '2019/11/08',
                'updated_at' => '2019/11/08',
                'purchaser_id' => 1,
                'sub_total' => 345,
                'tax' => 69,
                'total' => 414,
                'status' => 'complete',
                'gateway' => null,
                'gateway_charge' => null,
            ],
        ]);
    }
}
