@extends('layout')
@section('title','home')
@section('content')
<x-cards :products="$products"></x-cards>
@endsection