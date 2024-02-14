<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected static function boot(){
        parent::boot();
        static::deleting(function($pedido){
            $pedido->imagem()->each(function ($img) {
                $img->delete();
            });
        });
    }


    /**
     * reference table
     *
     * @var string
     */
    protected $table = 'pedidos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'produto',
        'valor',
        'data',
        'cliente_id',
        'pedido_status_id',
        'ativo',
    ];

    /**
     * Get the cliente that owns the order
     *
     * @return BelongsTo
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Get the order status that owns the order
     *
     * @return BelongsTo
     */
    public function pedido_status(): BelongsTo
    {
        return $this->belongsTo(PedidoStatus::class, 'pedido_status_id');
    }

    /**
     * Get all of the imagem for the Pedido
     *
     * @return HasMany
     */
    public function imagem(): HasMany
    {
        return $this->hasMany(PedidoImagem::class, 'pedido_id');
    }
}
