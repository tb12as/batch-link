<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BladeMinified
{
    /**
     * Handle an incoming request.
     *
     * Source Code : https://github.com/dipeshsukhia/laravel-html-minify/blob/master/src/Middleware/LaravelMinifyHtml.php
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->isResponseObject($response) && $this->isHtmlResponse($response) && config('app.minified_blade')) {
            $replace = [
                '/\>[^\S ]+/s'                                                      => '>',
                '/[^\S ]+\</s'                                                      => '<',
                '/([\t ])+/s'                                                       => ' ',
                '/^([\t ])+/m'                                                      => '',
                '/([\t ])+$/m'                                                      => '',
                '~//[a-zA-Z0-9 ]+$~m'                                               => '',
                '/[\r\n]+([\t ]?[\r\n]+)+/s'                                        => "\n",
                '/\>[\r\n\t ]+\</s'                                                 => '><',
                '/}[\r\n\t ]+/s'                                                    => '}',
                '/}[\r\n\t ]+,[\r\n\t ]+/s'                                         => '},',
                '/\)[\r\n\t ]?{[\r\n\t ]+/s'                                        => '){',
                '/,[\r\n\t ]?{[\r\n\t ]+/s'                                         => ',{',
                '/\),[\r\n\t ]+/s'                                                  => '),',
                '~[\r\n]+~' => '', // remove new line
                '~([\r\n\t ])?([a-zA-Z0-9]+)=\"([a-zA-Z0-9_\\-]+)\"([\r\n\t ])?~s'  => '$1$2=$3$4',
            ];

            $response->setContent(preg_replace(array_keys($replace), array_values($replace), $response->getContent()));
        }

        return $response;
    }

    protected function isResponseObject($response)
    {
        return is_object($response) && $response instanceof Response;
    }

    protected function isHtmlResponse(Response $response)
    {
        return strtolower(strtok($response->headers->get('Content-Type'), ';')) === 'text/html';
    }
}
