<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectMemberTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectMemberPresenter
 *
 * @package namespace CodeProject\Presenters;
 */
class ProjectMemberPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectMemberTransformer();
    }
}
