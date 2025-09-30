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
                "program" => [
                    "text" => "Program",
                    "section" => "#program",
                ],
                "comunity" => [
                    "text" => "Komunitas",
                    "section" => "#community",
                ],
                "contact" => [
                    "text" => "Kontak",
                    "section" => "#contact",
                ],

            ],
            "dashboard_student" => [
                "home" => [
                    "text" => "Home",
                    "route_name" => "landing.index",
                ],
                "dashboard" => [
                    "text" => "Dashboard",
                    "route_name" => "student.dashboard",
                ],
                "courses" => [
                    "text" => "Courses",
                    "route_name" => "student.courses",
                ],
                "catalog" => [
                    "text" => "Catalog",
                    "route_name" => null, // atau hapus kalau belum ada
                    "href" => "#catalog",
                ],
                "certificate" => [
                    "text" => "Certificate",
                    "route_name" => null,
                    "href" => "#certificate",
                ],
            ],
        ];
    }
}
