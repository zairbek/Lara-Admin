<?php

namespace Future\LaraAdmin\Http\Controllers\Permissions;

use Future\LaraAdmin\Http\Controllers\Controller;
use Future\LaraAdmin\Http\Requests\Permission\StorePermissionRequest;
use Future\LaraAdmin\Http\Requests\Permission\UpdatePermissionRequest;
use Future\LaraAdmin\Repositories\PermissionRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    private PermissionRepository $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $permissions = $this->permissionRepository
            ->search($request->get('field'), $request->get('search'))
            ->paginate(50);

        return view('future::pages.admin.settings.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('future::pages.admin.settings.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePermissionRequest $request
     * @return Application|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function store(StorePermissionRequest $request)
    {
        DB::beginTransaction();
        try {
            $permission = $this->permissionRepository->create($request->get('title'), $request->get('name'));

            DB::commit();
            return redirect(route('future.pages.settings.permissions.show', $permission->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }
    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     * @return Application|Factory|View
     */
    public function show(Permission $permission)
    {
        return view('future::pages.admin.settings.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return Application|Factory|View
     */
    public function edit(Permission $permission)
    {
        return view('future::pages.admin.settings.permissions.edit', compact( 'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePermissionRequest $request
     * @param Permission $permission
     * @return Application|Redirector|RedirectResponse
     * @throws \Throwable
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        DB::beginTransaction();
        try {
            $permission->fill($request->validated())->save();

            DB::commit();
            return redirect(route('future.pages.settings.permissions.show', $permission->id));
        } catch (\Exception $exception) {

            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }
}
