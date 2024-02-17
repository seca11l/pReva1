<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_Products extends Model
{
    use HasFactory;
    protected $table = "product";
    protected $primaryKey = 'id_product'; // Ajusta esto según la clave primaria real de tu modelo
    protected $fillable = ['sku', 'description', 'unit_measurement', 'gross_weight', 'packaging_weight', 'net_weight', 'order_num', 'delivery_date', 'code_customer', 'notes', 'criterium','state'];

    public function recibo()
    {
        return $this->belongsTo(Model_Receipt::class, 'order_num', 'order_num')
            ->select('order_num', 'delivery_date', 'code_customer');
    }

    public function etiquetas()
    {
        return $this->hasMany(Etiqueta::class, 'sku', 'sku');
    }

    public function code_products()
    {
        return $this->belongsTo(Code_products::class, 'sku', 'sku');
    }
}


