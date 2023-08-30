<?php

namespace App\Http\Middleware;

use App\Enums\MethodEnum;
use App\Events\SomeEvent;
use App\Repositories\UserRoute\UserRouteDTO;
use App\Services\UserRoute\UserRouteService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            1,
            MethodEnum::from($request->getMethod()),
            $request->getRequestUri(),
        );
        if ($this->successInsertInDB($dto) === true) {
            SomeEvent::dispatch($dto->getUserId(), $dto->getRoute());
        };

        return $next($request);
    }

    private function successInsertInDB($dto): bool
    {
        if ($this->userRouteService->handle($dto) < 1) {
            return false;
        }
        return true;
    }
}
