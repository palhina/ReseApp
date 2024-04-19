<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SplFileObject;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CsvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {

        return [
            "csv_file" => ['required', 'file', 'mimes:csv,txt'],
            'csv_array' => ['required', 'array'],
            'csv_array.*.area_id' => ['required'],
            'csv_array.*.genre_id' => ['required'],
            'csv_array.*.shop_name' => ['required', 'string', 'max:50'],
            'csv_array.*.shop_photo' => ['required','ends_with:.jpg,.jpeg,.png'],
            'csv_array.*.shop_comment' => ['required', 'string', 'max:400'],
        ];
    }

    protected function prepareForValidation()
    {
        $file = $this->file('csv_file');
        if( $file !== null&&$file->getClientOriginalExtension() == "csv"){
            $file_path = $this->file('csv_file')->path();

            $file = new SplFileObject($file_path);
            $file->setFlags(
                SplFileObject::READ_CSV |
                SplFileObject::READ_AHEAD |
                SplFileObject::SKIP_EMPTY |
                SplFileObject::DROP_NEW_LINE
            );
            foreach ($file as $index => $line) {
                if (empty($header)) {
                    $header = $line;
                    continue;
                }

                $areaName = $line[0];
                $area = Area::where('shop_area', $areaName)->first();
                if (!$area) {
                    throw ValidationException::withMessages([
                        'csv_file' => '地域は東京都、大阪府、福岡県のいずれかで記入してください',
                    ]);
                }
                $genreName = $line[1];
                $genre = Genre::where('shop_genre', $genreName)->first();
                if (!$genre) {
                    throw ValidationException::withMessages([
                        'csv_file' => 'ジャンルは寿司、焼肉、イタリアン、居酒屋、ラーメンのいずれかで記入してください',
                    ]);
                }

                $csv_array[$index]['area_id'] = $area->id;
                $csv_array[$index]['genre_id'] = $genre->id;
                $csv_array[$index]['shop_name'] = $line[2];
                $csv_array[$index]['shop_photo'] = $line[3];
                $csv_array[$index]['shop_comment'] = $line[4];
            }
            $this->merge([
                'csv_array' => $csv_array,
            ]);
        }
    }
    public function messages()
    {
        return [
            'csv_file.required' => 'ファイルを選択してください',
            'csv_file.file' => 'ファイルを選択してください',
            'csv_file.mimes' => 'CSV形式のファイルを選択してください',
            'csv_array.required' =>'CSVファイルは正しい形式で入力してください',
            'csv_array.array' =>'CSVファイルは正しい形式で入力してください',
            'csv_array.*.area_id.required' => 'エリアを入力して下さい',
            'csv_array.*.genre_id.required' => 'ジャンルを入力して下さい',
            'csv_array.*.shop_name.required' => '店舗名を入力して下さい',
            'csv_array.*.shop_name.string' => '店舗名は文字列で入力して下さい',
            'csv_array.*.shop_name.max' => '店舗名は50文字以内で入力して下さい',
            'csv_array.*.shop_photo.required' => '店舗画像を入力してください',
            'csv_array.*.shop_photo.ends_with' => '画像はJPEGまたはPNG形式で入力してください',
            'csv_array.*.shop_comment.required' => '店舗概要を入力してください',
            'csv_array.*.shop_comment.string' => '店舗概要は文字列で入力してください',
            'csv_array.*.shop_comment.max' => '店舗概要は400字以内で入力してください',
        ];
    }
}
