<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvRequest;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class CsvController extends Controller
{

    // CSVインポート画面表示
    public function csvUpload()
    {
        return view('csv_upload');
    }

    // CSVインポート処理
    public function importCsv(CsvRequest $request)
    {
        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $fp = fopen($path, 'r');
        fgetcsv($fp);
        while (($csvData = fgetcsv($fp)) !== FALSE) {
            $this->InsertCsvData($csvData);
        }
        fclose($fp);
        return redirect('/csv_upload')->with('result', '店舗情報を追加しました');
    }

    public function InsertCsvData($csvData)
    {
        $areaName = $csvData[0];
        $area = Area::where('shop_area', $areaName)->first();
        $genreName = $csvData[1];
        $genre = Genre::where('shop_genre', $genreName)->first();
        $shop = new Shop;
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->shop_name = $csvData[2];
        $shop->shop_photo = $csvData[3];
        $shop->shop_comment = $csvData[4];
        $shop->save();
    }
}
