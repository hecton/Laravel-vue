<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoImagem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected static function boot(){
        parent::boot();
        static::deleting(function($visitor){
            $visitor->removeFile();
        });
    }

     /**
     * reference table
     *
     * @var string
     */
    protected $table = 'pedidos_imagens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'imagem',
        'capa'
    ];

    /**
     * return full path capa
     *
     * @return string
     */
    public function getCapaFullPathAttribute(): string
    {
        return public_path("/img/pedido/imagens/$this->capa");
    }

    /**
     * return full path imagem
     *
     * @return string
     */
    public function getImagemFullPathAttribute(): string
    {
        return public_path("/img/pedido/imagens/$this->imagem");
    }

    /**
     * remove files
     *
     * @return void
     */
    public function removeFile():  void
    {
        $capa = $this->capa_full_path;
        $imagem = $this->imagem_full_path;

        if(file_exists($capa)){
            @unlink($capa);
        }
        if(file_exists($imagem)){
            @unlink($imagem);
        }
    }
}
