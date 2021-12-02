<?php

namespace Future\LaraAdmin\Http\Controllers\Users;

use Future\LaraAdmin\Http\Requests\User\CreateUserRequest;
use Future\LaraAdmin\Http\Requests\User\DeleteUserRequest;
use Future\LaraAdmin\Http\Requests\User\EditUserRequest;
use Future\LaraAdmin\Http\Requests\User\IndexUserRequest;
use Future\LaraAdmin\Http\Requests\User\ShowUserRequest;
use Future\LaraAdmin\Http\Requests\User\StoreUserRequest;
use Future\LaraAdmin\Http\Requests\User\UpdateUserRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Future\LaraAdmin\Http\Controllers\Controller;
use Future\LaraAdmin\Models\User;
use Future\LaraAdmin\Repositories\RoleRepository;
use Future\LaraAdmin\Repositories\UserRepository;
use Illuminate\Http\Request;
use Throwable;

class UsersController extends Controller
{
    private RoleRepository $roleRepository;
    private UserRepository $userRepository;

	/**
	 * UsersController constructor.
	 * @param RoleRepository $roleRepository
	 * @param UserRepository $userRepository
	 */
    public function __construct(RoleRepository $roleRepository, UserRepository $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @param IndexUserRequest $request
	 * @return Application|Factory|View
	 */
    public function index(IndexUserRequest $request): View|Factory|Application
	{
        $users = $this->userRepository
            ->search($request->get('field'), $request->get('search'))
            ->paginate(50);

        return view('future::pages.admin.settings.users.index', compact('users'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param CreateUserRequest $request
	 * @return Application|Factory|View
	 */
    public function create(CreateUserRequest $request): View|Factory|Application
	{
        $roles = $this->roleRepository->all();

        return view('future::pages.admin.settings.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return Application|RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(StoreUserRequest $request): Redirector|RedirectResponse|Application
	{
        DB::beginTransaction();
        try {
            $user = $this->userRepository->createUser($request->validated(), $request->roles);

            DB::commit();
            return redirect(route('future.pages.settings.users.show', $user->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('message', $exception->getMessage());
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param ShowUserRequest $request
	 * @param User $user
	 * @return Application|Factory|View
	 */
    public function show(ShowUserRequest $request, User $user): View|Factory|Application
	{
        $user->load('roles');
        $roles = $this->roleRepository->all();

        return view('future::pages.admin.settings.users.show', compact('user', 'roles'));
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param EditUserRequest $request
	 * @param User $user
	 * @return Application|Factory|View
	 */
    public function edit(EditUserRequest $request, User $user): View|Factory|Application
	{
        $user->load('roles');
        $roles = $this->roleRepository->all();

        return view('future::pages.admin.settings.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
	{
        $params = $request->validated();
        if (! $request->get('password')) {
            $params = $request->except('password');
        }

        DB::transaction(function () use ($user, $params) {
            $user->fill($params)->save();
            $user->syncRoles($params['roles']);
        });

		return redirect(route('future.pages.settings.users.show', $user->id));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DeleteUserRequest $request
	 * @param User $user
	 * @return RedirectResponse
	 */
    public function destroy(DeleteUserRequest $request, User $user): RedirectResponse
	{
        $user->delete();

        return back();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function avatarUpdate(Request $request, User $user): RedirectResponse
	{
        $request->validate([
            'avatar' => ['required', 'mimetypes:image/jpeg,image/png', 'max:10000']
        ]);

        $user->avatar = $request->avatar;
        $user->save();

        return back()->with('message', 'success');
    }
}
