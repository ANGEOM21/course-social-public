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
            [
                'route' => 'admin.categories',
                'segment' => 'admin/categories',
                'icon' => 'fa fa-list',
                'text' => 'Categories',
            ],
            [
                'route' => 'admin.courses.index',
                'segment' => 'admin/courses',
                'icon' => 'fa fa-graduation-cap',
                'text' => 'Courses',
            ],
            // [
            // GRUP / COLLAPSE PEMILIHAN
            // 'text' => 'Pemilihan',
            // 'icon' => 'fa fa-vote-yea',
            // 'segment' => 'admin/pemilihan',
            // 'children' => [],
            // ],

            [
                'route' => 'admin.settings.index',
                'segment' => 'admin/settings',
                'icon' => 'fa fa-cog',
                'text' => 'Settings',
            ],
        ];
    }


    public function menuList()
    {
        return [
            "landing_page" => [
                "beranda" => [
                    "text" => "Beranda",
                    "section" => "#hero"
                ],
                "about" => [
                    "text" => "Tentang Kami",
                    "section" => "#about",
                ],
                "journey" => [
                    "text" => "Roadmap",
                    "section" => "#journey",
                ],
                "program" => [
                    "text" => "Program",
                    "section" => "#program",
                ],
                "comunity" => [
                    "text" => "Komunitas",
                    "section" => "#community",
                ],

            ],
            "dashboard_student" => [
                "home" => [
                    "text" => "Home",
                    "route_name" => "landing.index",
                    "navigation" => false
                ],
                "dashboard" => [
                    "text" => "Dashboard",
                    "route_name" => "student.dashboard",
                    "navigation" => true,
                ],
                "catalog" => [
                    "text" => "Catalog",
                    "route_name" => 'student.catalog',
                    "navigation" => true
                ],
                "courses" => [
                    "text" => "My Courses",
                    "route_name" => "student.courses",
                    "navigation" => true
                ],
                "certificate" => [
                    "text" => "My Certificate",
                    "route_name" => 'student.certificates',
                    "navigation" => true
                ],
            ],
        ];
    }
}
