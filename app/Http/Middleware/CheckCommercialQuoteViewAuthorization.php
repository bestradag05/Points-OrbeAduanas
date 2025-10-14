<?php

namespace App\Http\Middleware;

use App\Models\CommercialQuote;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckCommercialQuoteViewAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id_quote');
        $comercialQuote = CommercialQuote::find($id);

        if (!$comercialQuote || Gate::denies('view', $comercialQuote)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
