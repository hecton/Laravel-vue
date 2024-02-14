<?php

namespace App\Repositories\Eloquent;
use App\Models\Pedido;
use App\Models\PedidoStatus;
use App\Repositories\Contracts\PedidoInterface;
use stdClass;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image as ResizeImage;

class PedidoRepository implements PedidoInterface
{
    public function __construct(
        protected Pedido $pedido,
        protected PedidoStatus $pedidoStatus
    ){}


    /**
     * createa order
     *
     * @param  array<mixed> $data
     * @return stdClass
     */
    public function create(array $data): stdClass
    {
        $pedido = $this->pedido->create($data);
        $this->setImages($pedido, $data['imagem']??null, $data['uploaded_images']??null);

        $pedido->imagem;

        return (object) $pedido->toArray();
    }


    /**
     * setImages
     *
     * @param  Pedido $pedido
     * @param  array<string|int> $imagem_ids
     * @param  array<UploadedFile> $files
     * @return array
     */
    public function setImages($pedido, array $images = null, array $files = null): array
    {
        $current_images = $pedido->imagem();
        $images = $images??[];

        if($files){
            foreach($files as $key => $file){
                $imagem_name = $pedido->id."_imagem_$key".time() . '.' . $file->extension();
                $capa_name = $pedido->id."_capa_$key".time() . '.' . $file->extension();

                $file->move(public_path('/img/pedido/imagens'), $imagem_name);
                ResizeImage::read( public_path('/img/pedido/imagens/'.$imagem_name) )
                    ->resize(90, 100)
                    ->save( public_path('/img/pedido/imagens/'.$capa_name) );


                $image = $pedido->imagem()->create([
                    'imagem' => $imagem_name,
                    'capa' => $capa_name
                ]);

                $images[] = $image->id;
            }
        }

        $current_images->each(function ($img) use ($images) {
            if(!in_array($img->id, $images)){
                $img->delete();
            }
        });

        return $images;
    }


    /**
     * update order
     *
     * @param  array<mixed> $data
     * @return stdClass
     */
    public function update(array $data): stdClass
    {
        $pedido = $this->pedido->find($data['id']);

        if(empty($pedido)){
            abort( response()->json([ 'msg' => 'pedido não  encontrado' ], 200 ) );
        }

        $pedido->update($data);
        $this->setImages($pedido, $data['imagem']??null, $data['uploaded_images']??null);
        $pedido->imagem;

        return (object) $pedido->toArray();
    }


    /**
     * get all pedidos or filter
     *
     * @param  mixed $filter - (optional) filter by name
     * @return array
     */
    public function getAll(string $filter = null): array
    {
        return $this->pedido
            ->with(['cliente:id,nome', 'pedido_status'])
            ->where(function ($query) use ($filter){
                if($filter){
                    $query->where('produto', 'like', "%$filter%");
                }
            })
            ->get()
            ->toArray();
    }


    /**
     * get all status avaliables
     *
     * @return array
     */
    public function getPedidoStatus(): array
    {
        return $this->pedidoStatus
            ->get()
            ->toArray();
    }

    /**
     * find by id
     *
     * @param  string|int $id
     * @return stdClass
     */
    public function findOne(string|int $id): stdClass
    {
        $order = $this->pedido
            ->with('imagem')
            ->find($id);

        if(empty($order)){
            abort( response()->json([ 'msg' => 'pedido não encontrado' ], 200 ) );
        }

        return (object) $order->toArray();
    }

    /**
     * delete a pedido
     *
     * @param  mixed $id
     * @return void
     */
    public function delete(string|int $id): void
    {
        $order = $this->pedido->find($id);

        if(empty($order)){
            abort( response()->json([ 'msg' => 'pedido não  encontrado' ], 200 ) );
        }

        $order->imagem->each(function($img) {
            $img->delete();
        });

        $order->delete();
    }
}
