<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectTaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

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
}
