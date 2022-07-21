@extends('adminlte::page')
@section('title', 'Clientes')
@livewireStyles
@section('content')
    <livewire:admin.customer-component>
    @stop

    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop

    @section('js')
        @livewireScripts
    @stop
