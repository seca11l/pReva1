<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pulpo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_pulpo'; // Opcional, asume 'id' por defecto

    protected $table = "pulpo";
    protected $fillable = ['supplier_code','order_num','notes','delivery_date','sku','requested_quantity','criterium','merchant_slug','merchant_channel_slug', 'state', 'created_at', 'updated_at'];

    public function recibo()
    {
        return $this->belongsTo(Model_Receipt::class, 'order_num', 'order_num');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_code', 'code');
    }
    public function code_products()
    {
        return $this->belongsTo(Code_products::class, 'sku', 'sku');
    }
    
    
}
