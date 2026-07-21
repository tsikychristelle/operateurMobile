<?php

namespace App\Controllers;

use App\Models\PromotionModel;

class PromotionController extends BaseController
{
      public function getAll()
    {
        $model = new PromotionModel();
        $data['promotion'] = $model->findAll();
        return $data;
    }
}