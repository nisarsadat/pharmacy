    <?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OwnerPickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'owener_name',
        'owener_phone',
        'amount',
        'note'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
