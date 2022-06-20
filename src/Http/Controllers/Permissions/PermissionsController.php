<?php

namespace Future\LaraAdmin\Http\Controllers\Permissions;

use Future\LaraAdmin\Http\Controllers\Controller;
use Future\LaraAdmin\Http\Requests\Permission\CreatePermissionRequest;
use Future\LaraAdmin\Http\Requests\Permission\EditPermissionRequest;
use Future\LaraAdmin\Http\Requests\Permission\IndexPermissionRequest;
use Future\LaraAdmin\Http\Requests\Permission\ShowPermissionRequest;
use Future\LaraAdmin\Http\Requests\Permission\StorePermissionRequest;
use Future\LaraAdmin\Http\Requests\Permission\UpdatePermissionRequest;
use Future\LaraAdmin\Repositories\PermissionRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Throwable;

class PermissionsController extends Controller
{
    private PermissionRepository $permissionRepository;

	/**
	 * PermissionsController constructor.
	 * @param PermissionRepository $permissionRepository
	 */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @param IndexPermissionRequest $request
	 * @return Application|Factory|View
	 */
    public function index(IndexPermissionRequest $request): View|Factory|Application
	{
        $permissions = $this->permissionRepository
            ->search($request->get('field'), $request->get('search'))
            ->paginate(50);

        return view('future::pages.admin.settings.permissions.index', compact('permissions'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param CreatePermissionRequest $request
	 * @return Application|Factory|View
	 */
    public function create(CreatePermissionRequest $request): View|Factory|Application
	{
        return view('future::pages.admin.settings.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePermissionRequest $request
     * @return Application|RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(StorePermissionRequest $request): Redirector|RedirectResponse|Application
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
	 * @param ShowPermissionRequest $request
	 * @param Permission $permission
	 * @return Application|Factory|View
	 */
    public function show(ShowPermissionRequest $request, Permission $permission): View|Factory|Application
	{
        $permission = $this->getPermissionCurrentPermissionModel($permission);

        return view('future::pages.admin.settings.permissions.show', compact('permission'));
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param EditPermissionRequest $request
	 * @param Permission $permission
	 * @return Application|Factory|View
	 */
    public function edit(EditPermissionRequest $request, Permission $permission): View|Factory|Application
	{
        $permission = $this->getPermissionCurrentPermissionModel($permission);

        return view('future::pages.admin.settings.permissions.edit', compact( 'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePermissionRequest $request
     * @param Permission $permission
     * @return Application|Redirector|RedirectResponse
     * @throws Throwable
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): Redirector|RedirectResponse|Application
	{
        $permission = $this->getPermissionCurrentPermissionModel($permission);

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

    private function getPermissionCurrentPermissionModel(
        Permission $permission
    ): \Spatie\Permission\Contracts\Permission
    {
        return app(
            config('permission.models.permission')
        )::find($permission->id);
    }
}
