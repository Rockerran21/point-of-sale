<?php

namespace Modules\Currency\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Currency\Entities\Currency;

class CurrencyDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Currency::where('code', '!=', 'NRS')->delete();
        Currency::updateOrCreate(
            ['code' => Str::upper('NRS')],
            [
                'currency_name'      => 'Nepalese Rupee',
                'symbol'             => 'NRs ',
                'thousand_separator' => ',',
                'decimal_separator'  => '.',
                'exchange_rate'      => null
            ]
        );
    }
}
