<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectTaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class ProjectTaskPresenter
 *
 * @package namespace CodeProject\Presenters;
 */
class ProjectTaskPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectTaskTransformer();
    }

/*	public function present($data)
	{
		if( $data instanceof Arrayable )
		{
			$array = $data->toArray();

			return $array[0];
		}

		else {

		}

		return $data;
	}*/
}
