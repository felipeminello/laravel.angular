<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ClientTransformer;
use Illuminate\Contracts\Support\Arrayable;
use Prettus\Repository\Presenter\FractalPresenter;

class ClientPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientTransformer();
    }
}
