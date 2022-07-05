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
                            <th>Version</th>
                            <th>Creator</th>
                            <th>Released</th>
                            <th>Updated</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach ($addons as $addon)
                            <tr data-server="{{ $addon->uuidShort }}">
                                <td><img src="{{ $addon->image }}" height="16px"  alt="Logo"/></td>
                                <td><a href="{{ $addon->website }}">{{ $addon->name }}</a></td>
                                <td><code title="{{ $addon->uuid }}">{{ $addon->uuid }}</code></td>
                                <td>{{ $addon->version }}</td>
                                <td>{{ $addon->creator }}</td>
                                <td class="text-center">
                                    @if($addon->isEnabled())
                                        <span class="label label-success">Installed</span>
                                    @elseif($addon->isInstalled())
                                        <span class="label label-warning">Disabled</span>
                                    @else
                                        <span class="label label-danger">Not Installed</span>
                                    @endif
                                </td>
                                <td><code title="{{ $addon->created_at }}">{{ $addon->created_at }}</code></td>
                                <td><code title="{{ $addon->updated_at }}">{{ $addon->updated_at }}</code></td>
                                <td class="text-center">
                                    <a class="btn btn-xs btn-default" href="#"><i class="fa fa-cog"></i></a>
                                </td>
                            </tr>
                        @endforeach
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