<?php

namespace App\Helpers;

use Obrainwave\AccessTree\Models\Role;
use Obrainwave\AccessTree\Models\UserRole;

class UserRoleHelper {

    public static function createUserRole(int $role_id, int $user_id): String
    {
        $role = Role::find($role_id);

        if ($role) {
            $user_role = new \Obrainwave\AccessTree\Models\UserRole();
            $user_role->user_id = $user_id;
            $user_role->role_id = $role->id;
            $user_role->save();
            return json_encode(['status' => 200, 'message' => 'User Role created successfully']);
        } else {
            return json_encode(['status' => 404, 'message' => 'Role not found']);
        }
    }

    public static function updateUserRole(int $role_id, int $user_id) : String
    {
        UserRole::where('user_id', $user_id)->delete();

            $role = Role::where('id', $role_id)->first();

            if($role)
            {
                $user_role = new UserRole();
                $user_role->user_id = $user_id;
                $user_role->role_id = $role->id;
                $user_role->save();
                return json_encode(['status' => 200, 'message' => 'User Role updatd successfully']);
            } else {
                return json_encode(['status' => 404, 'message' => 'Role not found']);
            }
    }
}