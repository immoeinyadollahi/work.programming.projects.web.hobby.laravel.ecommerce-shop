<div class="reviews-list">
    <ol class="reviews-list__content">
        @foreach ($paginator->items() as $comment)
            <li class="reviews-list__item">
                <div class="review">
                    <div class="review__avatar"><img src="{{ $comment->user->profileImage->url }}"
                            alt="{{ $comment->user->fullname }}"></div>
                    <div class="review__content">
                        <div class="review__author">{{ $comment->user->fullname }}
                        </div>
                        <div class="review__rating">
                            <div class="rating">
                                <div class="rating__body">
                                    @foreach (range(1, 5) as $star)
                                        @php
                                            $is_active = $comment->rating >= $star;
                                        @endphp
                                        <svg class="rating__star{{ $is_active ? ' rating__star--active' : '' }}"
                                            width="13px" height="12px">
                                            <g class="rating__fill">
                                                <use xlink:href="/public/main/images/sprite.svg#star-normal">
                                                </use>
                                            </g>
                                            <g class="rating__stroke">
                                                <use xlink:href="/public/main/images/sprite.svg#star-normal-stroke">
                                                </use>
                                            </g>
                                        </svg>
                                        <div
                                            class="rating__star rating__star--only-edge{{ $is_active ? ' rating__star--active' : '' }}">
                                            <div class="rating__fill">
                                                <div class="fake-svg-icon"></div>
                                            </div>
                                            <div class="rating__stroke">
                                                <div class="fake-svg-icon"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="review__text">{{ $comment->text }}</div>
                        <div class="review__date">
                            {{ $_Date::formatDate($comment->created_at) }}
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ol>
    @if ($paginator->hasPages())
        <div class="reviews-list__pagination js-product-comments-pagination">
            {{ $paginator->links() }}
            <div class="d-flex justify-content-center">
                <div class="js-loading spinner-border mt-3" style="display: none"></div>
            </div>
        </div>
    @endif
</div>
