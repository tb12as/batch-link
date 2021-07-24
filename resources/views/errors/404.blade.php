@extends('errors::bulma-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('message2')
    {!! 'We looked everywhere for this page. <br> Are you sure the URL is correct?' !!}
@endsection
