<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ETagMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Process the request
        $response = $next($request);
    
        // Check if the response is successful and has content
        if ($response->isSuccessful() && $response->getContent()) {
            // Create ETag
            $etag = md5($response->getContent());
            // Get old ETag from request headers
            $oldEtag = $request->headers->get('If-None-Match');
            //$response->headers->set('O-Tag',$oldEtag);            
            //set etag-header
            $response->headers->set('E-Tag', $etag);
    
            // Compare ETags
            if ($oldEtag === $etag) {
                // If ETags match, return 304 Not Modified
                return response(null, 304);
            }
        }
    
        return $response;
    }
    
}
