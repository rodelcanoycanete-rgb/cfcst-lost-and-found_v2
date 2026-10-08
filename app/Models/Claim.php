namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim : Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'proof_description',
        'status',
        'admin_notes',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}