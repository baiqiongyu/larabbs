<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @desc: 显示用户信息页面
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @author: lijiwei
     * @date: 2022/1/5
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * @desc: 编辑用户信息页面
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @author: lijiwei
     * @date: 2022/1/5
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * @desc: 修改个人资料
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @author: lijiwei
     * @date: 2022/1/5
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader,  User $user)
    {
        $data = $request->all();

        if($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatar', $user->id);
            if($request) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
