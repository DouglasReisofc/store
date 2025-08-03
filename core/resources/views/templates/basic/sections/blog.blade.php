@php
    $blog = getContent('blog.content', true);
    $blogs = getContent('blog.element');
@endphp
<!-- Blog Section -->
<section class="blog-section pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xxl-6">
                <div class="section__header text-center">
                    <span class="section__category">{{ __(@$blog->data_values->title) }}</span>
                    <h3 class="section__title">{{ __(@$blog->data_values->heading) }}</h3>
                    <p>
                        {{ __(@$blog->data_values->sub_heading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">

            @foreach($blogs as $singleblog)
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="post__item">
                        <div class="post__thumb">
                            <a href="{{ route('blog.details', ['slug'=>slug($singleblog->data_values->title), 'id'=>$singleblog->id]) }}">
                                <img src="{{ getImage('assets/images/frontend/blog/' .@$singleblog->data_values->image, '700x450') }}" alt="@lang('blog')">
                            </a>
                            <span class="category">
                                <i class="fa fa-eye"></i>
                                {{ $singleblog->view }}
                            </span>
                        </div>
                        <div class="post__content">
                            <h6 class="post__title">
                                <a href="{{ route('blog.details', ['slug'=>slug($singleblog->data_values->title), 'id'=>$singleblog->id]) }}">
                                    {{ __($singleblog->data_values->title) }}
                                </a>
                            </h6>
                            <div class="meta__date">
                                <div class="meta__item">
                                    <i class="las la-calendar"></i>
                                    {{ showDateTime($singleblog->created_at) }}
                                </div>
                                <div class="meta__item">
                                    <i class="las la-user"></i>
                                    @lang('Admin')
                                </div>
                            </div>
                            <a href="{{ route('blog.details', ['slug'=>slug($singleblog->data_values->title), 'id'=>$singleblog->id]) }}" class="post__read">
                                @lang('Read More')
                                <i class="las la-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
<!-- Blog Section -->
