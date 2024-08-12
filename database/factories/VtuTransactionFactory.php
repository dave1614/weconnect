<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VtuTransaction>
 */
class VtuTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $types = [
            [
                'name' => 'airtime',
                'networks' => ['mtn', 'glo', 'airtel', '9mobile'],
                'numbers' => ['08163172393', '07039051017', '07043556722', '07068035855', '07014860887']

            ],
            [
                'name' => 'data',
                'networks' => ['mtn', 'glo', 'airtel', '9mobile'],
                'numbers' => ['08163172393', '07039051017', '07043556722', '07068035855', '07014860887']
            ],
            [
                'name' => 'electricity',
                'networks' => ['ikeja', 'eko', 'ibadan', 'benue'],
                'numbers' => ['54161058190', '0159000830178', '610124000763290', '43901642603', '25700193102']
            ],
        ];

        $type_index = rand(0, 2);

       
        $type = $types[$type_index];

        $curr_date = strtotime(date("j M Y h:i:sa"));
        $min_date = strtotime("-3 Months");

        $rand_date = rand($min_date, $curr_date);
        return [
            'user_id' => rand(10, 161),
            'type' => $type['name'],
            'sub_type' => $type['networks'][rand(0, 3)],
            'amount' => rand(100, 5000),
            'number' => $type['numbers'][rand(0, 4)],
            'order_id' => rand(10000, 10000000),
            'date' => date("j M Y", $rand_date),
            'time' => date("h:i:sa", $rand_date),
            'created_at' => date("Y-m-d H:i:s", $rand_date),
            'updated_at' => date("Y-m-d H:i:s", $rand_date),
        ];
    }
}
