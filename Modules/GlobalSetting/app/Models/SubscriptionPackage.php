<?php

namespace Modules\GlobalSetting\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class SubscriptionPackage
 *
 * @property int $id
 * @property int $order_by
 * @property string $package_title
 * @property float $price
 * @property string $package_term
 * @property string $package_duration
 * @property int $number_of_service
 * @property int $number_of_feature_service
 * @property int $number_of_product
 * @property int $number_of_service_order
 * @property int $number_of_locations
 * @property int $number_of_staff
 * @property string $subscription_type
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */

class SubscriptionPackage extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_by',
        'package_title',
        'is_default',
        'price',
        'package_term',
        'package_duration',
        'number_of_service',
        'number_of_feature_service',
        'number_of_product',
        'number_of_service_order',
        'number_of_locations',
        'number_of_staff',
        'subscription_type',
        'description',
        'status',
        'featured',
        'badge'
    ];
}
