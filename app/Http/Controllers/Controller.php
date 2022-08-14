<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Model;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function findObject(Model $model, $id, $name="instance") {

        try{
            $instance = $model->findOrFail($id);
        }catch (Exception $e){
            $error_str = "Not found this ".$name." by given id";
            return [
                "code" => 404,
                "error" => $error_str
            ];
        }
        return $instance;

    }
}
