<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cost = rand(200,5000);
        return [
            "customer_id"=>rand(1,3),
            "material_type"=>"Cam Balkon",
            "material_amount"=>rand(1,5),
            "supplier_id"=>1,
            "unit_price_of_material"=>rand(0.01,99.99),
            "square_meters"=>rand(0.1,99.9),
            "earning"=>rand(1000,5000),
            "payment_type"=>"Nakit",
            "cost"=>$cost,
            "paid_payment"=>0,
            "pending_payment"=>$cost,
            "pay_date"=>rand(1,30)
        ];
    }
}
