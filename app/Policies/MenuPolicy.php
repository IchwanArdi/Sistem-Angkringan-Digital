<?php
namespace App\Policies;

use App\Models\Menu;
use App\Models\User;

class MenuPolicy
{
    public function view(User $user, Menu $menu)
    {
        return $user->id === $menu->user_id;
    }

    public function update(User $user, Menu $menu)
    {
        return $user->id === $menu->user_id;
    }

    public function delete(User $user, Menu $menu)
    {
        return $user->id === $menu->user_id;
    }
}