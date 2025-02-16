<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class dataHandler extends Controller
{
    public function importFromJson(Request $request)
    {
        $regions = $request->json()->all();

        $regions = json_decode($request->input('data'), true);

        foreach ($regions as $region) {
            // Simpan provinsi
            $province = Province::create([
                'namaProvinsi' => $region['provinsi']
            ]);

            // Simpan kota-kota dalam provinsi
            foreach ($region['kota'] as $cityName) {
                City::create([
                    'namaKota' => $cityName,
                    'province_id' => $province->id
                ]);
            }
        }

        return response()->json(['message' => 'Data imported successfully!']);
    }
}
