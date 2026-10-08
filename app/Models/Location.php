namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'building',
        'description',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}