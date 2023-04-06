<?php

namespace App\Service;

use App\Entity\Folder;
use App\Entity\User;

class CheckFolder
{
    public function folderWhereUserIsAllowed(User $user, Folder $folderToCheck):bool{
        $allowedFolders = $user->getAllowedFolder();
        foreach ($allowedFolders as $folder) {
            if($folder == $folderToCheck)
            {
                return true;
            }
        }
        return false;
    }
}