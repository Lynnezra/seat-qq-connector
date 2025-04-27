<?php

namespace FeiBam\Seat\Connector\Drivers\QQ\Observers;

use Seat\Web\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileObserver
{
    /**
     * 监听 Seat 用户资料更新事件
     *
     * @param \Seat\Web\Models\User $user
     * @return void
     * @throws \Exception
     */
    public function updating(User $user)
    {
        // 确保当前有登录用户
        if (Auth::check()) {

            $current_user = Auth::user();

            // 如果当前登录用户不是管理员
            if (! $current_user->hasRole('admin')) {

                // 取出用户资料的原始 QQ
                $original_qq = $user->getOriginal('qq');

                // 取出用户资料的即将更新的 QQ
                $new_qq = $user->qq;

                // 如果用户想要修改或者删除 QQ（只要变了）
                if ($original_qq !== $new_qq) {
                    throw new \Exception('禁止修改或删除QQ号,请联系管理员处理。');
                }
            }
        }
    }
}
