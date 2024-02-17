<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "tags";
    protected $primaryKey = 'id_tag'; // Ajusta esto según la clave primaria real de tu modelo

    protected $fillable = ['order_num', 'sku', 'description', 'delivery_date', 'amount', 'weight', 'customer', 'type', 'content', 'product_status', 'color', 'barcode', 'state'];

    public function recibo()
    {
        return $this->belongsTo(Model_Receipt::class, 'order_num', 'order_num')
            ->select('order_num', 'delivery_date', 'customer');
    }
    
    public function producto()
    {
        return $this->belongsTo(Model_Products::class, 'sku', 'sku')->select('sku', 'description');
    }
    
    public function code_products()
    {
        return $this->belongsTo(Code_products::class, 'sku', 'sku')->select('sku', 'description', 'barcode');
    }
}


