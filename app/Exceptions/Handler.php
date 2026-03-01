<?php

namespace App\Exceptions;

use App\Http\Helpers\AppHelper;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            Log::error('Unhandled Exception', [
                'exception' => get_class($exception),
                'message'   => $exception->getMessage(),
                'file'      => $exception->getFile(),
                'line'      => $exception->getLine(),
            ]);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Return JSON responses for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->renderJsonException($request, $exception);
        }

        if (method_exists($exception, 'getStatusCode')) {

            $statusCode = $exception->getStatusCode();

            if(!env('APP_DEBUG', false)) {
                if (!$request->user() && AppHelper::isFrontendEnabled()) {
                    $locale = Session::get('user_locale');
                    App::setLocale($locale);

                    if ($statusCode == 404) {
                        return response()->view('errors.front_404', [], 404);
                    }

                    if ($statusCode == 500) {
                        return response()->view('errors.front_500', [], 500);
                    }
                }
            }

            if ($request->user()) {
                if ($statusCode == 404) {
                    return response()->view('errors.back_404', [], 404);
                }

                if ($statusCode == 401) {
                    return response()->view('errors.back_401', [], 401);
                }

                if ($statusCode == 403) {
                    return response()->view('errors.back_401', [], 403);
                }
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Render a JSON error response for API requests.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJsonException($request, Exception $exception)
    {
        $statusCode = 500;
        $response = [
            'success' => false,
            'message' => 'An unexpected error occurred.',
        ];

        if ($exception instanceof ValidationException) {
            $statusCode = 422;
            $response['message'] = 'Validation failed.';
            $response['errors'] = $exception->errors();
        } elseif ($exception instanceof AuthenticationException) {
            $statusCode = 401;
            $response['message'] = 'Unauthenticated.';
        } elseif (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
            $response['message'] = $this->getHttpErrorMessage($statusCode);
        }

        if (env('APP_DEBUG', false)) {
            $response['debug'] = [
                'exception' => get_class($exception),
                'message'   => $exception->getMessage(),
                'file'      => $exception->getFile(),
                'line'      => $exception->getLine(),
            ];
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Get a human-readable message for common HTTP status codes.
     *
     * @param  int $statusCode
     * @return string
     */
    protected function getHttpErrorMessage($statusCode)
    {
        $messages = [
            400 => 'Bad request.',
            401 => 'Unauthorized access.',
            403 => 'Access forbidden.',
            404 => 'Resource not found.',
            405 => 'Method not allowed.',
            419 => 'Session expired. Please refresh and try again.',
            422 => 'Validation error.',
            429 => 'Too many requests. Please slow down.',
            500 => 'Internal server error.',
            503 => 'Service temporarily unavailable.',
        ];

        return $messages[$statusCode] ?? 'An error occurred.';
    }
}
