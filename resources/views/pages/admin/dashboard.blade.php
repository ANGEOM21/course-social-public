<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with()
    {
        return [
            'breadcrumbs' => [
                [
                    'text' => 'Home',
                    'url' => 'admin.dashboard',
                    'icon' => 'fa fa-home',
                ],
            ],
        ];
    }
};
?>


<div>
  <title>Dashboard {{ $app_name }}</title>
  <h1 class="text-2xl font-bold">Dashboard</h1>
  <x-breadcumbs :items="$breadcrumbs" />
</div>
