<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code_products extends Model
{
    protected $primaryKey = 'id_code_products';
    protected $table = 'code_products';
    protected $fillable = ['sku', 'barcode', 'description', 'category', 'state'];

    public function pulpos()
    {
        return $this->hasMany(Pulpo::class, 'sku', 'sku');
    }
    public function etiqueta()
    {
        return $this->hasMany(Etiqueta::class, 'sku', 'sku');
    }
    public function receipts()
    {
        return $this->hasMany(Model_Receipt::class, 'order_num', 'sku');
    }
    public static function obtenerDescripcionPorSku($sku)
    {
        $producto = self::where('sku', $sku)->first();

        return $producto ? $producto->description : null;
    }
    public static function obtenerBarcodePorSku($sku)
    {
        $producto = self::where('sku', $sku)->first();

        return $producto ? $producto->barcode : null;
    }


    public static function obtenerSkusPorOrden($orderNum)
    {
        return self::whereHas('receipts', function ($query) use ($orderNum) {
            $query->where('order_num', $orderNum);
        })->pluck('sku');
    }
    public function products()
    {
        return $this->hasMany(Model_Products::class, 'sku', 'sku');
    }
}
