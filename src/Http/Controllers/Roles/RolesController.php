<?php

namespace Future\LaraAdmin\Http\Controllers\Roles;

use Future\LaraAdmin\Http\Controllers\Controller;
use Future\LaraAdmin\Http\Requests\Role\CreateRoleRequest;
use Future\LaraAdmin\Http\Requests\Role\DeleteRoleRequest;
use Future\LaraAdmin\Http\Requests\Role\EditRoleRequest;
use Future\LaraAdmin\Http\Requests\Role\IndexRoleRequest;
use Future\LaraAdmin\Http\Requests\Role\ShowRoleRequest;
use Future\LaraAdmin\Http\Requests\Role\StoreRoleRequest;
use Future\LaraAdmin\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Future\LaraAdmin\Repositories\PermissionRepository;
use Future\LaraAdmin\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    private RoleRepository $roleRepository;
    private PermissionRepository $permissionRepository;

	/**
	 * RolesController constructor.
	 * @param RoleRepository $roleRepository
	 * @param PermissionRepository $permissionRepository
	 */
    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->authorizeResource(Role::class, 'role');
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @param IndexRoleRequest $request
	 * @return Application|Factory|View
	 */
    public function index(IndexRoleRequest $request): View|Factory|Application
	{
        $roles = $this->roleRepository
            ->search($request->get('field'), $request->get('search'))
            ->paginate(50);

        return view('future::pages.admin.settings.roles.index', compact('roles'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param CreateRoleRequest $request
	 * @return Application|Factory|View
	 */
    public function create(CreateRoleRequest $request): View|Factory|Application
	{
        $permissions = $this->permissionRepository->all();

        return view('future::pages.admin.settings.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     * @return Application|RedirectResponse|Redirector
	 */
    public function store(StoreRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = $this->roleRepository->create($request->get('title'), $request->get('name'));

            $permissions = collect($request->get('permissions'))->map(function ($status, $name) {
                return $status === 'on' ? $name : false;
            });

            $role->givePermissionTo($permissions);
            DB::commit();
            return redirect(route('future.pages.settings.roles.show', $role->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param ShowRoleRequest $request
	 * @param Role $role
	 * @return Application|Factory|View
	 */
    public function show(ShowRoleRequest $request, Role $role): View|Factory|Application
	{
        $role = $this->getRoleCurrentRoleModel($role);
        $permissions = $this->permissionRepository->all();

        return view('future::pages.admin.settings.roles.show', compact('role', 'permissions'));
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param EditRoleRequest $request
	 * @param Role $role
	 * @return Application|Factory|View
	 */
    public function edit(EditRoleRequest $request, Role $role): View|Factory|Application
	{
        $role = $this->getRoleCurrentRoleModel($role);
        $permissions = $this->permissionRepository->all();

        return view('future::pages.admin.settings.roles.edit', compact('role', 'permissions'));
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateRoleRequest $request
	 * @param Role $role
	 * @return Application|Redirector|RedirectResponse
	 */
    public function update(UpdateRoleRequest $request, Role $role): Redirector|RedirectResponse|Application
	{
        $role = $this->getRoleCurrentRoleModel($role);

        DB::beginTransaction();
        try {
            $role->fill($request->validated())->save();

            $permissions = collect($request->get('permissions'))->map(function ($status, $name) {
                return $status === 'on' ? $name : false;
            });

			$role->syncPermissions($permissions);
			DB::commit();
            return redirect(route('future.pages.settings.roles.show', $role->id));
        } catch (\Exception $exception) {
			DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DeleteRoleRequest $request
	 * @param Role $role
	 * @return RedirectResponse
	 */
    public function destroy(DeleteRoleRequest $request, Role $role): RedirectResponse
	{
        $role = $this->getRoleCurrentRoleModel($role);
        $role->delete();

        return back()->with('message', 'success');
    }

    private function getRoleCurrentRoleModel(Role $role): \Spatie\Permission\Contracts\Role
    {
        return app(
            config('permission.models.role')
        )::find($role->id);
    }
}
