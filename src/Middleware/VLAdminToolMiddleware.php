<?php

namespace Vuongdq\VLAdminTool\Middleware;

use App\Models\Role;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class VLAdminToolMiddleware extends Middleware
{
    protected function authenticate($request, array $guards) {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $user = $this->auth->guard($guard)->user();
                $roles = $user->roles;
                if (!empty($roles)) {
                    foreach ($roles as $role) {
                        if ($role->code == Role::SUPER_ADMIN) return $this->auth->shouldUse($guard);
                    }
                } else {
                    if ($user->id === (int)config('vl_admin_tool.admin_id', 1)) {
                        return $this->auth->shouldUse($guard);
                    }
                }
            }
        }

        $this->unauthenticated($request, $guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
