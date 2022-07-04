{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Addons
@endsection

@section('content-header')
    <h1>Addon Overview<small>View all your addons.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.addons') }}">Addons</a></li>
        <li class="active">Index</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Addon List (TEST VIEW)</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th></th>
                            <th>Addon Name</th>
                            <th>UUID</th>
                            <th>Creator</th>
                            <th></th>
                            <th></th>
                        </tr>
                            <tr data-server="001">
                                <td><img src="https://pterodactylmarket.com/images/resources/169.webp" height="16px" /></td>
                                <td><a href="#">Simple Registration</a></td>
                                <td><code title="001">001</code></td>
                                <td>CoasterFreakDE</td>
                                <td class="text-center">
                                    <span class="label label-success">Installed</span>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-xs btn-default" href="#"><i class="fa fa-cog"></i></a>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-3 text-center">
        <a href="https://discord.gg/devsky" target="_blank"><button class="btn btn-warning" style="width:100%;"><i class="fa fa-fw fa-support"></i> Get Help <small>(via Discord)</small></button></a>
    </div>
    <div class="col-xs-6 col-sm-3 text-center">
        <a href="https://pterodactylmarket.com" target="_blank"><button class="btn btn-primary" style="width:100%;"><i class="fa fa-fw fa-link"></i> Marketplace</button></a>
    </div>
    <div class="clearfix visible-xs-block">&nbsp;</div>
    <div class="col-xs-6 col-sm-3 text-center">
        <a href="https://github.com/MelionCloud/PteroPanelFork" target="_blank"><button class="btn btn-primary" style="width:100%;"><i class="fa fa-fw fa-support"></i> Github</button></a>
    </div>
</div>
@endsection
