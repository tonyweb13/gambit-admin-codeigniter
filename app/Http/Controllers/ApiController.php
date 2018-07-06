<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Exception;

class ApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const HTTP_STATUS_NOT_FOUND = 404;
    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;
    const HTTP_STATUS_OK = 200;
	const HTTP_STATUS_FORBIDDEN_ERROR = 403;
	const HTTP_UNPROCESSABLE_ENTITY = 422;

    const API_ERR_PAGE_NOT_FOUND = 21;
    const API_ERR_SERVER_ERROR = 20;
	const API_ERR_FORBIDDEN = 22;
	const API_ERR_RESOURCE_CREATE_NOT_ALLOWED = 23;
	const API_ERR_VALIDATION = 24;

    /**
     * @var int
     */
    protected $statusCode;

	protected $exception;

	/**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * responseNotFound.
     *
     *
     * @param string $message
     */
    public function responseNotFound($message = 'Not Found.')
    {
        return $this->setStatusCode(self::HTTP_STATUS_NOT_FOUND)->respondWithError($message, self::API_ERR_PAGE_NOT_FOUND);
    }

	/**
	 * responseServerError.
	 *
	 *
	 * @param string $message
	 * @param Exception $e
	 * @return
	 */
    public function responseServerError($message = 'Server Error!', $e=null)
    {
	    $this->exception = $e;
        return $this->setStatusCode(self::HTTP_STATUS_INTERNAL_SERVER_ERROR)->respondWithError($message, self::API_ERR_SERVER_ERROR);
    }

	/**
	 * responseForbidden.
	 *
	 *
	 * @param string $message
	 * @param null $code
	 * @return
	 */
	public function responseForbidden($message = 'Forbidden.', $code=null)
	{
		$code = $code ?: self::API_ERR_FORBIDDEN;
		return $this->setStatusCode(self::HTTP_STATUS_FORBIDDEN_ERROR)->respondWithError($message, $code);
	}

    /**
     * respondWithError.
     *
     *
     * @param $message
     * @param $code
     *
     * @return
     */
    public function respondWithError($message, $code)
    {
	    $error = [
		    'message' => $message,
		    'code' => $code,
	    ];

	    if ($this->exception instanceof Exception) {
		    $error['exception'] = [
			    get_class($this->exception) => [
				    'message' => $this->exception->getMessage(),
				    'code' => $this->exception->getCode(),
				    'line' => $this->exception->getLine(),
			    ]
		    ];
	    }

        return $this->respond([
            'http_status_code' => $this->getStatusCode(),
            'error' => $error,
        ]);
    }

	/**
	 * respondWithPagination.
	 *
	 *
	 * @param \Illuminate\Pagination\LengthAwarePaginator $paginate
	 * @return LengthAwarePaginator
	 */
    public function respondWithPagination(LengthAwarePaginator $paginate)
    {
        return $paginate;
    }

	/**
	 * respondWithModel.
	 *
	 *
	 * @param array $transformed
	 *
	 */
    public function respondWithModel(array $transformed)
    {
	    return $this->setStatusCode(self::HTTP_STATUS_OK)->respond([
            'model' => $transformed,
        ]);
    }

	/**
	 * @param array $validations
	 * @return mixed
	 */
	public function responseValidationError(array $validations)
	{
		return $this->setStatusCode(self::HTTP_UNPROCESSABLE_ENTITY )->respond([
			'resource' => $validations['resource'],
			'error' => [
				'code' => self::API_ERR_VALIDATION,
				'validations' => $validations['issues'],
			],
		]);
	}

	/**
	 * @return int
	 */
	public static function getPerPage()
	{
		return request()->query->get('per_page', 10);
	}

	/**
	 * respond.
	 *
	 *
	 * @param $data
	 * @param array $headers
	 */
	public function respond($data, $headers = [])
	{
		return Response::json($data, $this->getStatusCode(), $headers);
	}
}
