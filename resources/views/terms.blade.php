@extends('layouts.main')
@php
    $pageTitle = 'Search Result';
@endphp
@section('main-container')
    <section data-anim-wrap class="pageHero -type-1" style="height: 420px; padding-top:160px;">
        <div class="pageHero__bg" data-anim-child="img-right cover-white delay-1">
            <img src="/img/search_result/search_result_hero.png" alt="search_result_hero">
        </div>
        <div class="container">
            <div class="row justify-center">
                <div class="col-auto" style="backdrop-filter: blur(2px); padding: 20px;">
                    <div class="pageHero__content text-center">
                        <h1 class="pageHero__title text-white">Terms & Conditions</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-100 mb-100">
        <div data-anim-wrap class="container">
            @if ($terms)
                <div style="white-space: pre-line;">
                    {!! trim($terms->content) !!}
                </div>
            @else
                <p>The terms and conditions have not been set yet.</p>
            @endif
        </div>
    </section>
    

@endsection
