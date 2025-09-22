@extends('errors::minimal')

@section('title', __('Larangan Akses'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Larangan Akses untuk halaman ini'))
