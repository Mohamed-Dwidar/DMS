<?php

namespace Modules\InvoiceModule\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Modules\InvoiceModule\app\Models\Invoice;

class InvoiceModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        DB::table('invoices')->truncate();
        Invoice::create([
            'name' => 'Cairo',
            'country' => 'Egypt',
            'hotel' => 'Cairo Marriott Hotel & Omar Khayyam Casino',
            'hotel_link' => 'https://www.marriott.com/en-us/hotels/caima-cairo-marriott-hotel-and-omar-khayyam-casino/overview/',
            'price_1w' => 1000,
            'price_2w' => 1800,
            'price_3w' => 2500,
            'price_4w' => 3200,
            'price_8w' => 6000,
            'price_3m' => 7000,
            'price_6m' => 13000,
            'price_9m' => 18000,
            'price_1y' => 24000,
            'price_2y' => 45000,
            'week_start' => 'sun',  // default to Sunday
            'image' => 'cit_1754283399.png',
            ]);
        Invoice::create([
            'name' => 'Abu Dhabi',
            'country' => 'UAE',
            'hotel' => 'Emirates Palace',
            'hotel_link' => 'https://www.jumeirah.com/en/stay/abu-dhabi/emirates-palace',
            'price_1w' => 1200,
            'price_2w' => 2200,
            'price_3w' => 3000,
            'price_4w' => 4000,
            'price_8w' => 7500,
            'price_3m' => 8500,
            'price_6m' => 16000,
            'price_9m' => 22000,
            'price_1y' => 30000,
            'price_2y' => 55000,
            'week_start' => 'mon',  // default to Sunday
            'image' => 'cit_1754983071.png', 
            ]);
        Invoice::create([
            'name' => 'Dubai',
            'country' => 'UAE',
            'hotel' => 'Atlantis The Palm',
            'hotel_link' => 'https://www.atlantis.com/dubai',
            'price_1w' => 1500,
            'price_2w' => 2800,
            'price_3w' => 4000,
            'price_4w' => 5000,
            'price_8w' => 9000,
            'price_3m' => 11000,
            'price_6m' => 20000,
            'price_9m' => 28000,
            'price_1y' => 38000,
            'price_2y' => 70000,
            'week_start' => 'mon',  // default to Sunday
            'image' => 'cit_1754983104.png',
            ]);
        Invoice::create([
            'name' => 'Doha',
            'country' => 'Qatar',
            'hotel' => 'The Ritz-Carlton, Doha',
            'hotel_link' => 'https://www.ritzcarlton.com/en/hotels/middle-east/qatar/ritz-carlton-doha',
            'price_1w' => 1100, 'price_2w' => 2000,'price_3w' => 2800,'price_4w' => 3600,'price_8w' => 6500,'price_3m' => 7500, 'price_6m' => 14000,'price_9m' => 19000,'price_1y' => 27000,'price_2y' => 50000,
            'week_start' => 'sun',  // default to Sunday
            'image' => 'cit_1754982982.png',
            ]);
        Invoice::create([
            'name' => 'Riyadh',
            'country' => 'Saudi Arabia',
            'hotel' => 'Four Seasons Hotel Riyadh at Kingdom Centre',
            'hotel_link' => 'https://www.fourseasons.com/riyadh/',
            'price_1w' => 1300,
            'price_2w' => 2400,
            'price_3w' => 3500,
            'price_4w' => 4500,
            'price_8w' => 8000,
            'price_3m' => 9500,
            'price_6m' => 18000,
            'price_9m' => 25000,
            'price_1y' => 35000,
            'price_2y' => 65000,
            'week_start' => 'sun',  // default to Sunday
            'image' => 'cit_1754283646.png',
            ]);
        Invoice::create([
            'name' => 'London',
            'country' => 'UK',
            'hotel' => 'The Ritz London',
            'hotel_link' => 'https://www.theritzlondon.com/',
            'price_1w' => 2000,
            'price_2w' => 3600,
            'price_3w' => 5000,
            'price_4w' => 6500,
            'price_8w' => 12000,
            'price_3m' => 14000,
            'price_6m' => 26000,
            'price_9m' => 36000,
            'price_1y' => 50000,
            'price_2y' => 90000,
            'week_start' => 'mon',  // default to Sunday
            'image' => 'cit_1754283734.png',
            ]);
        Invoice::create([
            'name' => 'Paris',
            'country' => 'France',
            'hotel' => 'Le Meurice',
            'hotel_link' => 'https://www.dorchestercollection.com/en/paris/le-meurice/',
            'price_1w' => 2200,
            'price_2w' => 4000,
            'price_3w' => 5800,
            'price_4w' => 7500,
            'price_8w' => 14000,
            'price_3m' => 17000,
            'price_6m' => 32000,
            'price_9m' => 45000,
            'price_1y' => 60000,
            'price_2y' => 110000,
            'week_start' => 'mon',  // default to Sunday
            'image' => 'cit_1754283798.png',
            ]);
        Invoice::create([
            'name' => 'New York',
            'country' => 'USA',
            'hotel' => 'The St. Regis New York',
            'hotel_link' => 'https://www.marriott.com/en-us/hotels/nycxr-the-st-regis-new-york/overview/',
            'price_1w' => 2500,
            'price_2w' => 4500,
            'price_3w' => 6500,
            'price_4w' => 8500,
            'price_8w' => 16000,
            'price_3m' => 19000,
            'price_6m' => 36000,
            'price_9m' => 50000,
            'price_1y' => 70000,
            'price_2y' => 130000,
            'week_start' => 'mon',  // default to Sunday
            'image' => 'cit_1754283895.png',
            ]);
            Invoice::create([
            'name' => 'Amsterdam',
            'country' => 'Netherlands',
            'hotel' => 'Hotel Okura Amsterdam',
            'hotel_link' => 'https://www.okura.nl/en/hotel-okura-amsterdam/',
            'price_1w' => 2400,
            'price_2w' => 4300,
            'price_3w' => 6200,
            'price_4w' => 8200,
            'price_8w' => 15000,
            'price_3m' => 19000,
            'price_6m' => 35000,
            'price_9m' => 50000,
            'price_1y' => 68000,
            'price_2y' => 125000,
            'week_start' => 'mon',  // default to Sunday
            'image' => 'cit_1754284045.png',
            ]);
    }
}
