<?php

namespace App\Constant;

class MenuItem
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Invoke the class instance.
     */
    public function getMenuItemAdmin(): array
    {
        return [
            [
                'route' => 'admin.dashboard',
                'segment' => 'admin',
                'icon' => 'fa-duotone fa-solid fa-house',
                'text' => 'Dashboard',
            ],
            // [
                // GRUP / COLLAPSE PEMILIHAN
                // 'text' => 'Pemilihan',
                // 'icon' => 'fa fa-vote-yea',
                // 'segment' => 'admin/pemilihan',
                // 'children' => [],
            // ],
        ];
    }
}
