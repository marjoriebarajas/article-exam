@extends('Admin::login-layouts')

@section('page-body')
<section id="mdc-inner">
        <div class="mdc-inner-title text-center">
            <h1>Article Details</h1>
        </div>
        <div class="container section-padding">
            <div class="row">
                <div class="container">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="post" id="post-1">
                        	@if($article->thumbnail)
                            <div class="article-thumbnail">          
                                <img src="{{ get_article_thumbnail_path($article->thumbnail) }}" alt="{{$article->title}}" height="50%" width="100%">
                            </div>
                            @endif
                            <div class="article-content">
                                <h3>{{ $article->title }}</h3>
                                <p>{!! $article->content !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-css')
<style type="text/css">
	.article-thumbnail {
	    position: relative;
	    overflow: hidden;
	    max-width: 749px;
	    max-height: 308px;
	}
	.article-thumbnail img {
	    -moz-transition: all .8s;
	    -webkit-transition: all .8s;
	    transition: all .8s;
	}
	.article-thumbnail:hover img {
	    opacity: .7;
	    -moz-transform: scale(1.1);
	    -webkit-transform: scale(1.1);
	    transform: scale(1.1);
	}
	.article-content h3 {
	    padding-top: 1.2rem;
	    color: #2c3e50;
	    font-weight: 600;
	}
</style>
@endsection