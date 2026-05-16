<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Modules\Product\app\Models\Product;

class PackageTrx extends Model
{
    use SoftDeletes;

    protected $table = 'package_transactions';

    protected $fillable = ['id', 'provider_id', 'transaction_id	','trx_date', 'status', 'end_date', 'package_id', 'amount', 'payment_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'];

  /**
     * Define a relationship to the User model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

}
