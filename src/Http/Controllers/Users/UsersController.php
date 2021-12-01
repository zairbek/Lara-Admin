<?php

namespace Future\LaraAdmin\Http\Controllers\Users;

use Future\LaraAdmin\Http\Requests\User\IndexUserRequest;
use Future\LaraAdmin\Http\Requests\User\StoreUserRequest;
use Future\LaraAdmin\Http\Requests\User\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Future\LaraAdmin\Http\Controllers\Controller;
use Future\LaraAdmin\Models\User;
use Future\LaraAdmin\Repositories\RoleRepository;
use Future\LaraAdmin\Repositories\UserRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private RoleRepository $roleRepository;
    private UserRepository $userRepository;

    public function __construct(RoleRepository $roleRepository, UserRepository $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(IndexUserRequest $request)
    {
        $users = $this->userRepository
            ->search($request->get('field'), $request->get('search'))
            ->paginate(50);

        return view('future::pages.admin.settings.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = $this->roleRepository->all();

        return view('future::pages.admin.settings.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
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
     * @param \Future\LaraAdmin\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('roles');
        $roles = $this->roleRepository->all();

        return view('future::pages.admin.settings.users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $user->load('roles');
        $roles = $this->roleRepository->all();

        return view('future::pages.admin.settings.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \Future\LaraAdmin\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(UpdateUserRequest $request, User $user)
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
     * @param \Future\LaraAdmin\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function avatarUpdate(Request $request, User $user)
    {
        $request->validate([
            'avatar' => ['required', 'mimetypes:image/jpeg,image/png', 'max:10000']
        ]);

        $user->avatar = $request->avatar;
        $user->save();

        return back()->with('message', 'success');
    }
}
