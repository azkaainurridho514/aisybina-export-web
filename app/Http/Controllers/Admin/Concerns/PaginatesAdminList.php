<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
trait PaginatesAdminList
{
    protected function lastPageRedirect(LengthAwarePaginator $paginator, string $routeName, array $params = [])
    {
        if ($paginator->isEmpty() && $paginator->currentPage() > 1) {
            return redirect()->route($routeName, array_filter(
                $params + ['page' => $paginator->lastPage()]
            ));
        }

        return null;
    }
}
