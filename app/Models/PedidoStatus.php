<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * reference table
     *
     * @var string
     */
    protected $table = 'pedido_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descricao',
    ];
}
