<form class="cart__coupon-form js-coupon-form w-100">
    <div class="flex-grow-1">
        <input type="text" class="form-control" id="input-coupon-code" placeholder="کد تخفیف"
            value="{{ $_cart->info['coupon'] ? $_cart->info['coupon']->code : '' }}">
        <small class="d-block mt-1" style="display: none"></small>
    </div>
    <button class="btn btn-primary d-flex align-items-center justify-content-center">اعمال
        کد تخفیف</button>
    <button type="button" class="btn btn-outline-danger js-revoke-btn" {!! $_cart->info['coupon'] ? '' : 'style="display:none"' !!}>
        <span class="fas fa-trash"></span>
    </button>
</form>
