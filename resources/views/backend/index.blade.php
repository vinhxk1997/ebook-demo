@extends('backend.master')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-users"></i>
                </div>
                <div class="mr-5">{{ $user }} {{ trans('tran.user') }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('home') }}">
                <span class="float-left">{{ trans('tran.view_detail') }}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-book"></i>
                </div>
                <div class="mr-5">{{ $story }} {{ trans('tran.story') }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('story_admin') }}">
                <span class="float-left">{{ trans('tran.view_detail') }}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">{{ $comment }} {{ trans('tran.comment') }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('story_comment') }}">
                <span class="float-left">{{ trans('tran.view_detail') }}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">{{ $report }} {{ trans('tran.report') }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('report') }}">
                <span class="float-left">{{ trans('tran.view_detail') }}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">{{ $meta }} {{ trans('tran.meta') }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('categories') }}">
                <span class="float-left">{{ trans('tran.view_detail') }}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">11 {{ trans('tran.banner') }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">{{ trans('tran.view_detail') }}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-cog"></i>
                </div>
                <div class="mr-5">12 {{ trans('tran.config') }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">{{ trans('tran.view_detail') }}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-eye"></i>
                </div>
                <div class="mr-5">{{ $review }} {{ trans('tran.review') }}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('review') }}">
                <span class="float-left">{{ trans('tran.view_detail') }}</span>
                <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
</div>
@endsection
