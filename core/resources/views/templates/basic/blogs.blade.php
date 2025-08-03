@extends($activeTemplate.'layouts.frontend')
@section('content')
<!-- Blog Section Starts Here -->
<section class="blog-section pt-120 pb-120 bg--section">
    <div class="container">
        <div class="row g-4 justify-content-center">

            @forelse($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="post__item">
                        <div class="post__thumb">
                            <a href="{{ route('blog.details', ['slug'=>slug($blog->data_values->title), 'id'=>$blog->id]) }}">
                                <img src="{{ getImage('assets/images/frontend/blog/' .@$blog->data_values->image, '700x450') }}" alt="blog">
                            </a>
                            <span class="category">
                                <i class="fa fa-eye"></i>
                                {{ $blog->view }}
                            </span>
                        </div>
                        <div class="post__content">
                            <h6 class="post__title">
                                <a href="{{ route('blog.details', ['slug'=>slug($blog->data_values->title), 'id'=>$blog->id]) }}">
                                    {{ __($blog->data_values->title) }}
                                </a>
                            </h6>
                            <div class="meta__date">
                                <div class="meta__item">
                                    <i class="las la-calendar"></i>
                                    {{ showDateTime($blog->created_at) }}
                                </div>
                                <div class="meta__item">
                                    <i class="las la-user"></i>
                                    @lang('Admin')
                                </div>
                            </div>
                            <a href="{{ route('blog.details', ['slug'=>slug($blog->data_values->title), 'id'=>$blog->id]) }}" class="post__read">
                                @lang('Read More')
                                <i class="las la-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <h6 class="text-center">@lang('Data Not Found')</h6>
            @endforelse

        </div>
        {{ $blogs->links() }}
    </div>
</section>
<!-- Blog Section Ends Here -->
@endsection
