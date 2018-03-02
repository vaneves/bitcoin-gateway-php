<?php

use Illuminate\Database\Seeder;
use App\Models\Entities\User;
use App\Models\Entities\Item;
use App\Models\Entities\Invoice;
use App\Models\Enum\InvoiceStatus;
use App\Common\Generator;
use App\Common\Money;

class ExamplesSeeder extends Seeder
{
    public function run()
    {
        \DB::transaction(function () {
            $user = User::create([
                'name' => 'Van Neves',
                'email' => 'vaneves@vaneves.com',
                'token' => 'abcdefghijklmnopqrstuvwxyz',
                'password' => bcrypt('123456'),
            ]);

            /*for ($i = 0; $i < 100; $i++) {
                $invoice = Invoice::create([
                    'user_id' => $user->id,
                    'code' => Generator::guid(),
                    'address' => str_random(34),
                    'reference' => 'fake'. ($i + 1),
                    'price' => rand(5, 33) / rand(100, 250),
                    'status' => InvoiceStatus::CANCELED,
                    'notification_url' => 'http://localhost/test.php',
                ]);
            }*/

            $invoices = [
                ['address' => 'muZb7hrvojcq9ZQpuTiuZGQLCcNjGBKCEF'],
                ['address' => 'mgjkQvuy8MW1LPjkJUyt1FtwrtR337bn7i'],
                ['address' => 'mgC2qydZWBAm8AyrAMD5btcQL3ada1wHzw'],
                ['address' => 'mvuopZMW1oKttg6qiX6qZFRj7xfXSkRZHa'],
            ];

            $faker = \Faker\Factory::create();
            foreach ($invoices as $i => $in) {
                $items = [];
                $cont = rand(1, 5);
                $total = 0;
                for ($i = 0; $i < $cont; $i++) {
                    $price = 1 / rand(100, 1000);
                    $amount = rand(1, 3);
                    $total += ($price * $amount);
                    array_push($items, [
                        'name' => $faker->sentence(rand(2, 5)),
                        'price' => $price,
                        'amount' => $amount,
                    ]);
                }

                $invoice = Invoice::create([
                    'user_id' => $user->id,
                    'code' => Generator::guid(),
                    'address' => $in['address'],
                    'reference' => 'real'. ($i + 1),
                    'total' => $total,
                    'fee' => Money::calculateFee($total),
                    'status' => InvoiceStatus::WAITING,
                    'notification_url' => 'http://localhost/test.php',
                    'buyer_name' => $faker->name,
                    'buyer_email' => $faker->safeEmail,
                ]);
                
                foreach ($items as $item) {
                    Item::create([
                        'invoice_id' => $invoice->id,
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'amount' => $item['amount'],
                    ]);
                }
            }
        });
    }
}
