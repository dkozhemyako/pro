<?php

namespace App\Http\Middleware;

use App\Enums\MethodEnum;
use App\Events\CategoryCreated;
use App\Repositories\UserRoute\UserRouteDTO;
use App\Services\UserRoute\UserRouteService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class UserRouteAction
{
    public function __construct
    (
        protected UserRouteService $userRouteService,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $dto = new UserRouteDTO
        (
            auth()->user()->id,
            MethodEnum::from($request->getMethod()),
            $request->getRequestUri(),
        );
        if (is_int($this->userRouteService->handle($dto)) > 0) {
            CategoryCreated::dispatch($dto->getUserId(), $dto->getRoute());
        };

        return $next($request);
    }
}
