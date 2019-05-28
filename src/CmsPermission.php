<?php

namespace Stelssoft\YiiCmsCore;

class CmsPermission
{
    const ACCESS_INVALID = -1;
    const ACCESS_NONE = 0;
    const ACCESS_OVERVIEW = 10;
    const ACCESS_READ = 20;
    const ACCESS_COMMENT = 30;
    const ACCESS_ADD = 40;
    const ACCESS_EDIT = 50;
    const ACCESS_DELETE = 60;
    const ACCESS_ADMIN = 70;

    /**
     * @param null|int $level
     * @return array|string
     */
    public static function permissionLevel($level = null)
    {
        $levels = [];
        $levels[self::ACCESS_INVALID] = 'ACCESS INVALID';
        $levels[self::ACCESS_NONE] = 'ACCESS NONE';
        $levels[self::ACCESS_OVERVIEW] = 'ACCESS OVERVIEW';
        $levels[self::ACCESS_READ] = 'ACCESS READ';
        $levels[self::ACCESS_COMMENT] = 'ACCESS COMMENT';
        $levels[self::ACCESS_ADD] = 'ACCESS ADD';
        $levels[self::ACCESS_EDIT] = 'ACCESS EDIT';
        $levels[self::ACCESS_DELETE] = 'ACCESS DELETE';
        $levels[self::ACCESS_ADMIN] = 'ACCESS ADMIN';

        if (null !== $level && $levels[$level]) {
            return $levels[$level];
        }

        return $levels;
    }
}
