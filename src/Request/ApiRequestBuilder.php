<?php

namespace  Gajosu\LaravelHttpClient\Request;

use Gajosu\LaravelHttpClient\Contracts\HttpRequestBuilder;
use Gajosu\LaravelHttpClient\Contracts\Response;
use Gajosu\LaravelHttpClient\Traits\RequestCacheModule;
use Gajosu\LaravelHttpClient\Traits\RequestModule;
use GuzzleHttp\Client;

class ApiRequestBuilder implements HttpRequestBuilder
{
    use RequestCacheModule;
    use RequestModule;

    protected bool $verify_ssl = true;
    protected ?string $base_uri = null;
    protected ?string $method = 'GET';
    protected ?string $path = '/';
    protected array $headers = [];
    protected array $query = [];
    protected array $multipart = [];
    protected array $body = [];

    /**
     * Set method
     *
     * @param  string $method
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Set base uri
     *
     * @param  string $base_uri
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setBaseUri(string $base_uri): self
    {
        $this->base_uri = $base_uri;

        return $this;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set headers
     *
     * @param  array $headers
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * Set query string
     *
     * @param  array $query
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setQuery(array $query): self
    {
        $this->query = array_merge($this->query, $query);

        return $this;
    }

    /**
     * Set multipart
     *
     * @param  string $name
     * @param  string $contents
     * @param  ?string $file_name
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setMultipart(string $name, string $contents, string $file_name = null): self
    {
        $data = [
            'name' => $name,
            'contents' => $contents,
            'filename' => $file_name,
        ];

        if (! empty($file_name)) {
            $data['filename'] = $file_name;
        }

        $this->multipart[] = $data;

        return $this;
    }

    /**
     * Set body
     *
     * @param  array $body
     * @return \Gajosu\LaravelHttpClient\Request\ApiRequestBuilder
     */
    public function setBody(array $body): self
    {
        $this->body = array_merge($this->body, $body);

        return $this;
    }

    /**
     * Set verify ssl
     *
     * @param bool $verify_ssl
     * @return self
     */
    public function setVerifySsl(bool $verify_ssl): self
    {
        $this->verify_ssl = $verify_ssl;

        return $this;
    }

    /**
     * Get HTTP client
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient(): Client
    {
        $client_options = [
            'base_uri' => $this->base_uri,
        ];

        return new Client($client_options);
    }

    /**
     * Get response of the request
     *
     * @return \Gajosu\LaravelHttpClient\Contracts\Response
     */
    public function get(): Response
    {
        return $this->sendRequest();
    }

    /**
     * Alias for get()
     *
     * @return \Gajosu\LaravelHttpClient\Contracts\Response
     */
    public function send(): Response
    {
        return $this->get();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->sendRequest()->body();
    }
}
