<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'id_suppliers';
    protected $table = 'suppliers';
    protected $fillable = ['code', 'name', 'state'];


    public function pulpos()
    {
        return $this->hasMany(Pulpo::class, 'supplier_code', 'code');
    }
    public function receipts()
    {
        return $this->hasMany(Model_Receipt::class, 'supplier_id'); // Ajusta 'supplier_id' según la columna real en tu tabla 'receipts'
    }

}

