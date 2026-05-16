<?php

namespace Modules\Product\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ChangesHistory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class Productmeta
 *
 * @property int $id
 * @property int $product_id
 * @property string $source_key
 * @property string $source_Values
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */

class Productmeta extends Model
{
    use SoftDeletes;

    protected $table = 'products_meta';

    protected $fillable = [
        'id',
        'product_id',
        'source_key', // Add source_key here
        'source_Values', // Add source_Values here
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    private function normalizeStoragePath(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        $path = trim((string) $path);

        if (preg_match('/^https?:\/\//i', $path)) {
            $parsedPath = parse_url($path, PHP_URL_PATH);

            if (!empty($parsedPath) && Str::contains($parsedPath, '/storage/')) {
                $path = $parsedPath;
            } else {
                // Keep external absolute URLs untouched (for CDN/S3-like values).
                return $path;
            }
        }

        if (Str::startsWith($path, '//')) {
            $parsedPath = parse_url(request()->getScheme() . ':' . $path, PHP_URL_PATH);
            if (!empty($parsedPath)) {
                $path = $parsedPath;
            }
        }

        $normalizedPath = ltrim($path, '/');

        if (Str::contains($normalizedPath, 'public/storage/')) {
            $normalizedPath = Str::after($normalizedPath, 'public/storage/');
        } elseif (Str::contains($normalizedPath, 'storage/')) {
            $normalizedPath = Str::after($normalizedPath, 'storage/');
        }

        return $normalizedPath;
    }
    
    public function showPrice() 
    {
        if(is_null($this->source_Values) || $this->source_Values=='') {
            return "";
        } else {
            $timed="";
            if($this->source_key=='Hourly')
            {
                $timed="/Hr";

            }
            if($this->source_key=='Minitue')
            {
                $timed="/Min";

            }
            if($this->source_key=='Minute')
            {
                $timed="/Min";

            }
            if($this->source_key=='Squre-metter')
            {
                $timed="/Sq-Mt";

            }
            if($this->source_key=='Square-feet')
            {
                $timed="/Sq-ft";
            }
            return $this->source_Values.$timed;

        }
    }

    public function showImage() {
        $image_source = asset('front/img/default-placeholder-image.png');
        if($this->source_Values=='' || is_null($this->source_Values))
        {
            $image_source = asset('front/img/default-placeholder-image.png');

        }else{
            $normalizedPath = $this->normalizeStoragePath($this->source_Values);

            if (!empty($normalizedPath) && preg_match('/^https?:\/\//i', $normalizedPath)) {
                $image_source = $normalizedPath;
            } elseif (!empty($normalizedPath)) {
                $existsOnPublicDisk = Storage::disk('public')->exists($normalizedPath);
                $existsInPublicStorage = is_file(public_path('storage/' . $normalizedPath));
                $existsInLegacyStorage = is_file(storage_path('app/public/' . $normalizedPath));

                if ($existsOnPublicDisk || $existsInPublicStorage || $existsInLegacyStorage) {
                    $image_source = url('storage/' . $normalizedPath);
                } else {
                    // Some hosting environments use custom storage mappings where local file checks can fail.
                    // Keep rendering a normalized storage URL instead of forcing a placeholder.
                    $image_source = url('storage/' . $normalizedPath);
                }
            }

        }
        return $image_source;

    }

    public static function boot()
    {
        parent::boot();

        static::updating(function ($currency_data) {
            $original = $currency_data->getOriginal();

            if ($original['name'] != $currency_data->name) {
                self::logChange($currency_data, 'name', $original['name'], $currency_data->name);
            }

            if ($original['code'] != $currency_data->code) {
                self::logChange($currency_data, 'code', $original['code'], $currency_data->code);
            }

            if ($original['status'] != $currency_data->status) {
                self::logChange($currency_data, 'status', $original['status'], $currency_data->status);
            }

            if ($original['is_default'] != $currency_data->is_default) {
                self::logChange($currency_data, 'is_default', $original['is_default'], $currency_data->is_default);
            }
        });
    }

    public static function logChange($currency_data, $field, $fromValue, $toValue)
    {
        ChangesHistory::create([
            'user_id'    => auth()->user()->id?? '1',
            'type_id'    => $currency_data->id,
            'type'       => 'currencies',
            'changed_by' => $currency_data->updated_by,
            'field_name' => ucfirst(str_replace('_', ' ', $field)),
            'from_value' => $fromValue,
            'to_value'   => $toValue,
        ]);
    }

    public static function setDefault($currencyId)
    {
        self::where('is_default', 1)->update(['is_default' => 0, 'updated_by' => auth()->user()->id?? '1']);
        self::where('id', $currencyId)->update(['is_default' => 1, 'updated_by' => auth()->user()->id?? '1']);
    }

}
