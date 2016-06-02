<?php
namespace BB\Service;

use BB\Exceptions\ServiceException;
use Pecee\Http\HttpResponse;
use Pecee\Http\Rest\IRestEventListener;
use Pecee\Http\Rest\RestBase;

abstract class ServiceBase extends RestBase implements IRestEventListener {

    const TYPE = '';
    const SERVICE_ENDPOINT = 'https://bookandbegin.com/api/v1/';
    const SERVICE_ENDPOINT_DEVELOPMENT = 'http://local.bookandbegin.com/api/v1/';

    protected $apiToken;

    /**
     * @var \Pecee\Http\HttpResponse
     */
    protected $httpResponse;

    public function __construct($apiToken) {
        $this->apiToken = $apiToken;

        parent::__construct();

        $serviceUrl = (getenv('DEBUG')) ? static::SERVICE_ENDPOINT_DEVELOPMENT : static::SERVICE_ENDPOINT;
        $this->serviceUrl = rtrim($serviceUrl, '/') . '/' . static::TYPE;

        $this->httpRequest->setOptions([
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $this->httpRequest->addHeader('X-Api-Token: ' . $this->apiToken);
        $this->httpRequest->setTimeout(20000);
    }

    /**
     * Parses the API-response and returns either a collection object or single item depending on the results.
     *
     * @param HttpResponse $httpResponse
     * @return mixed
     * @throws ServiceException
     */
    protected function onResponseReceived(HttpResponse $httpResponse) {

        $response = json_decode($httpResponse->getResponse());

        // Parse the results
        if(!is_object($response) || isset($response->error)) {
            $error = (isset($response->error)) ? $response->error : 'API returned invalid response: ' . $httpResponse->getUrl();
            $status = (isset($response->status)) ? $response->status : 0;

            throw new ServiceException($error, $status, $httpResponse);
        }

        // Check if the result is a collection of items
        if(isset($response->rows) && is_array($response->rows)) {

            $result = $this->onCreateCollection();

            // If the item is an instance of IServiceCollection we can set the response
            if(!($result instanceof IServiceCollection)) {
                throw new ServiceException('onCreateCollection must return object that implements the IServiceCollection interface.');
            }

            $result->setHttpResponse($httpResponse, $response);

            $items = array();

            foreach($response->rows as $row) {
                $item = $this->onCreateItem();

                if(!($item instanceof IServiceItem)) {
                    throw new ServiceException('onCreateItem must return object that implement the IServiceItem interface.');
                }

                $item->setRow($row);
                $items[] = $item;
            }

            $result->setRows($items);
            return $result;
        }

        // It wasn't a collection of items, so we just return a single item
        $item = $this->onCreateItem();

        if(!($item instanceof IServiceItem)) {
            throw new ServiceException('onCreateItem must return object that implement the IServiceItem interface.');
        }

        $item->setRow($response);
        return $item;
    }

    /**
     * @param null $url
     * @param string $method
     * @param array $data
     * @return static
     * @throws ServiceException
     */
    public function api($url = null, $method = self::METHOD_GET, array $data = array()) {

        $data = array_merge($this->httpRequest->getPostData(), $data);

        // Execute the API-call
        return $this->onResponseReceived( parent::api($url, $method, $data) );
    }

    /**
     * @return string
     */
    public function getApiToken() {
        return $this->apiToken;
    }

    /**
     * @return HttpResponse
     */
    public function getHttpResponse() {
        return $this->httpResponse;
    }

    public function setHttpResponse(HttpResponse $response, $formattedResponse) {
        $this->httpResponse = $response;
    }

}