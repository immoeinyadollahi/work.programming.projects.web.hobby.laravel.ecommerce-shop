<?php

namespace App\Exceptions;

use Throwable;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as IlluminateExceptionHandler;

class Handler extends IlluminateExceptionHandler
{
    public function register()
    {
        $this->renderable(function (Throwable $ex) {
            if ($ex instanceof ModelNotFoundException || $ex instanceof NotFoundHttpException) {
                _http_abort(404);
            }

            $handler = _get_config("http.module.exception_handler");
            if ($ex instanceof HttpException) {
                $status_code = $ex->getStatusCode();
                if ($handler) return $handler($ex);
                return response(null, $status_code);
            } else if (!config("app.debug")) {
                if ($handler) return $handler(new HttpException(500, $ex->getMessage(), HttpException::CTX_RAW));
                return response(null, 500);
            }
        });
    }
}
