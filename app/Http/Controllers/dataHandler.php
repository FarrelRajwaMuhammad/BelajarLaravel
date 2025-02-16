<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class dataHandler extends Controller
{
    public function importFromJson(Request $request)
    {
        $url = 'https://raw.githubusercontent.com/mtegarsantosa/json-nama-daerah-indonesia/refs/heads/master/regions.json';
        $response = Http::get($url);

        if ($response->failed()) {
            return response()->json(['message' => 'Gagal mengambil data'], 500);
        }

        $regions = $response->json();

        

        foreach ($regions as $region) {
            $province = Province::create([
                'namaProvinsi' => $region['provinsi']
            ]);

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
