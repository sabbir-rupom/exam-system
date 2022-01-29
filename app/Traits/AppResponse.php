<?php

namespace App\Traits;

trait AppResponse
{
    private $httpCode = 200;
    private $view = '';
    private $headers = [];
    private $data = [];
    private $jsonResponse = [
        'success' => false,
        'message' => "",
        'html' => false,
        'data' => [],
    ];

    public function response() {
        if(config('app.view') == 'json') {
            return $this->json();
        } else {
            return $this->html();
        }
    }

    public function setHttpCode(int $code)
    {
        $this->httpCode = $code;
        return $this;
    }

    public function setView(string $view)
    {
        $this->view = $view;
        return $this;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function addJson(string $key, $value = null) {
        $this->jsonResponse[$key] = $value;

        return $this;
    }

    protected function html()
    {
        return view($this->view, $this->data);
    }

    protected function json()
    {
        $this->jsonResponse['data'] = $this->data;

        return response()->json(
            $this->jsonResponse,
            $this->httpCode,
            $this->headers
        );
    }
}
