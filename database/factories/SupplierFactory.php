<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name"=>"SağlıkPen Tekirdağ",
            "material_type"=>"Cam Balkon",
            "iban"=>"99999999999999"
        ];
    }
}
